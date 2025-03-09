<x-layout>
    <x-navbar />

    <div class="relative bg-cover bg-center h-[300px] flex items-center justify-center"
        style="background-image: url('https://vnfoxcdnoahqenfjssdv.supabase.co/storage/v1/object/public/ecolodgesmr/images/main.jpg');">
        <div class="absolute inset-0 bg-blue-500 opacity-50"></div>
        <div class="container mx-auto relative z-10 flex items-center justify-center">
            <div class="text-center text-white">
                <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-4 sm:mb-6">View Room</h1>
                <nav class="text-sm sm:text-lg font-bold mb-4 sm:mb-8">
                    <a href="/dashboard" class="hover:underline">Home</a> /
                    <a href="{{ route('function-hall.show', ['hall_id' => $hall->hall_id]) }}" class="underline">View
                        Function Halls</a>
                </nav>
            </div>
        </div>
    </div>


    <div class="max-w-screen-lg mx-auto my-8 px-4 lg:px-0 flex flex-col lg:flex-row gap-8 w-full">
        <div class="w-full lg:w-2/3 flex flex-col gap-4">
            <img class="h-auto w-full rounded-lg shadow-xl dark:shadow-gray-800"
                src="{{ 'https://vnfoxcdnoahqenfjssdv.supabase.co/storage/v1/object/public/ecolodgesmr/images/' . $hall->hall_name . '.jpg' }}"
                alt="Main Room Image">
        </div>


        <div class="w-full lg:w-1/3 flex flex-col space-y-8">
            <div class="flex flex-col items-start p-4 bg-white shadow-md rounded-lg space-y-4 h-full">
                <div>
                    <h3 class="text-lg sm:text-xl font-bold text-gray-900">{{ $hall->hall_name }}</h3>
                    <p class="text-gray-700">
                        <span class="font-bold">{{ $hall->rate }}</span> / Day
                    </p>
                </div>

                @if (auth()->check())
                    <a href="{{ url('/checkout/hall/' . $hall->hall_id) }}"
                        class="bg-yellow-500 text-white font-bold py-2 px-6 rounded-lg hover:bg-yellow-600 w-full text-center block text-sm sm:text-base">
                         Book Now
                    </a>
                @else
                    <a href="{{ route('guest.book', ['type' => 'hall', 'id' => $hall->hall_id]) }}"
                        class="block w-full mt-4 px-6 py-3 bg-yellow-600 text-white font-medium rounded-lg hover:bg-yellow-700 transition-colors text-center">
                        Book Now
                    </a>
                @endif


                <div class="flex space-x-2">
                    <span class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg shadow">Nice and Clean</span>
                    <span class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg shadow">Good for any type of
                        Events</span>
                </div>
            </div>


            <div class="p-4 bg-white shadow-md rounded-lg">
                <h2 class="text-xl sm:text-2xl font-bold mb-4">{{ $hall->hall_type }}</h2>
                <p class="text-gray-700">{{ $hall->description }}</p>
            </div>


            <div class="p-4 bg-white shadow-md rounded-lg">
                <h3 class="text-lg sm:text-xl font-bold mb-4">Inclusion</h3>
                <ul class="list-disc list-inside text-gray-700">
                    <li>Sound System</li>
                    <li>Tables</li>
                    <li>Chairs</li>
                </ul>
            </div>


            <div class="p-4 bg-white shadow-md rounded-lg">
                <h3 class="text-lg sm:text-xl font-bold mb-4">Function Hall Note</h3>
                <p class="text-gray-700">Valid for up to 4 hours usage only. Additional charge is applied for each
                    succeeding hour. </p>
            </div>

        </div>
    </div>

    <x-footer />
</x-layout>
