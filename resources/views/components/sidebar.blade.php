<nav class="flex flex-col space-y-2">
    <a href="/user/{{ $users->id }}"
       class="px-4 py-3 text-left hover:bg-red-100 text-gray-600 {{ request()->is('user/'.$users->id) ? 'bg-red-500 text-white' : '' }}"><i
            class="fas fa-tachometer-alt mr-2"></i> My Dashboard</a>
    <a href="/my_bookings"
       class="px-4 py-3 text-left hover:bg-red-100 text-gray-600 {{ request()->is('my_bookings') ? 'bg-red-500 text-white' : '' }}"><i
            class="fas fa-book mr-2"></i> My Booking</a>
    <a href="{{ route('notifications') }}"
       class="px-4 py-3 text-left hover:bg-red-100 text-gray-600 {{ request()->is('notifications') ? 'bg-red-500 text-white' : '' }}"><i
            class="fas fa-bell mr-2"></i> Notifications</a>
    <a href="/user/{{ $users->id }}/edit"
       class="px-4 py-3 text-left hover:bg-red-100 text-gray-600 {{ request()->is('user/' .$users->id . '/edit') ? 'bg-red-500 text-white' : '' }}"><i
            class="fas fa-user mr-2"></i> Profile</a>
    <a href="/user/{{ $users->id }}/change_password"
       class="px-4 py-3 text-left hover:bg-red-100 text-gray-600 {{ request()->is('user/'.$users->id.'/change_password') ? 'bg-red-500 text-white' : '' }}"><i
            class="fas fa-lock mr-2"></i> Change Password</a>
    <form action="/logout" method="POST">
        @csrf
        <button type="submit" class="w-full px-4 py-3 pb-12 text-left hover:bg-red-100 text-gray-600">
            <i class="fas fa-sign-out-alt mr-2"></i> Logout
        </button>
    </form>
</nav>



