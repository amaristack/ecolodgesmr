<x-layout>
    <x-navbar/>

    <div class="relative bg-cover bg-center h-[350px] sm:h-[400px] flex items-center justify-center"
         style="background-image: url('https://vnfoxcdnoahqenfjssdv.supabase.co/storage/v1/object/public/ecolodgesmr/images/main.jpg');">
        <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent"></div>
        <div class="container mx-auto relative z-10 text-center text-white">
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold mb-4">View Room</h1>
            <nav class="text-sm sm:text-lg font-semibold mb-6">
                <a href="/dashboard" class="hover:underline">Home</a> /
                <a href="/rooms/{{ $pool->pool_id }}" class="underline">View Rooms</a>
            </nav>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="max-w-screen-lg mx-auto my-10 px-4 lg:px-6 flex flex-col lg:flex-row gap-8 w-full">
        <!-- Left Column - Image -->
        <div class="w-full lg:w-2/3 flex justify-center">
            <img class="w-full h-auto object-cover rounded-lg shadow-lg"
                 src="{{ 'https://vnfoxcdnoahqenfjssdv.supabase.co/storage/v1/object/public/ecolodgesmr/images/' . ($pool->cottage_name) . '.jpg' }}"
                 alt="Main Room Image">
        </div>

        <!-- Right Column - Room Info & Description -->
        <div class="w-full lg:w-1/3 flex flex-col space-y-8">
            <!-- Cottage Info -->
            <div class="flex flex-col items-start p-6 bg-white shadow-xl rounded-lg space-y-4">
                <h3 class="text-xl sm:text-2xl font-bold text-gray-900">{{ $pool->cottage_name }}</h3>
                <p class="text-lg text-gray-800">
                    <span class="font-semibold text-yellow-600">{{ $pool->rate }}</span> / Day
                </p>
                <a href="{{ url('/checkout/cottages/' . $pool->pool_id) }}"
                   class="bg-yellow-600 text-white font-bold py-2 px-6 rounded-lg hover:bg-yellow-700 w-full text-center text-sm sm:text-base">
                    Book Now
                </a>
                <div class="flex space-x-3 text-gray-600">
                    <span class="bg-gray-200 text-gray-700 px-4 py-2 rounded-full shadow-md">Relaxing</span>
                    <span class="bg-gray-200 text-gray-700 px-4 py-2 rounded-full shadow-md">Pool View</span>
                    <span class="bg-gray-200 text-gray-700 px-4 py-2 rounded-full shadow-md">River Access</span>
                </div>
            </div>

            <!-- Room Description -->
            <div class="p-6 bg-white shadow-xl rounded-lg">
                <h2 class="text-lg sm:text-xl font-semibold mb-4 text-gray-800">Description</h2>
                <p class="text-gray-700">{{ $pool->description }}</p>
            </div>

            <!-- Entrance Fee -->
            <div class="p-6 bg-white shadow-xl rounded-lg">
                <h3 class="text-lg sm:text-xl font-semibold mb-4 text-gray-800">Entrance Fee</h3>
                <ul class="list-disc list-inside text-gray-700 space-y-2">
                    <li><i class="fa fa-user text-yellow-600"></i> Adult: PHP 50.00</li>
                    <li><i class="fa fa-person-cane text-yellow-600"></i> Senior: PHP 40.00</li>
                    <li><i class="fa fa-child text-yellow-600"></i> Child: PHP 30.00</li>
                    <li><i class="fa fa-house text-yellow-600"></i> Albuera Resident: PHP 45.00</li>
                </ul>
            </div>
        </div>
    </div>

    <x-footer/>
</x-layout>
