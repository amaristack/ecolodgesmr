<header class="bg-gray-800 text-white py-4 w-full z-50" id="header">
    <div class="max-w-5xl mx-auto flex justify-between items-center px-4">
        <div>
            <p><i class="fa fa-phone"></i> 0915 502 2154 | <i class="fa fa-envelope"></i>
                sibugaymountainresort@gmail.com
            </p>
        </div>
        @guest
            <div class="bg-yellow-500 p-1.5 rounded-lg">
                <a class="text-white font-bold" href="{{ route('verify.email') }}" wire:navigate>
                    Register Now
                </a>
            </div>
        @endguest
    </div>
</header>

<nav class="bg-white shadow-md w-full transition-transform duration-300" id="navbar">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
        <img src="https://vnfoxcdnoahqenfjssdv.supabase.co/storage/v1/object/public/ecolodgesmr/images/logo1.jpg?t=2024-11-16T16%3A15%3A49.458Z"
            alt="" class="h-14 me-3">

        <!-- Centered Navigation List -->
        <ul id="menu" class="hidden md:flex space-x-6 p-1.5 mx-auto">
            @guest
                <li>
                    <x-nav_design href="/" :active="request()->is('/dashboard')">Home</x-nav_design>
                </li>
            @endguest
            @auth
                <li>
                    <x-nav_design href="/dashboard"  :active="request()->is('/dashboard')">Home</x-nav_design>
                </li>
            @endauth
            <li>
                <x-nav_design href="/rooms" wire:navigate :active="request()->is('rooms')" onclick="routeToRooms(e)">Rooms</x-nav_design>
            </li>
            <li>
                <x-nav_design href="/activities" wire:navigate :active="request()->is('activities')">Activities</x-nav_design>
            </li>
            <li>
                <x-nav_design href="/cottages" wire:navigate :active="request()->is('cottages')">Cottage</x-nav_design>
            </li>
            <li>
                <x-nav_design href="/function_hall" wire:navigate :active="request()->is('function_hall')">Function Hall
                </x-nav_design>
            </li>
            <li>
                <x-nav_design href="{{ route('announcements.index') }}" wire:navigate :active="request()->is('announcement')">Announcements</x-nav_design>
            </li>
            @guest
                <li>
                    <x-nav_design href="/login" wire:navigate :active="request()->is('login')">Log in</x-nav_design>
                </li>
            @endguest
        </ul>

        <!-- Right Icons -->
        <div class="flex items-center space-x-3 rtl:space-x-reverse">
            @auth

                <button id="dropdownNotificationButton" data-dropdown-toggle="dropdownNotification"
                    class="relative inline-flex items-center text-sm font-medium text-center text-gray-500 hover:text-gray-900 focus:outline-none dark:hover:text-white dark:text-gray-400"
                    type="button">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 14 20">
                        <path
                            d="M12.133 10.632v-1.8A5.406 5.406 0 0 0 7.979 3.57.946.946 0 0 0 8 3.464V1.1a1 1 0 0 0-2 0v2.364a.946.946 0 0 0 .021.106 5.406 5.406 0 0 0-4.154 5.262v1.8C1.867 13.018 0 13.614 0 14.807 0 15.4 0 16 .538 16h12.924C14 16 14 15.4 14 14.807c0-1.193-1.867-1.789-1.867-4.175ZM3.823 17a3.453 3.453 0 0 0 6.354 0H3.823Z" />
                    </svg>

                    <div
                        class="absolute block w-3 h-3 bg-red-500 border-2 border-white rounded-full -top-0.5 start-2.5 dark:border-gray-900">
                    </div>
                </button>

                <div id="dropdownNotification"
                    class="z-20 hidden w-full max-w-sm bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-800 dark:divide-gray-700 overflow-hidden"
                    aria-labelledby="dropdownNotificationButton">
                    <div
                        class="block px-4 py-2 font-medium text-center text-gray-700 rounded-t-lg bg-gray-50 dark:bg-gray-800 dark:text-white">
                        Notifications
                    </div>

                    <div class="divide-y divide-gray-100 dark:divide-gray-700">
                        <!-- Add a fixed height and scrollable behavior here -->
                        <div class="max-h-96 overflow-y-auto">
                            @foreach ($bookings->sortByDesc('created_at') as $booking)
                                <!-- Sort to get latest at top -->
                                @php
                                    // Define the notification color and message based on payment_status and booking_status
                                    $color = '';
                                    $statusMessage = '';
                                    $bookingItemName = ''; // To hold the name of the booked item (room, activity, etc.)
                                    $bookingLink = route('viewDetailed.booking', [
                                        'booking_id' => $booking->booking_id,
                                    ]); // Booking redirect URL

                                    // Determine the status and color
                                    if (
                                        $booking->payment_status === 'Refunded' &&
                                        $booking->booking_status === 'Cancelled'
                                    ) {
                                        $color = 'bg-red-50 text-red-500';
                                        $statusMessage = 'Your booking has been Refunded.';
                                    } elseif (
                                        $booking->payment_status === 'Partial' &&
                                        $booking->booking_status === 'Success'
                                    ) {
                                        $color = 'bg-yellow-50 text-yellow-500';
                                        $statusMessage = 'Your booking is pending payment.';
                                    } elseif (
                                        $booking->payment_status === 'Fully Paid' &&
                                        $booking->booking_status === 'Success'
                                    ) {
                                        $color = 'bg-green-50 text-green-500';
                                        $statusMessage = 'Your booking has been confirmed.';
                                    } elseif ($booking->payment_status === 'Refund') {
                                        $color = 'bg-blue-50 text-blue-500';
                                        $statusMessage = 'Your refund request is confirmed.';
                                    }

                                    // Determine the item name based on the type of booking
                                    if ($booking->room) {
                                        $bookingItemName = $booking->room->name;
                                    } elseif ($booking->activity) {
                                        $bookingItemName = $booking->activity->activity_name;
                                    } elseif ($booking->hall) {
                                        $bookingItemName = $booking->hall->hall_name;
                                    } elseif ($booking->pool) {
                                        $bookingItemName = $booking->pool->cottage_name;
                                    }
                                @endphp

                                @if ($color && $statusMessage)
                                    <a href="{{ $bookingLink }}"
                                        class="flex items-start p-4 {{ $color }} rounded-lg shadow-sm hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                                        <div>
                                            <i class="fa fa-bell fa-lg"></i>
                                        </div>
                                        <div class="ml-4 flex-1">
                                            <h3 class="font-semibold text-gray-800">{{ $statusMessage }}</h3>
                                            <p class="text-sm text-gray-600">Booking for
                                                <span
                                                    class="font-semibold">{{ $bookingItemName ?? 'Item not available' }}</span>,
                                                Check-in: <span
                                                    class="font-semibold">{{ $booking->check_in ? $booking->check_in->format('M d, Y') : 'N/A' }}</span>
                                            </p>
                                            <p class="text-xs text-gray-400 mt-1">
                                                {{ optional($booking->created_at)->diffForHumans() ?? 'N/A' }}
                                            </p>
                                        </div>
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <a href="{{ route('notifications') }}" class="block text-center mt-4 text-blue-500">View All
                        Notifications</a>
                </div>

                <!-- User Profile Menu -->
                <button type="button"
                    class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                    id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown"
                    data-dropdown-placement="bottom">
                    <span class="sr-only">Open user menu</span>
                    <img class="w-8 h-8 rounded-full"
                        src="https://vnfoxcdnoahqenfjssdv.supabase.co/storage/v1/object/public/ecolodgesmr/images/mario.png?t=2024-11-16T16%3A16%3A19.062Z"
                        alt="user photo">
                </button>

                <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600"
                    id="user-dropdown">
                    <div class="px-4 py-3">
                        <span class="block text-sm text-gray-900 dark:text-white">{{ $users->first_name }}
                            {{ $users->last_name }}</span>
                        <span class="block text-sm text-gray-500 truncate dark:text-gray-400">{{ $users->email }}</span>
                    </div>
                    <ul class="py-2" aria-labelledby="user-menu-button">
                        <li>
                            <a href="/user/{{ $users->id }}" wire:navigate
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Dashboard</a>
                        </li>
                        <li>
                            <form method="POST" action="/logout">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                                    Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            @endauth

            <!-- Hamburger Icon for Mobile (Visible for Both Authenticated and Guest Users) -->
            <button id="navbar-toggler" class="md:hidden text-gray-500 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                    </path>
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden md:hidden px-6 py-4">
        <ul class="space-y-4">
            @guest
                <li>
                    <x-nav_design href="/" wire:navigate :active="request()->is('/dashboard')">Home</x-nav_design>
                </li>
            @endguest
            @auth
                <li>
                    <x-nav_design href="/dashboard" wire:navigate :active="request()->is('/dashboard')">Home</x-nav_design>
                </li>
            @endauth
            <li>
                <x-nav_design href="/rooms" wire:navigate :active="request()->is('rooms')">Rooms</x-nav_design>
            </li>
            <li>
                <x-nav_design href="/activities" wire:navigate :active="request()->is('activities')">Activities</x-nav_design>
            </li>
            <li>
                <x-nav_design href="/cottages" wire:navigate :active="request()->is('cottages')">Cottages</x-nav_design>
            </li>
            <li>
                <x-nav_design href="/function_hall" wire:navigate :active="request()->is('function_hall')">Function Hall
                </x-nav_design>
            </li>
            <li>
                <x-nav_design href="{{ route('announcements.index') }}" wire:navigate :active="request()->is('calendar')">Announcements</x-nav_design>
            </li>
            @guest
                <li><a href="/login" wire:navigate class="text-black text-[18px] font-medium hover:text-yellow-500">Login</a></li>
            @endguest
        </ul>
    </div>
</nav>
