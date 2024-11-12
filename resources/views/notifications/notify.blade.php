<div class="container mx-auto p-6 bg-gray-100 min-h-screen">
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4 text-gray-800">Notifications</h2>

        <!-- Notification List -->
        <div class="space-y-4">
            @forelse($notifications as $notification)
                <div class="bg-white border-l-4 @if($notification->payment_status === 'Fully Paid') border-green-500 @else border-red-500 @endif rounded-md p-4 shadow-sm">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="font-semibold text-lg text-gray-800">
                                Booking ID: {{ $notification->id }}
                            </h3>
                            <p class="text-sm text-gray-600 mt-1">
                                Status: {{ $notification->booking_status }}
                            </p>
                            <p class="text-xs text-gray-400 mt-2">
                                Payment Status: {{ $notification->payment_status }}<br>
                                Received on {{ $notification->created_at->format('F j, Y, g:i a') }}
                            </p>
                        </div>
                        <div class="ml-4">
                            @if($notification->is_read)
                                <span class="inline-block bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">Read</span>
                            @else
                                <span class="inline-block bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full">Unread</span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-gray-200 p-4 rounded-md text-center text-gray-500">
                    No notifications available.
                </div>
            @endforelse
        </div>

        <!-- Pagination (if applicable) -->
        <div class="mt-6">
            {{ $notifications->links() }} {{-- This assumes you have pagination enabled --}}
        </div>
    </div>
</div>
