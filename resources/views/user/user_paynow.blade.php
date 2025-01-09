<!-- resources/views/user/user_paynow.blade.php -->

<x-layout>
    <x-navbar />

    <div class="container mx-auto p-8 bg-gray-100 mb-8 rounded-lg shadow-lg">
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold text-center mb-6">
            Payment for {{ ucfirst($type) }}
        </h1>

        <div class="mb-6 max-w-[1140px] mx-auto">
            <h2 class="text-xl font-semibold mb-4">Booking Details</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p><span class="font-semibold">Booked Item:</span> {{ $item->name ?? $item->cottage_name ?? $item->activity_name ?? $item->hall_name ?? 'N/A' }}</p>
                    <p><span class="font-semibold">Price:</span>
                        @if($type === 'rooms')
                            PHP {{ number_format($item->rate ?? 0, 2) }} / Night
                        @elseif($type === 'cottages')
                            PHP {{ number_format($item->rate ?? 0, 2) }} / Day
                        @elseif($type === 'activity')
                            PHP {{ number_format($item->rate ?? 0, 2) }} per Person
                        @elseif($type === 'hall')
                            PHP {{ number_format($item->rate ?? 0, 2) }} / Event
                        @else
                            N/A
                        @endif
                    </p>
                    @if($type === 'activity')
                        <p><span class="font-semibold">Duration:</span> {{ $item->duration ?? 'N/A' }} Hours</p>
                    @endif
                </div>
                <div>
                    <p><span class="font-semibold">Quantity:</span> {{ $bookingData['quantity'] }}</p>
                    <p><span class="font-semibold">Check-In:</span> {{ \Carbon\Carbon::parse($bookingData['check_in'])->format('F j, Y') }}</p>
                    <p><span class="font-semibold">Check-Out:</span> {{ \Carbon\Carbon::parse($bookingData['check_out'])->format('F j, Y') }}</p>
                    @if($bookingData['note'])
                        <p><span class="font-semibold">Note:</span> {{ $bookingData['note'] }}</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="mb-6 max-w-[1140px] mx-auto">
            <h2 class="text-xl font-semibold mb-4">Payment Summary</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="flex">
                    <span class="font-semibold">Subtotal:</span>
                    <span class="ml-1">PHP {{ number_format($bookingData['subtotal'], 2) }}</span>
                </div>
                <div class="flex">
                    <span class="font-semibold">Downpayment (50%):</span>
                    <span class="ml-1">PHP {{ number_format($bookingData['downpayment'], 2) }}</span>
                </div>
                <div class="flex">
                    <span class="font-semibold">Total Due Now:</span>
                    <span class="ml-1">PHP {{ number_format($bookingData['payment_amount'], 2) }}</span>
                </div>
                <div class="flex">
                    <span class="font-semibold">Remaining Balance Due on Arrival:</span>
                    <span class="ml-1">PHP {{ number_format($bookingData['subtotal'] - $bookingData['downpayment'], 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Pay Now Button to Trigger Modal -->
        <div class="flex justify-center">
            <button data-modal-target="paymentModal" data-modal-toggle="paymentModal" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                Pay with Credit/Debit Card
            </button>
        </div>

        <!-- Payment Modal -->
        <div id="paymentModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
            <div class="relative p-4 w-full max-w-md h-full md:h-auto">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Close button -->
                    <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-hide="paymentModal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>

                    <!-- Modal Header -->
                    <div class="px-6 py-4 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Enter Card Details
                        </h3>
                    </div>

                    <!-- Modal Body -->
                    <div class="p-6">
                        <form action="{{ route('pay-with-card') }}" method="GET" class="space-y-4">
                            @csrf

                            <!-- Card Number -->
                            <div>
                                <label for="card-number-input" class="sr-only">Card number:</label>
                                <div class="relative">
                                    <input type="text"  id="card-number-input" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pe-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="4242 4242 4242 4242" pattern="^4[0-9]{12}(?:[0-9]{3})?$" required />
                                    <div class="absolute inset-y-0 end-0 top-0 flex items-center pe-3.5 pointer-events-none">
                                        <!-- Visa Icon SVG -->
                                        <svg fill="none" class="h-6 text-[#1434CB] dark:text-white" viewBox="0 0 36 21">
                                            <path fill="currentColor" d="M23.315 4.773c-2.542 0-4.813 1.3-4.813 3.705 0 2.756 4.028 2.947 4.028 4.332 0 .583-.676 1.105-1.832 1.105-1.64 0-2.866-.73-2.866-.73l-.524 2.426s1.412.616 3.286.616c2.78 0 4.966-1.365 4.966-3.81 0-2.913-4.045-3.097-4.045-4.383 0-.457.555-.957 1.708-.957 1.3 0 2.36.53 2.36.53l.514-2.343s-1.154-.491-2.782-.491zM.062 4.95L0 5.303s1.07.193 2.032.579c1.24.442 1.329.7 1.537 1.499l2.276 8.664h3.05l4.7-11.095h-3.043l-3.02 7.543L6.3 6.1c-.113-.732-.686-1.15-1.386-1.15H.062zm14.757 0l-2.387 11.095h2.902l2.38-11.096h-2.895zm16.187 0c-.7 0-1.07.37-1.342 1.016L25.41 16.045h3.044l.589-1.68h3.708l.358 1.68h2.685L33.453 4.95h-2.447zm.396 2.997l.902 4.164h-2.417l1.515-4.164z"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Expiration Date -->
                            <div class="grid grid-cols-3 gap-4 my-4">
                                <div class="relative max-w-sm col-span-2">
                                    <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                        <!-- Calendar Icon SVG -->
                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                        </svg>
                                    </div>
                                    <label for="card-expiration-input" class="sr-only">Card expiration date:</label>
                                    <input datepicker datepicker-format="mm/yy"  id="card-expiration-input" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="12/23" required />
                                </div>
                                <div class="col-span-1">
                                    <label for="cvv-input" class="sr-only">Card CVV code:</label>
                                    <input type="number"  id="cvv-input" aria-describedby="helper-text-explanation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="CVV" required />
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                Pay Now!
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Options -->
        <div class="flex flex-col md:flex-row justify-center items-center gap-4">
            <!-- Pay with GCash -->
            <form action="{{ route('pay-with-gcash') }}" method="GET" class="w-full md:w-auto">
                <button type="submit" class="flex items-center justify-center w-full md:w-auto text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-5 py-3 shadow">
                    <img src="https://vnfoxcdnoahqenfjssdv.supabase.co/storage/v1/object/public/ecolodgesmr/images/gcash-logo.png?t=2024-11-19T06%3A11%3A58.795Z" alt="GCash" class="w-24 h-5 mr-3">
                </button>
            </form>
        </div>
    </div>

    <x-footer />
</x-layout>
