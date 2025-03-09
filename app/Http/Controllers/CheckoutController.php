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
                'quantity' => 'required|integer|min:1', // Validate quantity
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

            // Factor in quantity
            $quantity = $validatedData['quantity'];
            $rate = $item->rate;
            $subtotal = $rate * $days * $quantity;

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
                'quantity' => $quantity,
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

            // Get quantity from booking data
            $quantity = $bookingData['quantity'] ?? 1;

            // Recalculate subtotal based on days and quantity
            $rate = $item->rate;
            $subtotal = $rate * $days * $quantity;

            // Calculate discount (if any)
            $discount = $bookingData['discount'] ?? 0;

            // Calculate total
            $total = $subtotal - $discount;

            // Calculate downpayment (50% of total)
            $downpayment = $total * 0.5;

            // Get payment preference from request (if exists)
            $isFullPayment = request()->has('full_payment') ? true : false;

            // Set payment amount based on preference
            $paymentAmount = $isFullPayment ? $total : $downpayment;
            $paymentStatus = $isFullPayment ? 'Paid' : 'Partial';

            // Update booking data with recalculated values
            $bookingData['days'] = $days;
            $bookingData['subtotal'] = $subtotal;
            $bookingData['discount'] = $discount;
            $bookingData['total'] = $total;
            $bookingData['downpayment'] = $downpayment;
            $bookingData['payment_amount'] = $paymentAmount;
            $bookingData['is_full_payment'] = $isFullPayment;
            $bookingData['payment_status'] = $paymentStatus;
            $bookingData['quantity'] = $quantity;

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

    public function payWithPayMongo(Request $request)
    {
        $bookingData = session('booking_data');
        if (!$bookingData) {
            return redirect()->route('home')->with('error', 'No booking data found.');
        }

        // Update payment amount based on payment option
        $paymentOption = $request->input('payment-option');
        $isFullPayment = $paymentOption === 'full';

        // Calculate payment amount
        $paymentAmount = $isFullPayment ? $bookingData['total'] : $bookingData['downpayment'];

        // Update booking data with new payment amount and status
        $bookingData['payment_amount'] = $paymentAmount;
        $bookingData['is_full_payment'] = $isFullPayment;
        $bookingData['payment_status'] = $isFullPayment ? 'Fully Paid' : 'Partial';
        $bookingData['payment_method'] = 'Gcash';

        // Update session with new booking data
        session(['booking_data' => $bookingData]);

        $amountInCentavos = (int) round($paymentAmount * 100);

        // Log payment details for debugging
        Log::info('PayMongo Payment Details:', [
            'payment_option' => $paymentOption,
            'is_full_payment' => $isFullPayment,
            'amount' => $paymentAmount,
            'amount_in_centavos' => $amountInCentavos,
            'total_amount' => $bookingData['total'],
            'downpayment_amount' => $bookingData['downpayment']
        ]);

        $payload = [
            'data' => [
                'attributes' => [
                    'amount' => $amountInCentavos,
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

    public function payWithCard(Request $request)
    {
        $bookingData = session('booking_data');
        if (!$bookingData) {
            return redirect()->route('home')->with('error', 'No booking data found.');
        }

        // Update payment amount based on payment option
        $paymentOption = $request->input('payment-option');
        $isFullPayment = $paymentOption === 'full';

        // Calculate payment amount
        $paymentAmount = $isFullPayment ? $bookingData['subtotal'] : $bookingData['downpayment'];

        // Update booking data with new payment amount and status
        $bookingData['payment_amount'] = $paymentAmount;
        $bookingData['is_full_payment'] = $isFullPayment;
        $bookingData['payment_status'] = $isFullPayment ? 'Fully Paid' : 'Partial';
        $bookingData['payment_method'] = 'Credit Card';

        // Update session with new booking data
        session(['booking_data' => $bookingData]);

        // Convert amount to centavos for PayMongo
        $amountInCentavos = (int) round($paymentAmount * 100);

        // Log payment details for debugging
        Log::info('Card Payment Details:', [
            'payment_option' => $paymentOption,
            'is_full_payment' => $isFullPayment,
            'amount' => $paymentAmount,
            'amount_in_centavos' => $amountInCentavos
        ]);

        $payload = [
            'data' => [
                'attributes' => [
                    'amount' => $amountInCentavos,
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

    public function payWithGCash(Request $request)
    {
        $bookingData = session('booking_data');
        if (!$bookingData) {
            return redirect()->route('home')->with('error', 'No booking data found.');
        }

        // Update payment amount based on payment option
        $paymentOption = $request->input('payment-option');
        $isFullPayment = $paymentOption === 'full';

        // Calculate payment amount
        $paymentAmount = $isFullPayment ? $bookingData['subtotal'] : $bookingData['downpayment'];

        // Update booking data with new payment amount and status
        $bookingData['payment_amount'] = $paymentAmount;
        $bookingData['is_full_payment'] = $isFullPayment;
        $bookingData['payment_status'] = $isFullPayment ? 'Paid' : 'Partial';
        $bookingData['payment_method'] = 'GCash';

        // Update session with new booking data
        session(['booking_data' => $bookingData]);

        // Convert amount to centavos for PayMongo
        $amountInCentavos = (int) round($paymentAmount * 100);

        // Log payment details for debugging
        Log::info('GCash Payment Details:', [
            'payment_option' => $paymentOption,
            'is_full_payment' => $isFullPayment,
            'amount' => $paymentAmount,
            'amount_in_centavos' => $amountInCentavos
        ]);

        $payload = [
            'data' => [
                'attributes' => [
                    'amount' => $amountInCentavos,
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

        try {
            // Check if the application is in local environment
            if (app()->environment('local')) {
                $paymentStatus = 'paid';
                Log::info('Simulating payment success for local environment.');
            } else {
                $sourceId = $request->query('source');
                if (!$sourceId) {
                    return redirect()->route('payment-failure')->with('error', 'Payment source not found.');
                }

                // Verify payment status with PayMongo
                $response = Http::withHeaders([
                    'Accept' => 'application/json',
                    'Authorization' => 'Basic ' . base64_encode(config('services.paymongo.secret_key') . ':'),
                ])->get("https://api.paymongo.com/v1/sources/{$sourceId}");

                if (!$response->successful()) {
                    Log::error('PayMongo verification failed:', $response->json());
                    return redirect()->route('payment-failure')->with('error', 'Payment verification failed.');
                }

                $paymentStatus = $response->json()['data']['attributes']['status'];
            }

            // If payment is successful, create the booking
            if ($paymentStatus === 'paid' || $paymentStatus === 'chargeable') {
                // Ensure payment method is set
                if (!isset($bookingData['payment_method'])) {
                    $bookingData['payment_method'] = 'GCash'; // Default to GCash if not set
                }

                // Update session with payment method
                session(['booking_data' => $bookingData]);

                Log::info('Booking data before creation:', $bookingData);

                // Create booking
                $booking = $this->createBooking($bookingData);

                if ($booking) {
                    // Update item availability
                    $this->updateItemAvailability($bookingData);

                    // Send booking receipt email
                    try {
                        Mail::to($booking->user->email)->send(new BookingReceipt($booking));
                        Log::info('Booking receipt email sent to user:', ['email' => $booking->user->email]);
                    } catch (\Exception $e) {
                        Log::error('Failed to send booking receipt email:', ['error' => $e->getMessage()]);
                    }

                    // Clear session after successful booking
                    session()->forget('booking_data');
                    Log::info('Booking data cleared from session:', ['booking_id' => $booking->id]);

                    // Redirect to success page
                    return view('payment.payment-success', [
                        'booking' => $booking
                    ]);
                }
            }

            Log::error('Payment status not successful', ['status' => $paymentStatus]);
            return redirect()->route('payment-failure')->with('error', 'Payment was not successful.');

        } catch (\Exception $e) {
            Log::error('Payment processing error:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('payment-failure')->with('error', 'An error occurred while processing your payment.');
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
        // Add some debugging
        Log::info("Checkout attempted with type: {$type}, id: {$id}");

        // Your existing checkout logic
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


    protected function createBooking(array $bookingData)
    {
        try {
            // Log the incoming booking data (excluding sensitive information)
            $logData = array_merge($bookingData, ['guest_names' => '[REDACTED]']);
            Log::info('Creating booking with data:', $logData);

            $booking = new Booking();
            $booking->user_id = $bookingData['user_id'];
            $booking->total_amount = $bookingData['total'];
            $booking->down_payment = $bookingData['payment_amount'];
            $booking->balance_due = $bookingData['total'] - $bookingData['payment_amount'];
            $booking->payment_method = $bookingData['payment_method'] ?? 'GCash';
            $booking->payment_status = $bookingData['payment_status'];
            $booking->booking_status = 'Success';
            $booking->check_in = $bookingData['check_in'];
            $booking->check_out = $bookingData['check_out'];
            $booking->quantity = $bookingData['quantity'] ?? 1;
            $booking->note = $bookingData['note'] ?? null;
            $booking->number_of_person = $bookingData['number_of_person'] ?? null;

            // Handle guest names if present
            if (isset($bookingData['guest_names']) && is_array($bookingData['guest_names'])) {
                $booking->guest_names = json_encode($bookingData['guest_names']);
            }

            // Set the appropriate ID based on item type
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
            }

            $booking->save();

            Log::info('Booking saved successfully:', ['booking_id' => $booking->id]);

            return $booking;

        } catch (\Exception $e) {
            Log::error('Booking creation failed:', [
                'error' => $e->getMessage(),
                'booking_data' => array_merge($bookingData, ['guest_names' => '[REDACTED]'])
            ]);
            throw $e;
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

    public function updatePaymentAmount(Request $request)
    {
        $bookingData = session('booking_data');

        if (!$bookingData) {
            return response()->json(['error' => 'No booking data found'], 404);
        }

        $isFullPayment = $request->input('is_full_payment', false);

        if ($isFullPayment) {
            // Set payment amount to full subtotal
            $bookingData['payment_amount'] = $bookingData['subtotal'];
            $bookingData['is_full_payment'] = true;
            $paymentStatus = $isFullPayment ? 'Paid' : 'Partial';
        } else {
            // Set payment amount to downpayment (50%)
            $bookingData['payment_amount'] = $bookingData['downpayment'];
            $bookingData['is_full_payment'] = false;
            $paymentStatus = 'Partial';
        }

        // Update payment status based on full/partial payment
        $bookingData['payment_status'] = $paymentStatus;

        // Save updated booking data back to session
        session(['booking_data' => $bookingData]);

        return response()->json([
            'success' => true,
            'payment_amount' => $bookingData['payment_amount'],
            'is_full_payment' => $bookingData['is_full_payment']
        ]);
    }

    protected function updateItemAvailability(array $bookingData)
    {
        try {
            switch ($bookingData['item_type']) {
                case 'rooms':
                    $item = Room::findOrFail($bookingData['item_id']);
                    $oldAvailability = $item->availability;
                    $quantityBooked = $bookingData['quantity'] ?? 1;
                    $item->availability = max(0, $oldAvailability - $quantityBooked);
                    $item->save();

                    Log::info('Room availability updated:', [
                        'room_id' => $item->id,
                        'old_availability' => $oldAvailability,
                        'new_availability' => $item->availability,
                        'quantity_booked' => $quantityBooked
                    ]);
                    break;

                case 'cottages':
                    $item = Pool::findOrFail($bookingData['item_id']);
                    $oldAvailability = $item->availability;
                    $quantityBooked = $bookingData['quantity'] ?? 1;
                    $item->availability = max(0, $oldAvailability - $quantityBooked);
                    $item->save();

                    Log::info('Cottage availability updated:', [
                        'cottage_id' => $item->id,
                        'old_availability' => $oldAvailability,
                        'new_availability' => $item->availability,
                        'quantity_booked' => $quantityBooked
                    ]);
                    break;

                case 'activity':
                    $item = Activity::findOrFail($bookingData['item_id']);
                    $oldAvailability = $item->availability;
                    $quantityBooked = $bookingData['quantity'] ?? 1;
                    $item->availability = max(0, $oldAvailability - $quantityBooked);
                    $item->save();

                    Log::info('Activity availability updated:', [
                        'activity_id' => $item->id,
                        'old_availability' => $oldAvailability,
                        'new_availability' => $item->availability,
                        'quantity_booked' => $quantityBooked
                    ]);
                    break;

                case 'hall':
                    $item = Hall::findOrFail($bookingData['item_id']);
                    $oldAvailability = $item->availability;
                    $quantityBooked = $bookingData['quantity'] ?? 1;
                    $item->availability = max(0, $oldAvailability - $quantityBooked);
                    $item->save();

                    Log::info('Hall availability updated:', [
                        'hall_id' => $item->id,
                        'old_availability' => $oldAvailability,
                        'new_availability' => $item->availability,
                        'quantity_booked' => $quantityBooked
                    ]);
                    break;

                default:
                    Log::warning('Unknown item type for availability update:', [
                        'item_type' => $bookingData['item_type']
                    ]);
                    break;
            }
        } catch (\Exception $e) {
            Log::error('Failed to update item availability:', [
                'error' => $e->getMessage(),
                'item_type' => $bookingData['item_type'],
                'item_id' => $bookingData['item_id']
            ]);
            throw $e;
        }
    }
}
