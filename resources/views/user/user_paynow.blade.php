<!-- resources/views/user/user_paynow.blade.php -->

<x-layout>
    <x-navbar />

    <div class="container mx-auto p-8 bg-gray-100 mb-8 rounded-lg shadow-lg">
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold text-center mb-6">
            Payment for {{ ucfirst($type) }}
        </h1>

        <!-- Booking Details -->
        <div class="mb-6 max-w-[1140px] mx-auto">
            <h2 class="text-xl font-semibold mb-4">Booking Details</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-white p-4 rounded shadow">
                    <p><span class="font-semibold">Booked Item:</span> {{ $item->name ?? $item->cottage_name ?? $item->activity_name ?? $item->hall_name ?? 'N/A' }}</p>
                    <p><span class="font-semibold">Price:</span>
                        @if($type === 'rooms')
                            PHP {{ number_format($item->rate ?? 0, 2) }}
                        @elseif($type === 'cottages')
                            PHP {{ number_format($item->rate ?? 0, 2) }}
                        @elseif($type === 'activity')
                            PHP {{ number_format($item->rate ?? 0, 2) }}
                        @elseif($type === 'hall')
                            PHP {{ number_format($item->rate ?? 0, 2) }}
                        @else
                            N/A
                        @endif
                    </p>
                    @if($type === 'activity')
                        <p><span class="font-semibold">Duration:</span> {{ $item->duration ?? 'N/A' }} </p>
                    @endif
                </div>
                <div class="bg-white p-4 rounded shadow">
                    <p><span class="font-semibold">Check-In:</span> {{ \Carbon\Carbon::parse($bookingData['check_in'])->format('F j, Y') }}</p>
                    <p><span class="font-semibold">Check-Out:</span> {{ \Carbon\Carbon::parse($bookingData['check_out'])->format('F j, Y') }}</p>
                    @if($bookingData['note'])
                        <p><span class="font-semibold">Note:</span> {{ $bookingData['note'] }}</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Payment Summary -->
        <div class="mb-6 max-w-3xl mx-auto bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-2xl font-semibold mb-4 text-center text-gray-800">Payment Summary</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-blue-500 mr-3" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M3 10h18M3 14h18M9 6h6M4 18h16a2 2 0 002-2V8a2 2 0 00-2-2H4a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                    <span class="font-medium text-gray-700">Subtotal:</span>
                    <span class="ml-auto text-gray-900">PHP {{ number_format($bookingData['subtotal'], 2) }}</span>
                </div>
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-blue-500 mr-3" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M6.343 6.343a8 8 0 0111.314 0M12 15v6m-3-3h6"></path>
                    </svg>
                    <span class="font-medium text-gray-700">Downpayment (50%):</span>
                    <span class="ml-auto text-gray-900" data-payment-type="downpayment">PHP {{ number_format($bookingData['downpayment'], 2) }}</span>
                </div>
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-green-500 mr-3" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M9 12h6m2 0a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M17.657 16.657L13.414 12.414a2 2 0 00-2.828 0l-4.243 4.243a8 8 0 0011.314 0z"></path>
                    </svg>
                    <span class="font-medium text-gray-700">Total Due Now:</span>
                    <span id="total-due-now" class="ml-auto text-gray-900">PHP {{ number_format($bookingData['payment_amount'], 2) }}</span>
                </div>
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-yellow-500 mr-3" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 8v4l3 3m6 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="font-medium text-gray-700">Remaining Balance Due on Arrival:</span>
                    <span id="remaining-balance" class="ml-auto text-gray-900">PHP {{ number_format($bookingData['subtotal'] - $bookingData['downpayment'], 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Payment Options Selection -->
        <div class="w-full max-w-3xl mx-auto mb-4 bg-white shadow-lg rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-3 text-center text-gray-800">Payment Options</h3>
            <div class="flex flex-col space-y-3">
                <div class="flex items-center">
                    <input checked id="payment-option-half" type="radio" value="half" name="payment-option" class="w-4 h-4 text-yellow-500 focus:ring-yellow-500">
                    <label for="payment-option-half" class="ml-2 text-sm font-medium text-gray-700">
                        Pay Downpayment Only (50%)
                        <span class="text-sm text-gray-500 ml-2">PHP {{ number_format($bookingData['downpayment'], 2) }}</span>
                    </label>
                </div>
                <div class="flex items-center">
                    <input id="payment-option-full" type="radio" value="full" name="payment-option" class="w-4 h-4 text-yellow-500 focus:ring-yellow-500">
                    <label for="payment-option-full" class="ml-2 text-sm font-medium text-gray-700">
                        Pay Full Amount
                        <span class="text-sm text-gray-500 ml-2">PHP {{ number_format($bookingData['subtotal'], 2) }}</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Terms Agreement Checkbox -->
        <div class="w-full max-w-3xl mx-auto mb-4 flex items-center">
            <input type="checkbox" id="terms-agreement" class="rounded text-yellow-500 focus:ring-yellow-500 mr-2" required>
            <label for="terms-agreement" class="text-sm text-gray-700">
                I agree to the <button type="button" data-modal-target="termsModal" data-modal-toggle="termsModal" class="text-yellow-600 underline hover:text-yellow-700">Terms & Conditions</button>
            </label>
        </div>

        <div class="flex justify-center mb-6 space-x-4">
            <!-- Pay with Credit/Debit Card Button -->
            <button id="card-pay-btn"
                    class="flex items-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300
                           font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600
                           dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 opacity-75">
                <!-- Credit/Debit Card Icon -->
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M16 17h2a2 2 0 002-2v-5a2 2 0 00-2-2h-2m-4 4h.01M6 17h.01M6 17a2 2 0 01-2-2v-5a2 2 0 012-2h2m8 4v4m0 0h.01M12 21h.01"></path>
                </svg>
                Pay with Credit/Debit Card
            </button>

            <!-- Pay with GCash Button -->
            <button id="gcash-pay-btn"
                    class="flex items-center text-white bg-green-500 hover:bg-green-600 focus:ring-4 focus:ring-green-300
                           font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600
                           dark:hover:bg-green-700 focus:outline-none dark:focus:ring-green-800 opacity-75">
                <!-- GCash Icon -->
                <img src="{{ asset('images/gcash-icon.svg') }}" alt="GCash" class="w-5 h-5 mr-2">
                Pay with GCash
            </button>
        </div>

        <!-- Resort Terms Modal -->
        <div id="termsModal" tabindex="-1" aria-hidden="true"
             class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50
                    w-full md:inset-0 h-modal md:h-full flex justify-center items-center">
            <div class="relative p-4 w-full max-w-sm h-full md:h-auto">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow-lg">
                    <!-- Close button -->
                    <button type="button"
                            class="absolute top-3 right-3 text-gray-400 bg-transparent hover:bg-gray-200
                                  hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex
                                  items-center"
                            data-modal-hide="termsModal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                  d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414
                                     1.414L11.414 10l4.293 4.293a1 1 0 01-1.414
                                     1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586
                                     10 4.293 5.707a1 1 0 010-1.414z"
                                  clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>

                    <!-- Modal Header -->
                    <div class="bg-gradient-to-r from-yellow-400 to-yellow-600 px-4 py-3 rounded-t-lg">
                        <h3 class="text-lg font-semibold text-white flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Payment Terms & Conditions
                        </h3>
                    </div>

                    <!-- Modal Body -->
                    <div class="p-4">
                        <div class="max-h-64 overflow-y-auto pr-2 text-sm text-gray-700 custom-scrollbar">
                            <h4 class="text-md font-semibold mb-2 text-yellow-600">Booking & Payment</h4>
                            <ul class="list-disc pl-5 mb-3 space-y-1">
                                <li>A 50% downpayment is required to confirm your reservation.</li>
                                <li>The remaining balance is due upon arrival at Ecolodge - Sibugay Mountain Resort.</li>
                                <li>Payment transactions are secure and encrypted.</li>
                            </ul>

                            <h4 class="text-md font-semibold mb-2 text-yellow-600">Cancellation Policy</h4>
                            <ul class="list-disc pl-5 mb-3 space-y-1">
                                <li>Cancellations made 7 days or more before check-in date: 80% refund of downpayment.</li>
                                <li>Cancellations made 3-6 days before check-in date: 50% refund of downpayment.</li>
                                <li>Cancellations made within 48 hours of check-in date: No refund.</li>
                            </ul>

                            <h4 class="text-md font-semibold mb-2 text-yellow-600">Modifications</h4>
                            <ul class="list-disc pl-5 mb-3 space-y-1">
                                <li>Reservation modifications are subject to availability.</li>
                                <li>Date changes must be requested at least 3 days before scheduled arrival.</li>
                            </ul>

                            <p class="text-xs italic mt-3">By proceeding with payment, you acknowledge that you have read, understood, and agree to these terms and conditions.</p>
                        </div>

                        <div class="mt-4 flex justify-end">
                            <button type="button" class="text-white bg-yellow-500 hover:bg-yellow-600 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2 text-center" data-modal-hide="termsModal">
                                I Understand
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Card Modal -->
        <div id="paymentCardModal" tabindex="-1" aria-hidden="true"
             class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50
                    w-full md:inset-0 h-modal md:h-full flex justify-center items-center">
            <div class="relative p-4 w-full max-w-lg h-full md:h-auto">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow-lg dark:bg-gray-700">
                    <!-- Close button -->
                    <button type="button"
                            class="absolute top-3 right-3 text-gray-400 bg-transparent hover:bg-gray-200
                                   hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex
                                   items-center dark:hover:bg-gray-800 dark:hover:text-white"
                            data-modal-hide="paymentCardModal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor"
                             viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                  d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414
                                     1.414L11.414 10l4.293 4.293a1 1 0 01-1.414
                                     1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586
                                     10 4.293 5.707a1 1 0 010-1.414z"
                                  clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>

                    <!-- Modal Header -->
                    <div class="px-6 py-4 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-2xl font-semibold text-gray-900 dark:text-white text-center">
                            Enter Card Details
                        </h3>
                    </div>

                    <!-- Modal Body -->
                    <div class="p-6">
                        <form action="{{ route('pay-with-card') }}" method="GET" class="space-y-4">
                            @csrf

                            <!-- Hidden Input Fields -->
                            <input type="hidden" name="item_type" value="{{ $type }}">
                            <input type="hidden" name="item_id" value="{{ $item->id }}">
                            <input type="hidden" name="payment_amount" value="{{ $bookingData['payment_amount'] }}">
                            <input type="hidden" name="payment_method" value="Credit Card">
                            <input type="hidden" name="is_full_payment" value="0" id="card-is-full-payment">
                            <input type="hidden" name="payment-option" id="card-payment-option" value="half">

                            <!-- Name on Card -->
                            <div>
                                <label for="name_on_card"
                                       class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Name on Card
                                </label>
                                <input type="text" id="name_on_card" name="name_on_card" required
                                       class="mt-1 block w-full p-3 border border-gray-300 rounded-md
                                              shadow-sm focus:outline-none focus:ring-2
                                              focus:ring-blue-500 dark:bg-gray-600
                                              dark:border-gray-500 dark:placeholder-gray-400
                                              dark:text-white">
                            </div>

                            <!-- Card Number -->
                            <div>
                                <label for="card_number"
                                       class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Card Number
                                </label>
                                <input type="text" id="card_number" name="card_number" maxlength="19" required
                                       class="mt-1 block w-full p-3 border border-gray-300 rounded-md
                                              shadow-sm focus:outline-none focus:ring-2
                                              focus:ring-blue-500 dark:bg-gray-600
                                              dark:border-gray-500 dark:placeholder-gray-400
                                              dark:text-white"
                                       placeholder="XXXX XXXX XXXX XXXX">
                            </div>

                            <!-- Card Expiration Date and CVV -->
                            <div class="grid grid-cols-2 gap-4">
                                <!-- Expiration Date -->
                                <div>
                                    <label for="card-expiration-input"
                                           class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Expiration Date
                                    </label>
                                    <div class="relative">
                                        <input datepicker datepicker-format="mm/yy"
                                               id="card-expiration-input" type="text"
                                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm
                                                      rounded-lg focus:ring-blue-500 focus:border-blue-500
                                                      block w-full p-3 pl-10 dark:bg-gray-600
                                                      dark:border-gray-500 dark:placeholder-gray-400
                                                      dark:text-white"
                                               placeholder="MM/YY" required />
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                            <!-- Calendar Icon SVG -->
                                            <svg class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                                 aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                 fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2
                                                         0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2
                                                         2v2h20V4ZM0 18a2 2 0 0 0 2
                                                         2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1
                                                         0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <!-- CVV -->
                                <div>
                                    <label for="cvv-input"
                                           class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        CVV
                                    </label>
                                    <input type="number" id="cvv-input"
                                           aria-describedby="helper-text-explanation" required
                                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm
                                                  rounded-lg focus:ring-blue-500 focus:border-blue-500
                                                  block w-full p-3 dark:bg-gray-600
                                                  dark:border-gray-500 dark:placeholder-gray-400
                                                  dark:text-white">
                                </div>
                            </div>

                            <div class="relative">
                                    <div class="absolute z-50 mt-2">
                                    <!-- Datepicker component -->
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit"
                                    class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4
                                           focus:ring-blue-300 font-medium rounded-lg text-sm
                                           px-5 py-2.5 mb-2 dark:bg-blue-600
                                           dark:hover:bg-blue-700 focus:outline-none
                                           dark:focus:ring-blue-800">
                                Pay Now
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment GCash Modal -->
        <div id="paymentGCashModal" tabindex="-1" aria-hidden="true"
             class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50
                    w-full md:inset-0 h-modal md:h-full flex justify-center items-center">
            <div class="relative p-4 w-full max-w-lg h-full md:h-auto">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow-lg dark:bg-gray-700">
                    <!-- Close button -->
                    <button type="button"
                            class="absolute top-3 right-3 text-gray-400 bg-transparent hover:bg-gray-200
                                   hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex
                                   items-center dark:hover:bg-gray-800 dark:hover:text-white"
                            data-modal-hide="paymentGCashModal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor"
                             viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                  d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414
                                     1.414L11.414 10l4.293 4.293a1 1 0 01-1.414
                                     1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586
                                     10 4.293 5.707a1 1 0 010-1.414z"
                                  clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>

                    <!-- Modal Header -->
                    <div class="px-6 py-4 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-2xl font-semibold text-gray-900 dark:text-white text-center">
                            Pay with GCash
                        </h3>
                    </div>

                    <!-- Modal Body -->
                    <div class="p-6">
                        <form action="{{ route('pay-with-gcash') }}" method="GET" class="space-y-4">
                            @csrf

                            <!-- Hidden Input Fields -->
                            <input type="hidden" name="item_type" value="{{ $type }}">
                            <input type="hidden" name="item_id" value="{{ $item->id }}">
                            <input type="hidden" name="payment_amount" value="{{ $bookingData['payment_amount'] }}">
                            <input type="hidden" name="payment_method" value="gcash">
                            <input type="hidden" name="is_full_payment" value="0" id="gcash-is-full-payment">
                            <input type="hidden" name="payment-option" id="gcash-payment-option" value="half">

                            <!-- GCash Number -->
                            <div>
                                <label for="gcash_number"
                                       class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    GCash Number
                                </label>
                                <input type="text" id="gcash_number"  required
                                       class="mt-1 block w-full p-3 border border-gray-300 rounded-md
                                              shadow-sm focus:outline-none focus:ring-2
                                              focus:ring-green-500 dark:bg-gray-600
                                              dark:border-gray-500 dark:placeholder-gray-400
                                              dark:text-white"
                                       placeholder="09XX XXX XXXX">
                            </div>



                            <!-- Submit Button -->
                            <button type="submit"
                                    class="w-full text-white bg-green-500 hover:bg-green-600 focus:ring-4
                                           focus:ring-green-300 font-medium rounded-lg text-sm
                                           px-5 py-2.5 mb-2 dark:bg-green-600
                                           dark:hover:bg-green-700 focus:outline-none
                                           dark:focus:ring-green-800">
                                Pay Now with GCash
                            </button>

                            <!-- Instructions or Information -->
                            <div class="text-sm text-gray-600 dark:text-gray-400">
                                <p>Please ensure your GCash number is correct.</p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <x-footer/>


    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f7f7f7;
            border-radius: 8px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #f59e0b;
            border-radius: 8px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #d97706;
        }
    </style>

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Flowbite modals
    const cardModal = new Modal(document.getElementById('paymentCardModal'), {
        placement: 'center',
        backdrop: 'dynamic',
        closable: true,
    });

    const gcashModal = new Modal(document.getElementById('paymentGCashModal'), {
        placement: 'center',
        backdrop: 'dynamic',
        closable: true,
    });

    // Get the terms checkbox and payment buttons
    const termsCheckbox = document.getElementById('terms-agreement');
    const cardPayBtn = document.getElementById('card-pay-btn');
    const gcashPayBtn = document.getElementById('gcash-pay-btn');
    const paymentOptionHalf = document.getElementById('payment-option-half');
    const paymentOptionFull = document.getElementById('payment-option-full');

    // Get is_full_payment fields
    const cardIsFullPayment = document.getElementById('card-is-full-payment');
    const gcashIsFullPayment = document.getElementById('gcash-is-full-payment');

    // Get payment amount elements - FIXED SELECTORS
    const totalDueNowElement = document.getElementById('total-due-now');
    const remainingBalanceElement = document.getElementById('remaining-balance');

    // Payment amounts
    const downpaymentAmount = {{ $bookingData['downpayment'] }};
    const subtotalAmount = {{ $bookingData['subtotal'] }};

    // Remove the data attributes and handle modal display in JavaScript
    cardPayBtn.removeAttribute('data-modal-target');
    cardPayBtn.removeAttribute('data-modal-toggle');
    gcashPayBtn.removeAttribute('data-modal-target');
    gcashPayBtn.removeAttribute('data-modal-toggle');

    // Handle payment option changes
    function updatePaymentSummary() {
        const downpaymentDisplay = document.querySelector('[data-payment-type="downpayment"]');
        const cardPaymentOption = document.getElementById('card-payment-option');
        const gcashPaymentOption = document.getElementById('gcash-payment-option');

        if (paymentOptionFull.checked) {
            // Full payment
            totalDueNowElement.textContent = `PHP ${subtotalAmount.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
            remainingBalanceElement.textContent = `PHP 0.00`;

            // Update payment option values
            if (cardPaymentOption) cardPaymentOption.value = 'full';
            if (gcashPaymentOption) gcashPaymentOption.value = 'full';

            // Update downpayment display to show full amount
            if (downpaymentDisplay) {
                downpaymentDisplay.textContent = `PHP ${subtotalAmount.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
            }

            // Update hidden input fields in both forms
            document.querySelectorAll('input[name="payment_amount"]').forEach(input => {
                input.value = subtotalAmount;
            });

            // Set is_full_payment value to 1 (true)
            if (cardIsFullPayment) cardIsFullPayment.value = '1';
            if (gcashIsFullPayment) gcashIsFullPayment.value = '1';

        } else {
            // Downpayment only
            totalDueNowElement.textContent = `PHP ${downpaymentAmount.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
            remainingBalanceElement.textContent = `PHP ${(subtotalAmount - downpaymentAmount).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;

            // Update payment option values
            if (cardPaymentOption) cardPaymentOption.value = 'half';
            if (gcashPaymentOption) gcashPaymentOption.value = 'half';

            // Reset downpayment display to original amount
            if (downpaymentDisplay) {
                downpaymentDisplay.textContent = `PHP ${downpaymentAmount.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
            }

            // Update hidden input fields in both forms
            document.querySelectorAll('input[name="payment_amount"]').forEach(input => {
                input.value = downpaymentAmount;
            });

            // Set is_full_payment value to 0 (false)
            if (cardIsFullPayment) cardIsFullPayment.value = '0';
            if (gcashIsFullPayment) gcashIsFullPayment.value = '0';
        }
    }

    paymentOptionHalf.addEventListener('change', updatePaymentSummary);
    paymentOptionFull.addEventListener('change', updatePaymentSummary);

    // Add click event listeners to payment buttons
    cardPayBtn.addEventListener('click', function(e) {
        if (!termsCheckbox.checked) {
            showTermsAlert();
        } else {
            // Update payment amount right before opening modal
            const isFullPayment = paymentOptionFull.checked;
            const amountToCharge = isFullPayment ? subtotalAmount : downpaymentAmount;

            // Update all payment amount fields in the card modal
            const cardModal = document.getElementById('paymentCardModal');
            const paymentInputs = cardModal.querySelectorAll('input[name="payment_amount"]');
            paymentInputs.forEach(input => {
                input.value = amountToCharge;
            });

            // Update is_full_payment field
            if (cardIsFullPayment) {
                cardIsFullPayment.value = isFullPayment ? '1' : '0';
            }

            // Open the card payment modal
            cardModal.classList.remove('hidden');
        }
    });

    gcashPayBtn.addEventListener('click', function(e) {
        if (!termsCheckbox.checked) {
            showTermsAlert();
        } else {
            // Update payment amount right before opening modal
            const isFullPayment = paymentOptionFull.checked;
            const amountToCharge = isFullPayment ? subtotalAmount : downpaymentAmount;

            // Update all payment amount fields in the GCash modal
            const gcashModal = document.getElementById('paymentGCashModal');
            const paymentInputs = gcashModal.querySelectorAll('input[name="payment_amount"]');
            paymentInputs.forEach(input => {
                input.value = amountToCharge;
            });

            // Update is_full_payment field
            if (gcashIsFullPayment) {
                gcashIsFullPayment.value = isFullPayment ? '1' : '0';
            }

            // Open the GCash payment modal
            gcashModal.classList.remove('hidden');
        }
    });

    // Close buttons for modals
    document.querySelectorAll('[data-modal-hide]').forEach(button => {
        button.addEventListener('click', function() {
            const modalId = this.getAttribute('data-modal-hide');
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.add('hidden');
            }
        });
    });

    // Function to show SweetAlert2 modal
    function showTermsAlert() {
        Swal.fire({
            icon: 'warning',
            title: 'Terms & Conditions Required',
            text: 'Please agree to the Terms & Conditions before proceeding with payment.',
            confirmButtonColor: '#f59e0b',
            confirmButtonText: 'Understand'
        });
    }

    // Initialize the payment summary
    updatePaymentSummary();
});
</script>
</x-layout>
