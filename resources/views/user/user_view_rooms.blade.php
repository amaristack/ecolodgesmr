<x-layout>
    <x-navbar/>

    <!-- Hero Section -->
    <div class="relative bg-cover bg-center h-[180px] sm:h-[250px] md:h-[300px] lg:h-[350px] flex items-center justify-center"
         style="background-image: url('https://vnfoxcdnoahqenfjssdv.supabase.co/storage/v1/object/public/ecolodgesmr/images/main.jpg')">
        <div class="absolute inset-0 bg-blue-600 opacity-40"></div>
        <div class="container mx-auto relative z-10 px-4 sm:px-8 text-center text-white">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-semibold mb-2 sm:mb-4">Explore Our Rooms</h1>
            <nav class="text-sm md:text-base font-medium">
                <a href="/dashboard" class="hover:underline">Home</a> /
                <a href="/rooms/{{ $room->room_id }}" class="underline">View Rooms</a>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-screen-xl mx-auto mt-6 sm:mt-8 px-4 lg:px-6 grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8 mb-12">
        <!-- Image and Highlights -->
        <div class="col-span-2 flex flex-col gap-4">
            <div class="relative">
                <img class="w-full h-64 sm:h-80 md:h-[350px] lg:h-[400px] object-cover rounded-lg shadow-lg"
                     style="object-position: center 80%;"
                     src="{{ 'https://vnfoxcdnoahqenfjssdv.supabase.co/storage/v1/object/public/ecolodgesmr/images/' . ($room->room_type) . '.jpg' }}"
                     alt="{{ $room->room_type }} Image">
            </div>

            <!-- Highlights -->
            <div class="p-4 bg-white shadow-md rounded-lg">
                <h2 class="text-lg sm:text-xl font-semibold mb-3">Room Highlights</h2>
                <div class="flex flex-wrap gap-2">
                    <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full">Relaxing</span>
                    <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full">Comfortable</span>
                    <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full">Scenic View</span>
                </div>
            </div>
        </div>

        <!-- Booking Details -->
        <div class="flex flex-col space-y-6">
            <div class="p-5 bg-white shadow-md rounded-lg">
                <h3 class="text-lg sm:text-xl font-bold text-gray-900">{{ $room->room_type }}</h3>
                <p class="text-gray-700 mt-2">
                    <span class="text-xl sm:text-2xl font-bold">{{ $room->rate }}</span> / Night
                </p>
                <a href="{{ url('/checkout/rooms/' . $room->room_id) }}"
                   class="block bg-yellow-500 text-white font-semibold py-2 mt-4 rounded-lg text-center hover:bg-yellow-600 transition-all">
                    Book Now
                </a>
            </div>

            <!-- Room Description -->
            <div class="p-5 bg-white shadow-md rounded-lg">
                <h3 class="text-lg sm:text-xl font-semibold mb-2">Description</h3>
                <p class="text-gray-700">{{ $room->description }}</p>
            </div>

            <!-- Amenities -->
            <div class="p-5 bg-white shadow-md rounded-lg">
                <h3 class="text-lg sm:text-xl font-semibold mb-2">Amenities</h3>
                <ul class="list-disc list-inside text-gray-700 space-y-1">
                    <li>Free Wi-Fi</li>
                    <li>24/7 Room Service</li>
                    <li>Flat-screen TV</li>
                    <li>Air Conditioning</li>
                </ul>
            </div>

            <!-- Beds -->
            <div class="p-5 bg-white shadow-md rounded-lg">
                <h3 class="text-lg sm:text-xl font-semibold mb-2">Beds</h3>
                <ul class="list-disc list-inside text-gray-700 space-y-1">
                    <li>Double size bed</li>
                    <li>Extra bed available on request</li>
                </ul>
            </div>
        </div>
    </div>

    <x-footer/>
</x-layout>
