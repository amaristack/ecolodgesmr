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
                            <p class="mb-2">You'll have two payment options on the next page:</p>
                            <ul class="list-disc pl-5 space-y-1">
                                <li><strong>Down Payment (50%):</strong> Pay half now to secure your booking. The remaining balance can be settled upon check-in.</li>
                                <li><strong>Full Payment:</strong> Pay the entire amount now for convenience and faster check-in.</li>
                            </ul>
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
                            <input type="date"
                                   name="check_in"
                                   id="checkin"
                                   min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                   class="w-full p-3 border rounded-md"
                                   required
                                   value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                        </div>
                        <div class="mb-4">
                            <label for="checkout" class="block font-semibold">Check Out</label>
                            <input type="date"
                                   name="check_out"
                                   id="checkout"
                                   class="w-full p-3 border rounded-md disabled:bg-gray-100 disabled:cursor-not-allowed"
                                   required
                                   disabled>
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
                    <div class="space-y-6">
                        <!-- Availability Status -->
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <div class="flex items-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="text-gray-700">
                                    Available Units:
                                    <span class="font-semibold text-green-600">
                                        {{ $item->availability }} {{ ucfirst($type) }}
                                    </span>
                                </p>
                            </div>
                        </div>

                        <!-- Pricing Summary -->
                        <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-2 border-b">
                                Pricing Summary
                            </h3>

                            <div class="space-y-3">
                                <!-- Subtotal Row -->
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Subtotal</span>
                                    <div class="flex items-center">
                                        <span class="text-sm text-gray-500 mr-1">PHP</span>
                                        <span id="subtotal" class="font-semibold text-gray-900">
                                            {{ $item->rate }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Discount Row -->
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Discount</span>
                                    <div class="flex items-center">
                                        <span class="text-sm text-gray-500 mr-1">PHP</span>
                                        <span id="discount" class="font-semibold text-red-500">0</span>
                                    </div>
                                </div>

                                <!-- Total Row -->
                                <div class="mt-4 pt-3 border-t">
                                    <div class="flex justify-between items-center">
                                        <span class="text-lg font-semibold text-gray-900">Total</span>
                                        <div class="flex items-center">
                                            <span class="text-sm text-gray-500 mr-1">PHP</span>
                                            <span id="total" class="text-xl font-bold text-gray-900">
                                                {{ $item->rate }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-yellow-500 text-white py-3 rounded-lg hover:bg-yellow-600 mt-4">
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
            const itemType = '{{ $type }}'; // Get the item type from the server

            let entranceFeePerPerson = 0;
            let maxGuests = 0;

            // Set entrance fee and max guests based on item type
            if (itemType === 'cottages') {
                entranceFeePerPerson = 50; // 50 pesos entrance fee for cottages
                maxGuests = 20; // Max 20 guests for cottages

                // Create number of persons input for cottages if it doesn't exist
                if (!numberOfPersonsInput && itemType === 'cottages') {
                    // Create the container
                    const container = document.createElement('div');
                    container.classList.add('mb-4');

                    // Create label
                    const label = document.createElement('label');
                    label.setAttribute('for', 'number_of_persons');
                    label.classList.add('block', 'mb-2', 'font-medium', 'text-gray-700');
                    label.textContent = 'Number of Persons (Max 20):';

                    // Create input
                    const input = document.createElement('input');
                    input.type = 'number';
                    input.name = 'number_of_person';
                    input.id = 'number_of_persons';
                    input.min = '1';
                    input.max = '20';
                    input.value = '1';
                    input.required = true;
                    input.classList.add('block', 'w-full', 'px-3', 'py-2', 'border', 'border-gray-300', 'rounded-md', 'shadow-sm', 'focus:outline-none', 'focus:ring-2', 'focus:ring-blue-500', 'focus:border-transparent');

                    // Append to container
                    container.appendChild(label);
                    container.appendChild(input);

                    // Find the element to insert before
                    const noteField = document.querySelector('textarea[name="note"]').parentNode;
                    noteField.parentNode.insertBefore(container, noteField);

                    // Create guest list container if it doesn't exist
                    if (!guestListContainer) {
                        const guestListDiv = document.createElement('div');
                        guestListDiv.id = 'guest_list';
                        guestListDiv.classList.add('mb-4');
                        noteField.parentNode.insertBefore(guestListDiv, noteField);
                    }

                    // Update references
                    numberOfPersonsInput = document.getElementById('number_of_persons');
                    guestListContainer = document.getElementById('guest_list');
                }

                // Add event listener to newly created input
                if (numberOfPersonsInput) {
                    numberOfPersonsInput.addEventListener('input', function() {
                        updateGuestList();
                        updatePricing();
                    });
                }
            } else if (itemType === 'rooms') {
                maxGuests = parseInt('{{ $item->max_people }}') || 4;
                entranceFeePerPerson = 0; // No entrance fee for rooms
            }

            function updateGuestList() {
                if (!guestListContainer) return;

                const numberOfPersons = parseInt(numberOfPersonsInput?.value) || 1;
                let limitedPersons = numberOfPersons;

                // Limit number of persons based on item type
                if (itemType === 'cottages' && limitedPersons > maxGuests) {
                    limitedPersons = maxGuests;
                    numberOfPersonsInput.value = maxGuests;
                    alert(`Maximum number of guests for cottages is ${maxGuests}`);
                } else if (itemType === 'rooms' && limitedPersons > maxGuests) {
                    limitedPersons = maxGuests;
                    numberOfPersonsInput.value = maxGuests;
                    alert(`Maximum number of guests for this room is ${maxGuests}`);
                }

                guestListContainer.innerHTML = ''; // Clear existing guest inputs

                // Add heading for guest list
                const heading = document.createElement('h3');
                heading.classList.add('font-medium', 'text-gray-700', 'mb-2');
                heading.textContent = 'Guest List';
                guestListContainer.appendChild(heading);

                for (let i = 1; i <= limitedPersons; i++) {
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

                // Add note about entrance fee if it's a cottage
                if (itemType === 'cottages') {
                    const noteDiv = document.createElement('div');
                    noteDiv.classList.add('mt-3', 'text-sm', 'text-blue-600', 'italic');
                    noteDiv.textContent = `Note: An entrance fee of ₱50 per person will be applied (₱${entranceFeePerPerson * limitedPersons} total)`;
                    guestListContainer.appendChild(noteDiv);
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

                // Base amount (room/cottage rate * days * quantity)
                const baseAmount = rate * days * quantity;

                // Calculate entrance fees for cottages
                let entranceFees = 0;
                if (itemType === 'cottages' && numberOfPersonsInput) {
                    const numberOfPersons = parseInt(numberOfPersonsInput.value) || 1;
                    entranceFees = entranceFeePerPerson * numberOfPersons;
                }

                // Total values with entrance fees included
                const subtotal = baseAmount + entranceFees;
                const discount = 0; // adjust if needed
                const total = subtotal - discount;

                // Update displayed values
                subtotalSpan.textContent = subtotal.toFixed(2); // Display subtotal WITH entrance fees

                // Display entrance fee breakdown if cottage
                if (itemType === 'cottages') {
                    let entranceFeesRow = document.getElementById('entrance-fees-row');
                    if (!entranceFeesRow) {
                        // Create the entrance fees breakdown row
                        entranceFeesRow = document.createElement('div');
                        entranceFeesRow.id = 'entrance-fees-row';
                        entranceFeesRow.classList.add('flex', 'justify-between', 'items-center', 'text-sm', 'text-gray-500', 'mt-1');

                        const entranceLabel = document.createElement('span');
                        entranceLabel.textContent = '(Includes entrance fees)';

                        const entranceValueContainer = document.createElement('div');
                        entranceValueContainer.classList.add('flex', 'items-center');

                        const entranceDetails = document.createElement('span');
                        const numberOfPersons = parseInt(numberOfPersonsInput.value) || 1;
                        entranceDetails.textContent = `${numberOfPersons} × ₱${entranceFeePerPerson} = ₱${entranceFees.toFixed(2)}`;

                        entranceValueContainer.appendChild(entranceDetails);
                        entranceFeesRow.appendChild(entranceLabel);
                        entranceFeesRow.appendChild(entranceValueContainer);

                        // Insert after the subtotal row
                        const subtotalRow = subtotalSpan.closest('.flex');
                        subtotalRow.parentNode.insertBefore(entranceFeesRow, subtotalRow.nextSibling);
                    } else {
                        // Update existing row
                        const numberOfPersons = parseInt(numberOfPersonsInput.value) || 1;
                        entranceFeesRow.querySelector('div > span').textContent =
                            `${numberOfPersons} × ₱${entranceFeePerPerson} = ₱${entranceFees.toFixed(2)}`;
                    }
                }

                // Update discount and total displays
                discountSpan.textContent = discount.toFixed(2);
                totalSpan.textContent = total.toFixed(2);

                // Add hidden fields to store calculated values for the backend
                updateOrCreateHiddenInput('base_amount', baseAmount);
                updateOrCreateHiddenInput('entrance_fees', entranceFees);
                updateOrCreateHiddenInput('calculated_days', days);
                updateOrCreateHiddenInput('calculated_quantity', quantity);
                updateOrCreateHiddenInput('calculated_subtotal', subtotal); // Total subtotal including entrance fees
                updateOrCreateHiddenInput('calculated_total', total);

                if (numberOfPersonsInput) {
                    updateOrCreateHiddenInput('number_of_persons', numberOfPersonsInput.value);
                }
            }

            // Helper function to create or update hidden input fields
            function updateOrCreateHiddenInput(name, value) {
                let input = document.querySelector(`input[name="${name}"]`);
                if (!input) {
                    input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = name;
                    document.querySelector('form').appendChild(input);
                }
                input.value = value;
            }

            // Initialize guest list on page load if needed
            if ((itemType === 'rooms' || itemType === 'cottages') && numberOfPersonsInput) {
                updateGuestList();
            }

            // Initialize pricing on page load
            updatePricing();

            // Update pricing when check-in, check-out, or quantity changes
            if (checkinInput && checkoutInput && quantityInput) {
                checkinInput.addEventListener('change', updatePricing);
                checkoutInput.addEventListener('change', updatePricing);
                quantityInput.addEventListener('change', updatePricing);
            }

            // When form submits, ensure all calculated values are included
            document.querySelector('form').addEventListener('submit', function() {
                updatePricing(); // Ensure latest calculations are included
            });

            // Disable checkout date initially
            if (checkoutInput) {
                checkoutInput.disabled = true;

                // Update checkout min date when checkin changes
                checkinInput.addEventListener('change', function() {
                    const checkinDate = new Date(this.value);
                    const nextDay = new Date(checkinDate);
                    nextDay.setDate(checkinDate.getDate() + 1);

                    // Format the date to YYYY-MM-DD
                    const formattedDate = nextDay.toISOString().split('T')[0];

                    // Enable checkout and set minimum date
                    checkoutInput.disabled = false;
                    checkoutInput.min = formattedDate;
                    checkoutInput.value = formattedDate;

                    // Update pricing after setting new dates
                    updatePricing();
                });

                // Trigger the change event to initialize checkout date
                const event = new Event('change');
                checkinInput.dispatchEvent(event);
            }

            // Add this to your code where the other event listeners are defined
            if (numberOfPersonsInput) {
                numberOfPersonsInput.addEventListener('input', function() {
                    updateGuestList();
                    updatePricing(); // Make sure pricing updates when number of persons changes
                });

                // Also trigger an immediate update
                updateGuestList();
                updatePricing();
            }
        });
    </script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // All your existing code for guest list, pricing, etc.

        // Fix for checkout date initialization
        const checkinInput = document.getElementById('checkin');
        const checkoutInput = document.getElementById('checkout');

        if (checkinInput && checkoutInput) {
            // Function to update checkout date
            function updateCheckoutDate() {
                const checkinDate = new Date(checkinInput.value);
                if (isNaN(checkinDate.getTime())) {
                    return; // Invalid date, do nothing
                }

                const nextDay = new Date(checkinDate);
                nextDay.setDate(checkinDate.getDate() + 1);

                // Format the date to YYYY-MM-DD
                const year = nextDay.getFullYear();
                const month = String(nextDay.getMonth() + 1).padStart(2, '0');
                const day = String(nextDay.getDate()).padStart(2, '0');
                const formattedDate = `${year}-${month}-${day}`;

                // Enable checkout and set minimum date
                checkoutInput.disabled = false;
                checkoutInput.min = formattedDate;
                checkoutInput.value = formattedDate;
            }

            // Add event listener for check-in date changes
            checkinInput.addEventListener('change', updateCheckoutDate);

            // Initialize checkout date on page load
            // Using setTimeout to ensure this runs after everything else
            setTimeout(updateCheckoutDate, 100);
        }
    });
</script>
</x-layout>
