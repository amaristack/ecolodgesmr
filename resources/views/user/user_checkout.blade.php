<!-- resources/views/user/user_checkout.blade.php -->

<x-layout>
    <x-navbar/>

    <!-- Banner Section -->
    <div class="relative bg-cover bg-center h-[300px] flex items-center justify-center"
         style="background-image: url('https://vnfoxcdnoahqenfjssdv.supabase.co/storage/v1/object/public/ecolodgesmr/images/main.jpg');">
        <div class="absolute inset-0 bg-blue-500 opacity-50"></div>
        <div class="container mx-auto relative z-10 flex items-center justify-center">
            <div class="text-center text-white">
                <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-4 sm:mb-6">
                    {{ ucfirst($type) }} Checkout
                </h1>
                <nav class="text-sm sm:text-lg font-bold mb-4 sm:mb-8">
                    <a href="/dashboard" class="hover:underline">Home</a> /
                    <a href="/{{ $type }}/{{ $item->id }}" class="underline">View {{ ucfirst($type) }}</a>
                </nav>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto p-8">
        <!-- Begin Form wrapping both sections -->
        <form action="{{ route('book') }}" method="POST">
            @csrf

            <!-- Display Validation Errors -->
            @if ($errors->any())
                <div class="mb-4 text-red-600">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Hidden Input Fields -->
            @php
                $itemId = null;
                if ($type == 'rooms') {
                    $itemId = $item->room_id;
                } elseif ($type == 'cottages') {
                    $itemId = $item->pool_id;
                } elseif ($type == 'activity') {
                    $itemId = $item->activity_id;
                } elseif ($type == 'hall') {
                    $itemId = $item->hall_id;
                }
            @endphp

            <input type="hidden" name="item_type" value="{{ $type }}">
            <input type="hidden" name="item_id" value="{{ $itemId }}">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                <!-- Booking Request Information -->
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <h2 class="text-xl font-semibold mb-4">Booking Request Information</h2>

                    <!-- User Information -->
                    <div class="mb-4">
                        <input type="text" name="name" placeholder="Full Name" class="w-full p-3 border rounded-md"
                               required
                               value="{{ $users->first_name }} {{ $users->last_name }}">
                    </div>
                    <div class="mb-4 grid grid-cols-2 gap-4">
                        <input type="email" name="email" placeholder="Email" class="w-full p-3 border rounded-md"
                               required
                               value="{{ $users->email }}">
                        <input type="text" name="phone" placeholder="Phone Number" class="w-full p-3 border rounded-md"
                               required
                               value="{{ $users->phone_number }}">
                    </div>
                    <div class="mb-4">
                        <input type="text" name="address" placeholder="Address" class="w-full p-3 border rounded-md"
                               required
                               value="{{ $users->address }}">
                    </div>

                    @if($type == 'rooms')
                        <div class="mb-4">
                            <label for="number_of_persons" class="block mb-2 font-medium text-gray-700">
                                Number of Persons (Max {{ $item->max_people }}):
                            </label>
                            <input
                                type="number"
                                name="number_of_person"
                                id="number_of_persons"
                                min="1"
                                max="{{ $item->max_people }}"
                                value="{{ old('number_of_person', 1) }}"
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                required
                            />
                            @error('number_of_persons')
                                <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Guest List Container -->
                        <div class="mb-4" id="guest_list">
                            <!-- Guest name inputs will be injected here by JavaScript -->
                        </div>
                    @endif

                    <!-- Note Field -->
                    <div class="mb-4">
                        <textarea name="note" placeholder="Note" class="w-full p-3 border rounded-md"></textarea>
                    </div>

                    <!-- Important Booking Information -->
                    <div id="alert-additional-content-1" class="p-4 mb-4 text-blue-800 border border-blue-300 rounded-lg bg-blue-50" role="alert">
                        <div class="flex items-center">
                            <svg class="flex-shrink-0 w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                            </svg>
                            <span class="sr-only">Info</span>
                            <h3 class="text-lg font-medium">Important Booking Information</h3>
                        </div>
                        <div class="mt-2 mb-4 text-sm">
                            Please note that a 50% down payment is required to confirm your booking. Once the down payment is received, your booking will be finalized. The remaining balance can be settled upon check-in or as per our terms.
                        </div>
                        <div class="flex">
                            <a href="{{ route('terms_and_condition') }}" class="text-white bg-blue-800 hover:bg-blue-900 focus:ring-4 focus:outline-none focus:ring-blue-200 font-medium rounded-lg text-xs px-3 py-1.5 me-2 text-center inline-flex items-center">
                                View T&C
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Booking Summary -->
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <h2 class="text-xl font-semibold mb-4">Booking Summary</h2>
                    <div class="mb-4">
                        @if($type == 'rooms')
                            <!-- For Rooms -->
                            <img src="{{ 'https://vnfoxcdnoahqenfjssdv.supabase.co/storage/v1/object/public/ecolodgesmr/images/' . ($item->room_type) . '.jpg' }}"
                                 alt="Room Image" class="w-full rounded-lg mb-4">
                            <h3 class="text-lg font-semibold">{{ $item->room_name }}</h3>
                            <p class="font-bold">PHP {{ $item->rate }} / Night</p>
                            <p>Capacity: {{ $item->max_people }} People</p>
                            <input type="hidden" name="room_id" value="{{ $item->room_id }}">
                        @elseif($type == 'cottages')
                            <!-- For Cottages -->
                            <img src="{{ 'https://vnfoxcdnoahqenfjssdv.supabase.co/storage/v1/object/public/ecolodgesmr/images/' . ($item->cottage_name) . '.jpg' }}"
                                 alt="Cottage Image" class="w-full rounded-lg mb-4">
                            <h3 class="text-lg font-semibold">{{ $item->cottage_name }}</h3>
                            <p class="font-bold">PHP {{ $item->rate }} / Day</p>
                            <input type="hidden" name="pool_id" value="{{ $item->pool_id }}">
                        @elseif($type == 'activity')
                            <!-- For Activities -->
                            <img src="{{ 'https://vnfoxcdnoahqenfjssdv.supabase.co/storage/v1/object/public/ecolodgesmr/images/' . ($item->activity_name) . '.jpg' }}"
                                 alt="Activity Image" class="w-full rounded-lg mb-4">
                            <h3 class="text-lg font-semibold">{{ $item->activity_name }}</h3>
                            <p class="font-bold">PHP {{ $item->rate }} per Person</p>
                            <p>Duration: {{ $item->duration }} Hours</p>
                            <input type="hidden" name="activity_id" value="{{ $item->activity_id }}">
                        @elseif($type == 'hall')
                            <!-- For Hall -->
                            <img src="{{ 'https://vnfoxcdnoahqenfjssdv.supabase.co/storage/v1/object/public/ecolodgesmr/images/' . ($item->hall_name) . '.jpg' }}"
                                 alt="Hall Image" class="w-full rounded-lg mb-4">
                            <h3 class="text-lg font-semibold">{{ $item->hall_name }}</h3>
                            <p class="font-bold">PHP {{ $item->rate }} / Event</p>
                            <input type="hidden" name="hall_id" value="{{ $item->hall_id }}">
                        @endif
                    </div>

                    <!-- Date and Quantity Fields -->
                    @if($type == 'rooms' || $type == 'cottages' || $type == 'activity' || $type == 'hall')
                        <div class="mb-4">
                            <label for="checkin" class="block font-semibold">Check In</label>
                            <input type="date" name="check_in" id="checkin"
                                   min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                   class="w-full p-3 border rounded-md"
                                   required
                                   value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                        </div>
                        <div class="mb-4">
                            <label for="checkout" class="block font-semibold">Check Out</label>
                            <input type="date" name="check_out" id="checkout"
                                   min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                   class="w-full p-3 border rounded-md"
                                   required
                                   value="{{ \Carbon\Carbon::now()->addDay()->format('Y-m-d') }}">
                        </div>
                        <!-- Quantity Field -->
                        <div class="mb-4">
                            <label for="quantity" class="block font-semibold">Quantity</label>
                            <input type="number" name="quantity" id="quantity" min="1" value="1"
                                   class="w-full p-3 border rounded-md"
                                   required>
                        </div>
                    @endif

                    <!-- Hidden input to pass the price -->
                    <input type="hidden" name="rate" value="{{ $item->rate }}">

                    <!-- Availability and Pricing -->
                    <div class="mb-4">
                        <p>Availability: <span
                                class="font-semibold">{{ $item->availability }} {{ ucfirst($type) }}</span></p>
                    </div>
                    <div class="mb-4">
                        <p>Subtotal: PHP <span id="subtotal">{{ $item->rate }}</span></p>
                        <p>Discount: PHP <span id="discount">0</span></p>
                        <p>Total: PHP <span id="total">{{ $item->rate }}</span></p>
                    </div>

                    <button type="submit" class="w-full bg-red-500 text-white py-3 rounded-lg hover:bg-red-600 mt-4">
                        Pay Now
                    </button>

                </div>
            </form>
            <!-- End Form wrapping both sections -->
    </div>

    <x-footer/>

    <!-- JavaScript to Handle Dynamic Guest List and Pricing -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const numberOfPersonsInput = document.getElementById('number_of_persons');
            const guestListContainer = document.getElementById('guest_list');
            const checkinInput = document.getElementById('checkin');
            const checkoutInput = document.getElementById('checkout');
            const rateInput = document.querySelector('input[name="rate"]');
            const subtotalSpan = document.getElementById('subtotal');
            const discountSpan = document.getElementById('discount');
            const totalSpan = document.getElementById('total');
            const quantityInput = document.getElementById('quantity');

            function updateGuestList() {
                const numberOfPersons = parseInt(numberOfPersonsInput.value) || 1;
                guestListContainer.innerHTML = ''; // Clear existing guest inputs

                for (let i = 1; i <= numberOfPersons; i++) {
                    const guestDiv = document.createElement('div');
                    guestDiv.classList.add('mb-2');

                    const guestLabel = document.createElement('label');
                    guestLabel.setAttribute('for', `guest_name_${i}`);
                    guestLabel.classList.add('block', 'mb-1', 'font-medium', 'text-gray-700');
                    guestLabel.textContent = `Guest ${i} Name:`;

                    const guestInput = document.createElement('input');
                    guestInput.type = 'text';
                    guestInput.name = `guest_names[${i}]`;
                    guestInput.id = `guest_name_${i}`;
                    guestInput.placeholder = `Enter name for Guest ${i}`;
                    guestInput.classList.add('w-full', 'p-2', 'border', 'rounded-md');
                    guestInput.required = true;

                    guestDiv.appendChild(guestLabel);
                    guestDiv.appendChild(guestInput);
                    guestListContainer.appendChild(guestDiv);
                }
            }

            function calculateDays() {
                const checkinDate = new Date(checkinInput.value);
                const checkoutDate = new Date(checkoutInput.value);
                const timeDiff = checkoutDate - checkinDate;
                const days = Math.ceil(timeDiff / (1000 * 60 * 60 * 24));
                return days > 0 ? days : 1;
            }

            function updatePricing() {
                const rate = parseFloat(rateInput.value) || 0;
                const days = calculateDays();
                const quantity = parseInt(quantityInput.value) || 1;
                const subtotal = rate * days * quantity;
                const discount = 0; // adjust if needed
                const total = subtotal - discount;

                subtotalSpan.textContent = subtotal.toFixed(2);
                discountSpan.textContent = discount.toFixed(2);
                totalSpan.textContent = total.toFixed(2);
            }

            if (numberOfPersonsInput) {
                // Initialize guest list on page load
                updateGuestList();

                // Update guest list when number of persons changes
                numberOfPersonsInput.addEventListener('input', updateGuestList);
            }

            // Initialize pricing on page load
            updatePricing();

            // Update pricing when check-in, check-out, or quantity changes
            if (checkinInput && checkoutInput && quantityInput) {
                checkinInput.addEventListener('change', updatePricing);
                checkoutInput.addEventListener('change', updatePricing);
                quantityInput.addEventListener('change', updatePricing);
            }
        });
    </script>
</x-layout>
