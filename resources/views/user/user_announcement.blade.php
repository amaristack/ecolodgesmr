<x-layout>
    <x-navbar/>

    <div class="container mx-auto my-10 px-4">
        <h1 class="text-3xl font-bold mb-6 text-center">Announcements</h1>

        @if($announcements->isEmpty())
            <div class="text-center text-gray-500">
                <p>No announcements available at the moment.</p>
            </div>
        @else
            <div class="space-y-6">
                @foreach($announcements as $announcement)
                    <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">
                        <div class="flex justify-between items-center mb-4">
                            <div>
                                <h2 class="text-xl font-semibold text-gray-800">{{ $announcement->sender_name }}</h2>
                                <p class="text-sm text-gray-500">
                                    {{ $announcement->date_posted->format('F j, Y, g:i a') }}
                                </p>
                            </div>
                            <div>
                                <span class="px-2 py-1 text-xs font-semibold text-white bg-blue-500 rounded-full">
                                    Announcement
                                </span>
                            </div>
                        </div>
                        <p class="text-gray-700">{{ $announcement->message }}</p>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <x-footer/>
</x-layout>
