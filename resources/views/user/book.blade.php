<x-layout>
    <x-navbar/>

    {{-- Main Content --}}
    <main class="mx-auto px-4 py-8" style="max-width: 1140px;">
        <!-- Rooms Section -->
        <section id="rooms" class="mb-12">
            <h2 class="text-3xl font-semibold mb-6 text-center">Rooms</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($rooms as $room)
                    <div class="rounded overflow-hidden shadow-lg bg-white">

                        <img class="w-full h-48 object-cover"
                             src="{{ 'https://vnfoxcdnoahqenfjssdv.supabase.co/storage/v1/object/public/ecolodgesmr/images/' . ($room->room_type) . '.jpg' }}"
                             alt="{{ $room->room_name }}"
                             loading="lazy"
                             onerror="this.onerror=null; this.src='{{ asset('images/default-room.jpg') }}'">

                        <div class="px-6 py-4">
                            <div class="font-bold text-xl mb-2">{{ $room->room_name }}</div>
                            <p class="text-gray-700 text-base">
                                {{ Str::limit($room->description, 100) }}
                            </p>
                            <p class="text-gray-900 font-semibold mt-2">Price: PHP{{ number_format($room->rate, 2) }}</p>
                        </div>
                        <div class="px-6 py-4">
                            <a href="{{ route('rooms.show', $room->room_id) }}" class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Book Now
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- Activities Section -->
        <section id="activities" class="mb-12">
            <h2 class="text-3xl font-semibold mb-6 text-center">Activities</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($activities as $activity)
                    <div class="rounded overflow-hidden shadow-lg bg-white">

                        <img class="w-full h-48 object-cover"
                             src="{{ 'https://vnfoxcdnoahqenfjssdv.supabase.co/storage/v1/object/public/ecolodgesmr/images/' . ($activity->activity_name) . '.jpg' }}"
                             alt="{{ $activity->activity_name }}"
                             loading="lazy"
                             onerror="this.onerror=null; this.src='{{ asset('images/default-activity.jpg') }}'">

                        <div class="px-6 py-4">
                            <div class="font-bold text-xl mb-2">{{ $activity->activity_name }}</div>
                            <p class="text-gray-700 text-base">
                                {{ Str::limit($activity->activity_description, 100) }}
                            </p>
                        </div>
                        <div class="px-6 py-4">
                            <a href="{{ route('activities.show', $activity->activity_id) }}" class="inline-block bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                View Details
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- Cottages Section -->
        <section id="cottages" class="mb-12">
            <h2 class="text-3xl font-semibold mb-6 text-center">Cottages</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($cottages as $cottage)
                    <div class="rounded overflow-hidden shadow-lg bg-white">

                        <img class="w-full h-48 object-cover"
                             src="{{ 'https://vnfoxcdnoahqenfjssdv.supabase.co/storage/v1/object/public/ecolodgesmr/images/' . ($cottage->cottage_name) . '.jpg' }}"
                             alt="{{ $cottage->cottage_name }}"
                             loading="lazy"
                             onerror="this.onerror=null; this.src='{{ asset('images/default-cottage.jpg') }}'">

                        <div class="px-6 py-4">
                            <div class="font-bold text-xl mb-2">{{ $cottage->cottage_name }}</div>
                            <p class="text-gray-700 text-base">
                                {{ Str::limit($cottage->description, 100) }}
                            </p>
                            <p class="text-gray-900 font-semibold mt-2">Price: PHP{{ number_format($cottage->rate, 2) }}</p>
                        </div>
                        <div class="px-6 py-4">
                            <a href="{{ route('pools.show', $cottage->pool_id) }}" class="inline-block bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                                Book Now
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- Function Halls Section -->
        <section id="function-halls" class="mb-12">
            <h2 class="text-3xl font-semibold mb-6 text-center">Function Halls</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($halls as $hall)
                    <div class="rounded overflow-hidden shadow-lg bg-white">

                        <img class="w-full h-48 object-cover"
                             src="{{ 'https://vnfoxcdnoahqenfjssdv.supabase.co/storage/v1/object/public/ecolodgesmr/images/' . ($hall->hall_name) . '.jpg' }}"
                             alt="{{ $hall->name }}"
                             loading="lazy"
                             onerror="this.onerror=null; this.src='{{ asset('images/default-hall.jpg') }}'">

                        <div class="px-6 py-4">
                            <div class="font-bold text-xl mb-2">{{ $hall->name }}</div>
                            <p class="text-gray-700 text-base">
                                {{ Str::limit($hall->description, 100) }}
                            </p>
                            <p class="text-gray-900 font-semibold mt-2">Capacity: {{ $hall->capacity }} people</p>
                        </div>
                        <div class="px-6 py-4">
                            <a href="{{ route('function-hall.show', $hall->hall_id) }}" class="inline-block bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                Book Now
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </main>

    <x-footer/>
</x-layout>
