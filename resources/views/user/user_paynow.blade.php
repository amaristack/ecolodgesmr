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
                    <span class="ml-auto text-gray-900">PHP {{ number_format($bookingData['downpayment'], 2) }}</span>
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
                    <span class="ml-auto text-gray-900">PHP {{ number_format($bookingData['payment_amount'], 2) }}</span>
                </div>
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-yellow-500 mr-3" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 8v4l3 3m6 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="font-medium text-gray-700">Remaining Balance Due on Arrival:</span>
                    <span class="ml-auto text-gray-900">PHP {{ number_format($bookingData['subtotal'] - $bookingData['downpayment'], 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Payment Method Selection -->
        <div class="flex justify-center mb-6 space-x-4">
            <!-- Pay with Credit/Debit Card Button -->
            <button data-modal-target="paymentCardModal" data-modal-toggle="paymentCardModal"
                    class="flex items-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300
                           font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600
                           dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                <!-- Credit/Debit Card Icon -->
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M16 17h2a2 2 0 002-2v-5a2 2 0 00-2-2h-2m-4 4h.01M6 17h.01M6 17a2 2 0 01-2-2v-5a2 2 0 012-2h2m8 4v4m0 0h.01M12 21h.01"></path>
                </svg>
                Pay with Credit/Debit Card
            </button>

            <!-- Pay with GCash Button -->
            <button data-modal-target="paymentGCashModal" data-modal-toggle="paymentGCashModal"
                    class="flex items-center text-white bg-green-500 hover:bg-green-600 focus:ring-4 focus:ring-green-300
                           font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600
                           dark:hover:bg-green-700 focus:outline-none dark:focus:ring-green-800">
                <!-- GCash Icon -->
                <img src="{{ asset('images/gcash-icon.svg') }}" alt="GCash" class="w-5 h-5 mr-2">
                Pay with GCash
            </button>
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

    <!-- JavaScript for Card Number Formatting -->
    <script>
        document.getElementById('card_number').addEventListener('input', function (e) {
            let value = e.target.value.replace(/\D/g, '').substring(0,16);
            let formatted = value.replace(/(.{4})/g, '$1 ').trim();
            e.target.value = formatted;
        });
    </script>
</x-layout>
