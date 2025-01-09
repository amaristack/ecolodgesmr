<x-layout>
    <x-navbar />

    <div class="container mx-auto p-6 space-y-8 max-w-5xl">
        <!-- Booking Form -->
        <form id="booking-form" class="bg-white p-6 rounded-lg shadow-md space-y-6" action="{{ route('checkAvailability') }}" method="POST">
            @csrf
            <h2 class="text-2xl font-bold text-gray-800 text-center">Check Availability</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Check-in Date -->
                <div>
                    <label for="checkin" class="block text-sm font-semibold text-gray-700">Check-in Date</label>
                    <input type="date" name="checkin" id="checkin" required
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 text-gray-900 p-2">
                </div>

                <!-- Check-out Date -->
                <div>
                    <label for="checkout" class="block text-sm font-semibold text-gray-700">Check-out Date</label>
                    <input type="date" name="checkout" id="checkout" required
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 text-gray-900 p-2">
                </div>
            </div>

            <!-- Category Select -->
            <div>
                <label for="category" class="block text-sm font-semibold text-gray-700">Category</label>
                <select name="category" id="category" required
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 text-gray-900 p-2">
                    <option value="rooms">Rooms</option>
                    <option value="activity">Activities</option>
                    <option value="cottages">Cottages</option>
                    <option value="function_hall">Function Hall</option>
                </select>
            </div>

            <!-- Check Availability Button -->
            <button type="submit"
                    class="w-full bg-gradient-to-r from-blue-500 to-teal-500 hover:from-blue-600 hover:to-teal-600 text-white py-3 px-4 rounded-md font-semibold transition ease-in-out duration-150">
                Check Availability
            </button>
        </form>

        <!-- Display Available Items -->
        <div class="bg-gradient-to-r from-blue-50 via-teal-50 to-blue-100 p-6 rounded-lg shadow-md max-w-5xl mx-auto">
            <h2 class="text-2xl font-bold text-gray-800 mb-4 text-center">Available {{ ucfirst($category) }}</h2>
            @if(isset($items) && $items->isNotEmpty())
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($items as $item)
                        @if($category === 'rooms')
                            <a href="{{ route('rooms.show', $item->room_id) }}"
                               class="block p-4 bg-white rounded-lg shadow-md text-center hover:bg-gradient-to-r hover:from-blue-200 hover:to-teal-200 transition">
                                <img src="{{ 'https://vnfoxcdnoahqenfjssdv.supabase.co/storage/v1/object/public/ecolodgesmr/images/' . ($item->room_type) . '.jpg' }}" alt="{{ $item->room_type }}" class="w-full h-48 object-cover rounded-lg mb-4">
                                <h3 class="text-lg font-semibold text-gray-800">Room: {{ $item->name }}</h3>
                                <p class="text-gray-600">Availability: {{ $item->availability }}</p>
                            </a>
                        @elseif($category === 'activity')
                            <a href="{{ route('activities.show', $item->activity_id) }}"
                               class="block p-4 bg-white rounded-lg shadow-md text-center hover:bg-gradient-to-r hover:from-blue-200 hover:to-teal-200 transition">
                                <img src="{{ 'https://vnfoxcdnoahqenfjssdv.supabase.co/storage/v1/object/public/ecolodgesmr/images/' . ($item->activity_name) . '.jpg' }}" alt="{{ $item->activity_name }}" class="w-full h-48 object-cover rounded-lg mb-4">
                                <h3 class="text-lg font-semibold text-gray-800">Activity: {{ $item->activity_name }}</h3>
                                <p class="text-gray-600">Availability: {{ $item->availability }}</p>
                            </a>
                        @elseif($category === 'cottages')
                            <a href="{{ route('pools.show', $item->pool_id) }}"
                               class="block p-4 bg-white rounded-lg shadow-md text-center hover:bg-gradient-to-r hover:from-blue-200 hover:to-teal-200 transition">
                                <img src="{{ 'https://vnfoxcdnoahqenfjssdv.supabase.co/storage/v1/object/public/ecolodgesmr/images/' . ($item->cottage_name) . '.jpg' }}" alt="{{ $item->cottage_name }}" class="w-full h-48 object-cover rounded-lg mb-4">
                                <h3 class="text-lg font-semibold text-gray-800">Cottage: {{ $item->cottage_name }}</h3>
                                <p class="text-gray-600">Availability: {{ $item->availability }}</p>
                            </a>
                        @elseif($category === 'function_hall')
                            <a href="{{ route('function-hall.show', $item->hall_id) }}"
                               class="block p-4 bg-white rounded-lg shadow-md text-center hover:bg-gradient-to-r hover:from-blue-200 hover:to-teal-200 transition">
                                <img src="{{ 'https://vnfoxcdnoahqenfjssdv.supabase.co/storage/v1/object/public/ecolodgesmr/images/' . ($item->hall_name) . '.jpg' }}" alt="{{ $item->type }}" class="w-full h-48 object-cover rounded-lg mb-4">
                                <h3 class="text-lg font-semibold text-gray-800">Function Hall: {{ $item->type }}</h3>
                                <p class="text-gray-600">Availability: {{ $item->availability }}</p>
                            </a>
                        @endif
                    @endforeach
                </div>
            @else
                <p class="text-center text-gray-500">No available items for the selected category and date.</p>
            @endif
        </div>
    </div>

    <x-footer />
</x-layout>
