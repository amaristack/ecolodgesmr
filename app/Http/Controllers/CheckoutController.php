<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Booking;
use App\Models\Pool;
use App\Models\Room;
use App\Models\Hall;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class CheckoutController extends Controller
{

    public function book(Request $request)
    {
        try {
            // Validate the incoming request data
            $validatedData = $request->validate([
                'item_type' => 'required|string|in:rooms,cottages,activity,hall',
                'item_id' => 'required|integer',
                'quantity' => 'required|integer|min:1',
                'check_in' => 'required|date',
                'check_out' => 'required|date|after_or_equal:check_in',
                'note' => 'nullable|string|max:255',
            ]);

            // Assign foreign key based on item type in the request
            if ($request->filled('room_id')) {
                $item = Room::findOrFail($request->input('room_id'));
                $type = 'rooms';
                $itemId = $item->room_id;
            } elseif ($request->filled('pool_id')) {
                $item = Pool::findOrFail($request->input('pool_id'));
                $type = 'cottages';
                $itemId = $item->pool_id;
            } elseif ($request->filled('activity_id')) {
                $item = Activity::findOrFail($request->input('activity_id'));
                $type = 'activity';
                $itemId = $item->activity_id;
            } elseif ($request->filled('hall_id')) {
                $item = Hall::findOrFail($request->input('hall_id'));
                $type = 'hall';
                $itemId = $item->hall_id;
            } else {
                throw new \Exception('No valid item ID provided.');
            }

            // Calculate the payment amount based on the item's price
            $paymentAmount = $item->price * $request->input('quantity', 1);

            // Store booking data in the session
            $bookingData = [
                'user_id' => Auth::id(),
                'note' => $request->input('note'),
                'quantity' => $request->input('quantity', 1),
                'check_in' => $request->input('check_in'),
                'check_out' => $request->input('check_out'),
                'payment_amount' => $paymentAmount, // Ensure 'payment_amount' key exists
                'payment_method' => 'Gcash', // Default payment method
                'item_type' => $type,
                'item_id' => $itemId,
            ];

            $request->session()->put('booking_data', $bookingData);

            // Redirect to the payment options page
            return redirect()->route('user_paynow');
        } catch (\Exception $e) {
            Log::error('Booking failed: ' . $e->getMessage());
            return redirect()->route('payment-failure')->with('error', $e->getMessage());
        }
    }


    public function userPaynow()
    {
        // Retrieve booking data from the session
        $bookingData = session('booking_data');

        if (!$bookingData) {
            return redirect()->route('home')->with('error', 'No booking data found.');
        }

        // Fetch the item based on item_type and item_id
        switch ($bookingData['item_type']) {
            case 'rooms':
                $item = Room::findOrFail($bookingData['item_id']);
                break;
            case 'cottages':
                $item = Pool::findOrFail($bookingData['item_id']);
                break;
            case 'activity':
                $item = Activity::findOrFail($bookingData['item_id']);
                break;
            case 'hall':
                $item = Hall::findOrFail($bookingData['item_id']);
                break;
            default:
                $item = null;
                break;
        }

        // Calculate the total amount
        $subtotal = $item->price * $bookingData['quantity'];
        $downpayment = $subtotal * 0.5; // 50% downpayment

        // Update booking data in the session
        $bookingData['subtotal'] = $subtotal;
        $bookingData['downpayment'] = $downpayment;

        // Update the payment amount to the downpayment
        $bookingData['payment_amount'] = $downpayment;

        // Save updated booking data back to session
        session(['booking_data' => $bookingData]);

        return view('user.user_paynow', [
            'bookingData' => $bookingData,
            'item' => $item,
            'type' => $bookingData['item_type'],
        ]);
    }


    public function payWithPayMongo()
    {
        $bookingData = session('booking_data');
        if (!$bookingData) {
            return redirect()->route('home')->with('error', 'No booking data found.');
        }


        $amountInCentavos = (int)round($bookingData['payment_amount'] * 100);


        $payload = [
            'data' => [
                'attributes' => [
                    'amount' => $amountInCentavos, // Amount in centavos as integer
                    'redirect' => [
                        'success' => route('payment-success'),
                        'failed' => route('payment-failure'),
                    ],
                    'type' => 'gcash',
                    'currency' => 'PHP',
                ],
            ],
        ];


        Log::info('PayMongo Payload:', $payload);

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Basic ' . base64_encode(config('services.paymongo.secret_key') . ':'),
            'Content-Type' => 'application/json',
        ])->post('https://api.paymongo.com/v1/sources', $payload);

        // Check if the request was successful
        if ($response->successful()) {
            $responseData = $response->json();
            $checkoutUrl = $responseData['data']['attributes']['redirect']['checkout_url'];

            // Redirect to GCash checkout page
            return redirect($checkoutUrl);
        } else {
            // Log the error response for debugging
            Log::error('PayMongo Source Creation Failed:', [
                'status' => $response->status(),
                'response' => $response->json(),
            ]);

            // Handle failed API request
            return redirect()->route('payment-failure')->with('error', 'Failed to create payment source');
        }
    }


    public function success(Request $request)
    {
        $bookingData = session('booking_data');
        if (!$bookingData) {
            return redirect()->route('home')->with('error', 'No booking data found.');
        }

        // Check if the application is in local environment
        if (app()->environment('local')) {
            // Simulate payment verification success
            $paymentStatus = 'paid'; // Simulate a successful payment status
            Log::info('Simulating payment success for local environment.');
        } else {
            // Production environment - perform actual payment verification
            $sourceId = $request->query('source');
            if (!$sourceId) {
                return redirect()->route('payment-failure')->with('error', 'Payment source not found.');
            }

            // Retrieve the PayMongo secret key from the configuration
            $secretKey = config('services.paymongo.secret_key');

            if (!$secretKey) {
                Log::error('PayMongo Secret Key is not set in the configuration.');
                return redirect()->route('payment-failure')->with('error', 'Payment configuration error.');
            }

            // Verify the source status with PayMongo
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Authorization' => 'Basic ' . base64_encode($secretKey . ':'),
            ])->get("https://api.paymongo.com/v1/sources/{$sourceId}");

            if ($response->successful()) {
                $responseData = $response->json();
                $status = $responseData['data']['attributes']['status'];

                // Log the source response
                Log::info('Source Response:', $responseData);

                if ($status === 'chargeable') {
                    // Create a Payment using the chargeable source
                    $paymentPayload = [
                        'data' => [
                            'attributes' => [
                                'amount' => (int)round($bookingData['payment_amount'] * 100), // Downpayment amount in centavos
                                'source' => [
                                    'id' => $sourceId,
                                    'type' => 'source',
                                ],
                                'currency' => 'PHP',
                            ],
                        ],
                    ];

                    $paymentResponse = Http::withHeaders([
                        'Accept' => 'application/json',
                        'Authorization' => 'Basic ' . base64_encode($secretKey . ':'),
                        'Content-Type' => 'application/json',
                    ])->post('https://api.paymongo.com/v1/payments', $paymentPayload);

                    if ($paymentResponse->successful()) {
                        $paymentData = $paymentResponse->json();
                        $paymentStatus = $paymentData['data']['attributes']['status'];

                        // Log the payment response
                        Log::info('Payment Response:', $paymentData);

                        if ($paymentStatus === 'paid') {
                            // Payment successful, proceed to create booking
                            $this->createBooking($bookingData);

                            // Redirect to success page
                            return view('payment.payment-success');
                        } else {
                            return redirect()->route('payment-failure')->with('error', 'Payment was not successful.');
                        }
                    } else {
                        // Log payment creation failure
                        Log::error('Payment creation failed:', $paymentResponse->json());
                        return redirect()->route('payment-failure')->with('error', 'Failed to create payment.');
                    }
                } else {
                    return redirect()->route('payment-failure')->with('error', 'Payment was not successful.');
                }
            } else {
                // Log source verification failure
                Log::error('Source verification failed:', $response->json());
                return redirect()->route('payment-failure')->with('error', 'Failed to verify payment status.');
            }
        }

        if ($paymentStatus === 'paid') {
            // Proceed to create the booking
            $this->createBooking($bookingData);

            // Redirect to success page
            return view('payment.payment-success');
        } else {
            return redirect()->route('payment-failure')->with('error', 'Payment was not successful.');
        }
    }


    public function paymentFailure(Request $request)
    {
        $bookingData = $request->session()->get('booking_data');

        $type = null;
        $id = null;

        if ($bookingData) {
            $type = $bookingData['item_type'] ?? null;
            $id = $bookingData['item_id'] ?? null;
        }

        // Clear booking data from session
        $request->session()->forget('booking_data');

        // Handle failed payment
        return view('payment.payment-failure', [
            'type' => $type,
            'id' => $id,
        ])->with('error', session('error', 'There was an issue processing your payment. Please try again.'));
    }


    public function checkout($type, $id)
    {
        switch ($type) {
            case 'rooms':
                $item = Room::findOrFail($id);
                break;
            case 'cottages':
                $item = Pool::findOrFail($id);
                break;
            case 'activity':
                $item = Activity::findOrFail($id);
                break;
            case 'hall':
                $item = Hall::findOrFail($id);
                break;
            default:
                abort(404, 'Item type not found.');
        }

        return view('user.user_checkout', [
            'item' => $item,
            'type' => $type,
        ]);
    }

    /**
     * Create a new booking record in the database.
     *
     * @param array $bookingData
     * @return void
     */
    protected function createBooking(array $bookingData)
    {
        try {
            $booking = new Booking();
            $booking->user_id = $bookingData['user_id'];
            $booking->total_amount = $bookingData['subtotal'];
            $booking->payment_amount = $bookingData['payment_amount']; // Corrected
            $booking->balance_due = $bookingData['subtotal'] - $bookingData['payment_amount'];
            $booking->payment_method = $bookingData['payment_method'];
            $booking->check_in = $bookingData['check_in'];
            $booking->check_out = $bookingData['check_out'];
            $booking->payment_status = 'Partial'; // Indicate partial payment
            $booking->booking_status = 'Pending'; // Set status to 'Pending' for admin approval
            $booking->note = $bookingData['note'];

            // Assign foreign key based on item type
            switch ($bookingData['item_type']) {
                case 'rooms':
                    $booking->room_id = $bookingData['item_id'];
                    break;
                case 'cottages':
                    $booking->pool_id = $bookingData['item_id'];
                    break;
                case 'activity':
                    $booking->activity_id = $bookingData['item_id'];
                    break;
                case 'hall':
                    $booking->hall_id = $bookingData['item_id'];
                    break;
                default:
                    throw new \Exception('Invalid item type.');
            }

            // Save the booking to the database
            $booking->save();

            // Clear booking data from session
            session()->forget('booking_data');

            Log::info('Booking created successfully:', ['booking_id' => $booking->booking_id]);
        } catch (\Exception $e) {
            Log::error('Failed to create booking:', ['error' => $e->getMessage()]);
            // Optionally, handle the exception by notifying the user or retrying
            throw $e; // Re-throwing the exception to be handled upstream
        }
    }


    public function payWithPayPal()
    {
        $bookingData = session('booking_data');
        if (!$bookingData) {
            return redirect()->route('home')->with('error', 'No booking data found.');
        }


        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();


        $formattedAmount = number_format($bookingData['payment_amount'], 2, '.', '');

        // Order diri dapit
        $order = $provider->createOrder([
            "intent" => "CAPTURE",
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => config('paypal.currency'),
                        "value" => $formattedAmount,
                    ]
                ]
            ],
            "application_context" => [
                "return_url" => route('paypal.success'),
                "cancel_url" => route('paypal.cancel'),
            ]
        ]);

        if (isset($order['id']) && $order['id'] != null) {
            //Balik sa user
            foreach ($order['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    return redirect()->away($link['href']);
                }
            }


            //Callback ni dire dapit
            return redirect()
                ->route('payment-failure')
                ->with('error', 'Something went wrong.');
        } else {
            return redirect()
                ->route('payment-failure')
                ->with('error', $order['message'] ?? 'Something went wrong.');
        }
    }



    public function paypalSuccess(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        // Get the order ID from the 'token' parameter
        $orderId = $request->get('token');

        Log::info("Attempting to capture PayPal Order: $orderId");

        // Fetch order details to verify status
        $orderDetails = $provider->showOrderDetails($orderId);
        Log::info('Order Details:', $orderDetails);

        // Check if order is approved
        if ($orderDetails['status'] !== 'APPROVED') {
            Log::error("Order $orderId is not approved. Current status: " . $orderDetails['status']);
            return redirect()->route('payment-failure')->with('error', 'Order is not approved.');
        }

        // Capture the order
        $response = $provider->capturePaymentOrder($orderId);

        Log::info('PayPal Capture Response:', $response);

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            // Payment was successful
            $bookingData = session('booking_data');

            // Update booking data to indicate PayPal payment
            $bookingData['payment_method'] = 'Paypal';
            session(['booking_data' => $bookingData]);

            // Proceed to create booking
            $this->createBooking($bookingData);

            // Redirect to success page
            return view('payment.payment-success');
        } else {
            // Log the error message from PayPal
            Log::error('PayPal Capture Failed:', ['response' => $response]);

            return redirect()->route('payment-failure')->with('error', $response['message'] ?? 'Payment failed.');
        }
    }



    public function paypalCancel()
    {
        return redirect()->route('payment-failure')->with('error', 'Payment was canceled.');
    }

    /**
     * Handle PayPal webhooks (Optional).
     */

}
