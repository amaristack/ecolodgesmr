<x-layout>
    <x-navbar/>

    <div class="relative bg-cover bg-center h-[300px] flex items-center justify-center"
         style="background-image: url('{{ \Illuminate\Support\Facades\Vite::asset('resources/images/main.jpg') }}');">
        <div class="absolute inset-0 bg-blue-500 opacity-50"></div>
        <div class="container mx-auto relative z-10 flex items-center justify-center">
            <div class="text-center text-white">
                <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-4 sm:mb-6">View Room</h1>
                <nav class="text-sm sm:text-lg font-bold mb-4 sm:mb-8">
                    <a href="/dashboard" class="hover:underline">Home</a> /
                    <a href="/rooms/{{ $activity->activity_id }}" class="underline">View Rooms</a>
                </nav>
            </div>
        </div>
    </div>


    <div class="max-w-screen-lg mx-auto my-8 px-4 lg:px-0 flex flex-col lg:flex-row gap-8 w-full">
        <div class="w-full lg:w-2/3 flex flex-col gap-4">
            <img class="h-auto w-full rounded-lg shadow-xl dark:shadow-gray-800"
                 src="{{ Vite::asset('resources/images/' . strtolower($activity->activity_name) . '.jpg') }}"
                 alt="Main Room Image">
        </div>


        <div class="w-full lg:w-1/3 flex flex-col space-y-8">
            <div class="flex flex-col items-start p-4 bg-white shadow-md rounded-lg space-y-4 h-full">
                <div>
                    <h3 class="text-lg sm:text-xl font-bold text-gray-900">{{ $activity->activity_name }}</h3>
                    <p class="text-gray-700">
                        <span class="font-bold">{{ $activity->price }}</span> / Night
                    </p>
                </div>

                <a href="{{ url('/checkout/activity/' . $activity->activity_id) }}"
                   class="bg-yellow-500 text-white font-bold py-2 px-6 rounded-lg hover:bg-yellow-600 w-full text-center block text-sm sm:text-base">
                    Book Now
                </a>


                <div class="flex space-x-2">
                    <span class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg shadow">Tour Guide 2</span>
                    <span class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg shadow">Person 5</span>
                </div>
            </div>


            <div class="p-4 bg-white shadow-md rounded-lg">
                <h2 class="text-xl sm:text-2xl font-bold mb-4">{{ $activity->activity_name }}</h2>
                <ul class="list-disc list-inside text-gray-700">
                    <li>{{ $activity->activity_description }}</li>
                </ul>
            </div>




            <div class="p-4 bg-white shadow-md rounded-lg">
                <h3 class="text-lg sm:text-xl font-bold mb-4">Complements</h3>
                <p class="text-gray-700">Enjoy a bottle of wine on arrival, along with a complimentary fruit basket.
                    Special arrangements for anniversaries or birthdays can also be made on request.</p>
            </div>


            <div class="p-4 bg-white shadow-md rounded-lg">
                <h3 class="text-lg sm:text-xl font-bold mb-4">Beds</h3>
                <ul class="list-disc list-inside text-gray-700">
                    <li>King-size bed</li>
                    <li>Extra sofa bed available on request</li>
                </ul>
            </div>
        </div>
    </div>


    <x-footer/>
</x-layout>
