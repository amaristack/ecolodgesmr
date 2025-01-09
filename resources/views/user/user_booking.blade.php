<x-layout>
    <x-navbar />

    <!-- Hero Section -->
    <div class="relative bg-cover bg-center h-[400px] flex items-center justify-center"
         style="background-image: url('https://vnfoxcdnoahqenfjssdv.supabase.co/storage/v1/object/public/ecolodgesmr/images/main.jpg?t=2024-11-30T15%3A26%3A27.929Z');">
        <div class="absolute inset-0 bg-blue-900 opacity-50"></div>
        <div class="container mx-auto relative z-10 text-center text-white">
            <h1 class="text-6xl font-extrabold mb-4">Welcome to Sibugay</h1>
            <nav class="text-lg font-semibold">
                <a href="/dashboard" class="hover:text-yellow-300">Home</a>
                <span class="mx-2">/</span>
                <a href="/dashboard/{id}" class="text-yellow-300 underline">User Dashboard</a>
            </nav>
        </div>
    </div>

    <!-- Content Section -->
    <div class="container mx-auto my-12 flex flex-col md:flex-row items-center md:items-start">
        <!-- User Profile Card -->
        <div class="w-full md:w-1/4 bg-white shadow-xl rounded-3xl overflow-hidden mb-8 md:mb-0">
            <div class="text-center p-8">
                <div class="w-24 h-24 rounded-full bg-yellow-500 flex items-center justify-center mx-auto shadow-md">
                    <img src="https://vnfoxcdnoahqenfjssdv.supabase.co/storage/v1/object/public/ecolodgesmr/images/mario.png?t=2024-11-16T16%3A16%3A19.062Z" alt=""
                         class="rounded-full object-cover w-full h-full"/>
                </div>
                <h3 class="mt-4 text-xl font-semibold text-gray-800">{{ $users->first_name }} {{ $users->last_name }}</h3>
                <p class="text-sm text-gray-500">{{ $users->email }}</p>
            </div>
            <div class="px-6 py-4 bg-gray-50">
                <x-sidebar />
            </div>
        </div>

        <!-- Bookings Table -->


        <div class="w-full md:w-3/4 bg-white shadow-xl rounded-3xl p-8 ml-0 md:ml-4">
            <h2 class="text-3xl font-bold mb-8 text-gray-700">My Bookings</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200 rounded-md shadow-sm">
                    <thead>
                    <tr class="text-left bg-gray-200">
                        <th class="py-4 px-6 font-semibold text-gray-700">Booking ID</th>
                        <th class="py-4 px-6 font-semibold text-gray-700">Booking Date</th>
                        <th class="py-4 px-6 font-semibold text-gray-700">In / Out Date</th>
                        <th class="py-4 px-6 font-semibold text-gray-700">Booking Type</th>
                        <th class="py-4 px-6 font-semibold text-gray-700">Payment Status</th>
                        <th class="py-4 px-6 font-semibold text-gray-700">Booking Status</th>
                        <th class="py-4 px-6 font-semibold text-gray-700">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($bookings as $booking)
                        <tr class="border-t hover:bg-gray-100">
                            <td class="py-4 px-6">{{ $booking->booking_id }}</td>
                            <td class="py-4 px-6">{{ $booking->created_at }}</td>
                            <td class="py-4 px-6">
                                {{ \Carbon\Carbon::parse($booking->check_in)->format('F j, Y') }} - {{ \Carbon\Carbon::parse($booking->check_out)->format('F j, Y') }}
                            </td>

                            <td class="py-4 px-6">
                                @if($booking->room_id)
                                    Room
                                @elseif($booking->pool_id)
                                    Cottage
                                @elseif($booking->activity_id)
                                    Activity
                                @elseif($booking->hall_id)
                                    Hall
                                @else
                                    N/A
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full
                                    @if($booking->payment_status == 'Fully Paid') bg-green-500 text-white
                                    @elseif($booking->payment_status == 'Refunded') bg-blue-500 text-white
                                    @else bg-yellow-500 text-white
                                    @endif">
                                    {{ $booking->payment_status }}
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full
                                    @if($booking->booking_status == 'Pending') bg-yellow-500 text-white
                                    @elseif($booking->booking_status == 'Success') bg-green-500 text-white
                                    @elseif($booking->booking_status == 'Cancelled') bg-red-500 text-white
                                    @endif">
                                    {{ $booking->booking_status }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <a href="{{ route('viewDetailed.booking', ['booking_id' => $booking->booking_id]) }}" class="text-blue-500 hover:underline text-xl">
                                <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <!-- Pagination -->
                <div class="mt-6">
                    {{ $bookings->links() }}
                </div>
            </div>
        </div>
    </div>

    <x-footer />
</x-layout>
