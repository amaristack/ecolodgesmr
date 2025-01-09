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
use Carbon\Carbon;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Mail\BookingReceipt;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    public function book(Request $request)
    {
        try {
            // Validate the incoming request data
            $validatedData = $request->validate([
                'item_type' => 'required|string|in:rooms,cottages,activity,hall',
                'item_id' => 'required|integer',
                'check_in' => 'required|date',
                'check_out' => 'required|date|after_or_equal:check_in',
                'number_of_person' => 'required_if:item_type,rooms|integer|min:1',
                'guest_names' => 'required_if:item_type,rooms|array',
                'guest_names.*' => 'required_if:item_type,rooms|string|max:255',
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

            // Calculate the number of days
            $checkIn = Carbon::parse($validatedData['check_in']);
            $checkOut = Carbon::parse($validatedData['check_out']);
            $days = $checkIn->diffInDays($checkOut) ?: 1;

            // Calculate subtotal
            $rate = $item->rate; // Ensure the model has a 'rate' attribute
            $subtotal = $rate * $days;

            // Calculate discount (if any)
            $discount = 0; // Modify this if discount logic is implemented

            // Calculate total
            $total = $subtotal - $discount;

            // Additional validation for rooms
            if ($type === 'rooms') {
                $numberOfPersons = $validatedData['number_of_person'];
                if ($numberOfPersons > $item->max_people) {
                    return back()->withErrors(['number_of_person' => 'Number of persons exceeds the maximum allowed.']);
                }

                $guestNames = $validatedData['guest_names'];
                if (count($guestNames) != $numberOfPersons) {
                    return back()->withErrors(['guest_names' => 'Guest names count does not match the number of persons.']);
                }
            }

            // Store booking data in the session without setting 'payment_method' here
            $bookingData = [
                'user_id' => Auth::id(),
                'note' => $validatedData['note'] ?? null,
                'check_in' => $validatedData['check_in'],
                'check_out' => $validatedData['check_out'],
                'subtotal' => $subtotal,
                'discount' => $discount,
                'total' => $total,
                // Removed 'payment_method' => 'Gcash', // Remove default payment method
                'item_type' => $type,
                'item_id' => $itemId,
                'number_of_person' => $type === 'rooms' ? $numberOfPersons : null,
                'guest_names' => $type === 'rooms' ? $guestNames : null,
            ];

            $request->session()->put('booking_data', $bookingData);

            // Redirect to the payment options page
            return redirect()->route('user_paynow');
        } catch (\Exception $e) {
            Log::error('Booking Error: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while processing your booking.');
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
                return redirect()->route('home')->with('error', 'Invalid item type selected.');
        }

        try {
            // Calculate the number of days based on check-in and check-out dates
            $checkIn = Carbon::parse($bookingData['check_in']);
            $checkOut = Carbon::parse($bookingData['check_out']);
            $days = $checkIn->diffInDays($checkOut) ?: 1;

            // Recalculate subtotal based on days
            $rate = $item->rate;
            $subtotal = $rate * $days;

            // Calculate discount (if any)
            $discount = $bookingData['discount'] ?? 0; // Adjust if you have discount logic

            // Calculate total
            $total = $subtotal - $discount;

            // Calculate downpayment (50% of subtotal)
            $downpayment = $subtotal * 0.5;

            // Update booking data with recalculated values
            $bookingData['days'] = $days;
            $bookingData['subtotal'] = $subtotal;
            $bookingData['discount'] = $discount;
            $bookingData['total'] = $total;
            $bookingData['downpayment'] = $downpayment;
            $bookingData['payment_amount'] = $downpayment; // Set payment amount to downpayment

            // Save updated booking data back to session
            session(['booking_data' => $bookingData]);

            // Pass the updated data to the view
            return view('user.user_paynow', [
                'bookingData' => $bookingData,
                'item' => $item,
                'type' => $bookingData['item_type'],
            ]);
        } catch (\Exception $e) {
            Log::error('Payment Calculation Error: ' . $e->getMessage());
            return redirect()->route('home')->with('error', 'An error occurred while processing your payment.');
        }
    }

    public function payWithPayMongo()
    {
        $bookingData = session('booking_data');
        if (!$bookingData) {
            return redirect()->route('home')->with('error', 'No booking data found.');
        }

        // Set 'payment_method' to 'Gcash'
        $bookingData['payment_method'] = 'Gcash';
        session(['booking_data' => $bookingData]);

        $amountInCentavos = (int) round($bookingData['payment_amount'] * 100);

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

    public function payWithCard()
    {
        $bookingData = session('booking_data');
        if (!$bookingData) {
            return redirect()->route('home')->with('error', 'No booking data found.');
        }

        // Set 'payment_method' to 'Credit Card'
        $bookingData['payment_method'] = 'Credit Card';
        session(['booking_data' => $bookingData]);

        $amountInCentavos = (int) round($bookingData['payment_amount'] * 100);

        $payload = [
            'data' => [
                'attributes' => [
                    'amount' => $amountInCentavos, // Amount in centavos as integer
                    'redirect' => [
                        'success' => route('payment-success'),
                        'failed' => route('payment-failure'),
                    ],
                    'type' => 'grab_pay',
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

            // Redirect to GrabPay checkout page
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
                                'amount' => (int) round($bookingData['payment_amount'] * 100), // Downpayment amount in centavos
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
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function createBooking(array $bookingData)
    {
        try {
            $booking = new Booking();
            $booking->user_id = $bookingData['user_id'];
            $booking->total_amount = $bookingData['subtotal'];
            $booking->down_payment = $bookingData['payment_amount'];
            $booking->balance_due = $bookingData['subtotal'] - $bookingData['payment_amount'];
            $booking->payment_method = $bookingData['payment_method'];
            $booking->check_in = $bookingData['check_in'];
            $booking->check_out = $bookingData['check_out'];
            $booking->payment_status = 'Partial';
            $booking->booking_status = 'Success';
            $booking->note = $bookingData['note'];
            $booking->number_of_person = $bookingData['number_of_person'];

            // Process guest_names only if item_type is 'rooms' and guest_names is provided
            if (isset($bookingData['item_type']) && $bookingData['item_type'] === 'rooms' && is_array($bookingData['guest_names'])) {
                $guestNames = array_values($bookingData['guest_names']);
                $booking->guest_names = $guestNames;
            } else {
                $booking->guest_names = null;
            }

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

            switch ($booking->item_type) {
                case 'rooms':
                    $room = Room::find($booking->item_id);
                    if ($room) {
                        $room->availability -= 1;
                        $room->save();
                    }
                    break;
                case 'cottage':
                    $cottage = Pool::find($booking->item_id);
                    if ($cottage) {
                        $cottage->availability -= 1;
                        $cottage->save();
                    }
                    break;
                case 'activity':
                    $activity = Activity::find($booking->item_id);
                    if ($activity) {
                        $activity->availability -= 1;
                        $activity->save();
                    }
                    break;
                case 'function hall':
                    $functionHall = Hall::find($booking->item_id);
                    if ($functionHall) {
                        $functionHall->availability -= 1;
                        $functionHall->save();
                    }
                    break;
            }

            Log::info('Booking saved successfully:', ['booking_id' => $booking->booking_id]);

            // Send the receipt email to the user
            Mail::to($booking->user->email)->send(new BookingReceipt($booking));

            Log::info('Booking receipt email sent to user:', ['email' => $booking->user->email]);

            // Clear booking data from session
            session()->forget('booking_data');

            Log::info('Booking data cleared from session:', ['booking_id' => $booking->booking_id]);

            return redirect()->route('user_paynow')->with('success', 'Booking created successfully! A receipt has been sent to your email.');
        } catch (\Exception $e) {
            Log::error('Failed to create booking or send receipt email:', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'An error occurred while processing your booking.');
        }
    }

    public function payWithPayPal()
    {
        $bookingData = session('booking_data');
        if (!$bookingData) {
            return redirect()->route('home')->with('error', 'No booking data found.');
        }

        $provider = new PayPalClient();
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        $formattedAmount = number_format($bookingData['payment_amount'], 2, '.', '');

        // Order diri dapit
        $order = $provider->createOrder([
            'intent' => 'CAPTURE',
            'purchase_units' => [
                [
                    'amount' => [
                        'currency_code' => config('paypal.currency'),
                        'value' => $formattedAmount,
                    ],
                ],
            ],
            'application_context' => [
                'return_url' => route('paypal.success'),
                'cancel_url' => route('paypal.cancel'),
            ],
        ]);

        if (isset($order['id']) && $order['id'] != null) {
            //Balik sa user
            foreach ($order['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    return redirect()->away($link['href']);
                }
            }

            //Callback ni dire dapit
            return redirect()->route('payment-failure')->with('error', 'Something went wrong.');
        } else {
            return redirect()
                ->route('payment-failure')
                ->with('error', $order['message'] ?? 'Something went wrong.');
        }
    }

    public function paypalSuccess(Request $request)
    {
        $provider = new PayPalClient();
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

            return redirect()
                ->route('payment-failure')
                ->with('error', $response['message'] ?? 'Payment failed.');
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
