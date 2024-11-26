<x-layout>
    <x-navbar/>
    <div class="relative bg-cover bg-center h-[350px] flex items-center justify-center"
         style="background-image: url('https://vnfoxcdnoahqenfjssdv.supabase.co/storage/v1/object/public/ecolodgesmr/images/main.jpg');">
        <div class="absolute inset-0 bg-gradient-to-b from-black/60 to-transparent"></div>
        <div class="container mx-auto relative z-10 text-center text-white">
            <h1 class="text-5xl font-extrabold mb-4">Choose your Activity</h1>
            <nav class="text-white text-lg font-medium">
                <a href="/dashboard" class="hover:text-yellow-400">Home</a> /
                <a href="/activities" class="text-yellow-400">Activities</a>
            </nav>
        </div>
    </div>

    <section class="container mx-auto px-4 py-16">
        <!-- Section Title -->
        <div class="text-center mb-12">
            <h2 class="text-lg text-yellow-500 font-semibold">Thrilling Outdoor Adventures</h2>
            <h1 class="text-4xl font-extrabold text-gray-900 mb-6">Featured Activities</h1>
            <p class="text-gray-700 max-w-3xl mx-auto leading-relaxed">Explore our wide range of activities that promise
                unforgettable experiences.</p>
        </div>

        <!-- Activity Cards Section -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-10">
            @foreach($activity as $index => $act)
                <div
                    class="bg-white rounded-xl shadow-lg overflow-hidden group hover:shadow-2xl transition transform hover:-translate-y-1">
                    <div class="relative">
                        <img src="{{ 'https://vnfoxcdnoahqenfjssdv.supabase.co/storage/v1/object/public/ecolodgesmr/images/' . ($act->activity_name) . '.jpg' }}"
                             alt="{{ $act->activity_names }}"
                             class="w-full h-56 object-cover transition duration-300 ease-in-out group-hover:scale-105">
                        @if ($index === 0)
                            <div class="absolute top-0 right-0 bg-red-600 text-white font-bold py-1 px-3 rounded-bl-lg">
                                Top Adventure
                            </div>
                        @elseif ($index === 1)
                            <div
                                class="absolute top-0 right-0 bg-green-500 text-white font-bold py-1 px-3 rounded-bl-lg">
                                Family Favorite
                            </div>
                        @elseif ($index === 2)
                            <div
                                class="absolute top-0 right-0 bg-yellow-500 text-white font-bold py-1 px-3 rounded-bl-lg">
                                Must Try
                            </div>
                        @else
                            <div
                                class="absolute top-0 right-0 bg-blue-500 text-white font-bold py-1 px-3 rounded-bl-lg">
                                Hidden Gem
                            </div>
                        @endif
                    </div>
                    <div class="p-6">
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">{{ $act->activity_name }}</h3>
                        <p class="text-sm text-gray-500 mb-3">
                            @if ($index === 0)
                                Experience the rush of canyoning through cascading waterfalls and natural slides.
                            @elseif ($index === 1)
                                Perfect for the whole family, enjoy safe and fun-filled adventures.
                            @elseif ($index === 2)
                                Don't miss out on this top-rated activity that everyone talks about.
                            @else
                                Discover this unique experience away from the usual tourist path.
                            @endif
                        </p>
                        <p class="text-green-700 font-semibold text-xl mb-2">PHP{{ number_format($act->rate, 2) }} /
                            Person</p>
                        <div class="flex justify-between items-center">
                            <a href="/activities/{{ $act->activity_id }}"
                               class="inline-block bg-indigo-600 text-white font-semibold py-2 px-4 rounded-lg mt-4 transition-colors duration-200 hover:bg-indigo-700">Book
                                Now</a>
                            @if ($index === 0)
                                <span class="text-red-500 text-sm font-semibold">Limited Slots!</span>
                            @elseif ($index === 1)
                                <span class="text-green-500 text-sm font-semibold">Perfect for All Ages</span>
                            @elseif ($index === 2)
                                <span class="text-yellow-500 text-sm font-semibold">Best Value</span>
                            @else
                                <span class="text-blue-500 text-sm font-semibold">Exclusive</span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <x-footer/>
</x-layout>
