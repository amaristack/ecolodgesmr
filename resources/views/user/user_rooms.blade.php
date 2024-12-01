<x-layout>
    <x-navbar />

    <!-- Hero Section -->
    <div class="relative bg-cover bg-center h-[350px] flex items-center justify-center"
         style="background-image: url('https://vnfoxcdnoahqenfjssdv.supabase.co/storage/v1/object/public/ecolodgesmr/images/main.jpg');">
        <div class="absolute inset-0 bg-gradient-to-b from-black/60 to-transparent"></div>
        <div class="container mx-auto relative z-10 text-center text-white">
            <h1 class="text-5xl font-extrabold mb-4">Choose a Room</h1>
            <nav class="text-white text-lg font-medium">
                <a href="/dashboard" class="hover:text-yellow-400">Home</a> /
                <a href="/rooms" class="text-yellow-400">Rooms</a>
            </nav>
        </div>
    </div>

    <!-- Main Room Selection Section -->
    <section class="container mx-auto px-4 py-10 mb-16">
        <!-- Section Title -->
        <div class="text-center mb-10">
            <h2 class="text-sm sm:text-lg text-yellow-500 font-medium">Choose Your Rooms</h2>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-800 mb-2 sm:mb-4">Featured Rooms</h1>
            <p class="text-gray-600 max-w-2xl mx-auto">Experience luxury and comfort. Select from our carefully curated rooms that cater to your needs.</p>
        </div>

        <!-- Room Cards Section -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($rooms as $room)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden group hover:shadow-xl transition-shadow duration-300">
                    <!-- Image -->
                    <div class="relative">
                        <img src="{{ 'https://vnfoxcdnoahqenfjssdv.supabase.co/storage/v1/object/public/ecolodgesmr/images/' . ($room->room_type) . '.jpg' }}"
                             alt="{{ $room->room_type }}"
                             class="w-full h-56 sm:h-64 object-cover rounded-t-lg transition-transform duration-300 group-hover:scale-105"
                             style="object-position: center 40%;">
                        <!-- Highlight Badge -->
                        <div class="absolute top-2 left-2 bg-yellow-500 text-white text-xs font-semibold px-3 py-1 rounded-lg shadow-md">
                            Popular Choice
                        </div>
                    </div>
                    <!-- Room Details -->
                    <div class="p-4 sm:p-6">
                        <h3 class="text-lg sm:text-xl font-semibold text-gray-800 mb-2">{{ $room->name }}</h3>
                        <p class="text-green-600 font-bold text-lg mb-3">PHP {{ $room->rate }} / Night</p>

                        <!-- Highlights -->
                        <div class="mb-4 flex flex-wrap gap-2">
                            <span class="flex items-center bg-gray-100 text-gray-700 px-3 py-1 rounded-full">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 18l-6-6h12l-6 6zM6 8h8V6H6v2zm8 2H6v2h8v-2z"></path>
                                </svg>
                                Relaxing
                            </span>
                            <span class="flex items-center bg-gray-100 text-gray-700 px-3 py-1 rounded-full">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 15H4V5h12v10H10zM12 7H8V9h4V7z"></path>
                                </svg>
                                Free Wi-Fi
                            </span>
                            <span class="flex items-center bg-gray-100 text-gray-700 px-3 py-1 rounded-full">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 1L2 6v9c0 .6.4 1 1 1h2v-7h10v7h2c.6 0 1-.4 1-1V6l-8-5zM10 3l6 3.8V9H4V6.8L10 3z"></path>
                                </svg>
                                Flat Screen Tv Included
                            </span>
                        </div>

                        <div class="flex justify-between items-center">
                            <a href="/rooms/{{ $room->room_id }}" class="bg-yellow-500 text-white font-semibold py-2 px-5 rounded-md transition hover:bg-yellow-600">Details</a>
                            <span class="text-sm text-gray-500">Limited availability</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <x-footer />
</x-layout>
