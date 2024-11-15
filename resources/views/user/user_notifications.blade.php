<x-layout>
    <x-navbar/>

    <!-- Banner Section -->
    <div class="relative bg-cover bg-center h-[300px] flex items-center justify-center"
         style="background-image: url('{{ \Illuminate\Support\Facades\Vite::asset('resources/images/main.jpg') }}');">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-blue-400 opacity-60"></div>
        <div class="container mx-auto relative z-10 flex items-center justify-center">
            <div class="text-center text-white">
                <h1 class="text-5xl font-extrabold mb-4">Welcome to Sibugay</h1>
                <nav class="text-white text-lg font-semibold mb-4">
                    <a href="/dashboard" class="hover:underline">Home</a> /
                    <a href="/dashboard/{{ $user->id }}" class="underline">User Dashboard</a>
                </nav>
            </div>
        </div>
    </div>

    <!-- Main Content Section -->
    <div class="container mx-auto my-12 flex flex-col md:flex-row items-center md:items-start justify-center gap-8">
        <!-- Sidebar -->
        <div class="w-full md:w-1/4 bg-white shadow-lg rounded-xl p-6">
            <div class="text-center">
                <div class="w-24 h-24 rounded-full bg-red-500 flex items-center justify-center mx-auto mb-4">
                    <img src="{{ \Illuminate\Support\Facades\Vite::asset('resources/images/mario.png') }}" alt=""
                         class="rounded-full"/>
                </div>
                <h3 class="text-xl font-semibold text-gray-800">{{ $user->first_name }} {{ $user->last_name }}</h3>
                <p class="text-gray-500">{{ $user->email }}</p>
            </div>
            <div class="mt-6">
                <x-sidebar/>
            </div>
        </div>

        <!-- Notifications Section -->
        <div class="w-full md:w-3/4 p-6 bg-white shadow-lg rounded-xl">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Your Bookings</h2>

            <!-- Display bookings as notifications -->
            <div class="space-y-4">
                @foreach($bookings as $booking)
                    @php
                        // Define the notification color and message based on payment_status and booking_status
                        $color = '';
                        $statusMessage = '';
                        $bookingItemName = ''; // To hold the name of the booked item (room, activity, etc.)
                        $bookingLink = route('viewDetailed.booking', ['booking_id' => $booking->booking_id]); // Booking redirect URL

                        // Determine the status and color
                        if ($booking->payment_status === 'Cancelled' && $booking->booking_status === 'Cancelled') {
                            $color = 'bg-red-50 text-red-500';
                            $statusMessage = 'Your booking has been cancelled.';
                        } elseif ($booking->payment_status === 'Partial' && $booking->booking_status === 'Pending') {
                            $color = 'bg-yellow-50 text-yellow-500';
                            $statusMessage = 'Your booking is pending payment.';
                        } elseif ($booking->payment_status === 'Fully Paid' && $booking->booking_status === 'Approved') {
                            $color = 'bg-green-50 text-green-500';
                            $statusMessage = 'Your booking has been confirmed.';
                        }

                        // Determine the item name based on the type of booking
                        if ($booking->room) {
                            $bookingItemName = $booking->room->room_name;
                        } elseif ($booking->activity) {
                            $bookingItemName = $booking->activity->activity_name;
                        } elseif ($booking->hall) {
                            $bookingItemName = $booking->hall->hall_name;
                        } elseif ($booking->pool) {
                            $bookingItemName = $booking->pool->cottage_name;
                        }
                    @endphp

                    @if($color && $statusMessage)
                        <a href="{{ $bookingLink }}"
                           class="flex items-start p-4 {{ $color }} rounded-lg shadow-sm hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                            <div>
                                <i class="fa fa-bell fa-lg"></i>
                            </div>
                            <div class="ml-4 flex-1">
                                <h3 class="font-semibold text-gray-800">{{ $statusMessage }}</h3>
                                <p class="text-sm text-gray-600">Booking for
                                    <span class="font-semibold">{{ $bookingItemName ?? 'Item not available' }}</span>,
                                    Check-in: <span
                                        class="font-semibold">{{ $booking->check_in ? $booking->check_in->format('M d, Y') : 'N/A' }}</span>
                                </p>
                                <p class="text-xs text-gray-400 mt-1">{{ $booking->created_at->diffForHumans() }}</p>
                            </div>
                        </a>
                    @endif
                @endforeach
            </div>
            <div class="mt-6">
                {{ $bookings->links('pagination::tailwind') }}
            </div>
        </div>

    </div>

    <x-footer/>
</x-layout>
