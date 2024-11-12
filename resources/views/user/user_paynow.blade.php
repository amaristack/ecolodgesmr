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
                    <p><span class="font-semibold">Booked Item:</span> {{ $item->room_name ?? $item->cottage_name ?? $item->activity_name ?? $item->hall_name ?? 'N/A' }}</p>
                    <p><span class="font-semibold">Price:</span>
                        @if($type === 'rooms')
                            PHP {{ number_format($item->price ?? 0, 2) }} / Night
                        @elseif($type === 'cottages')
                            PHP {{ number_format($item->price ?? 0, 2) }} / Day
                        @elseif($type === 'activity')
                            PHP {{ number_format($item->price ?? 0, 2) }} per Person
                        @elseif($type === 'hall')
                            PHP {{ number_format($item->price ?? 0, 2) }} / Event
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


        <!-- Payment Options -->
        <div class="flex flex-col md:flex-row justify-center items-center gap-4">
            <!-- Pay with GCash -->
            <form action="{{ route('pay-with-gcash') }}" method="GET" class="w-full md:w-auto">
                <button type="submit" class="flex items-center justify-center w-full md:w-auto text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-5 py-3 shadow">
                    <img src="{{ \Illuminate\Support\Facades\Vite::asset('resources/images/gcash-logo.png')  }}" alt="GCash" class="w-24 h-5 mr-3">
                </button>
            </form>

            <!-- Pay with PayPal -->
            <form action="{{ route('pay-with-paypal') }}" method="GET" class="w-full md:w-auto">
                <button type="submit" class="flex items-center justify-center w-full md:w-auto text-white bg-blue-500 hover:bg-blue-600 font-medium rounded-lg text-sm px-5 py-3 shadow">
                    <svg class="w-4 h-5 me-2 -ms-1" aria-hidden="true" focusable="false" data-prefix="fab" data-icon="paypal" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path fill="currentColor" d="M111.4 295.9c-3.5 19.2-17.4 108.7-21.5 134-.3 1.8-1 2.5-3 2.5H12.3c-7.6 0-13.1-6.6-12.1-13.9L58.8 46.6c1.5-9.6 10.1-16.9 20-16.9 152.3 0 165.1-3.7 204 11.4 60.1 23.3 65.6 79.5 44 140.3-21.5 62.6-72.5 89.5-140.1 90.3-43.4 .7-69.5-7-75.3 24.2zM357.1 152c-1.8-1.3-2.5-1.8-3 1.3-2 11.4-5.1 22.5-8.8 33.6-39.9 113.8-150.5 103.9-204.5 103.9-6.1 0-10.1 3.3-10.9 9.4-22.6 140.4-27.1 169.7-27.1 169.7-1 7.1 3.5 12.9 10.6 12.9h63.5c8.6 0 15.7-6.3 17.4-14.9 .7-5.4-1.1 6.1 14.4-91.3 4.6-22 14.3-19.7 29.3-19.7 71 0 126.4-28.8 142.9-112.3 6.5-34.8 4.6-71.4-23.8-92.6z"></path></svg>
                    Pay with PayPal
                </button>
            </form>
        </div>
    </div>

    <x-footer />
</x-layout>
