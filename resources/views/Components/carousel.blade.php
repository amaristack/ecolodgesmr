<!-- Video Background Section -->
<div class="relative w-full h-screen">
    <video autoplay muted loop class="w-full h-full object-cover">
        <source src="{{ Vite::asset('resources/videos/sibugay.mp4') }}" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    <div
        class="absolute inset-0 bg-black bg-opacity-10 p-6 md:p-10 text-center w-full h-full flex flex-col items-center justify-center">
        <!-- Content Container -->
        <div
            class="flex flex-col md:flex-row md:items-center md:justify-center w-full max-w-6xl mx-auto space-y-8 md:space-y-0 md:space-x-12">
            <!-- Text Content -->
            <div class="flex-1 text-center md:text-left">
                <h1 class="text-4xl font-bold text-white mb-4">Welcome to Ecolodge Mountain Resort</h1>
                <p class="text-lg text-gray-200 mb-6">Experience luxury, comfort, and beauty like never before.</p>
                <a href="{{ route('user.book') }}"
                   class="bg-yellow-500 hover:bg-yellow-600 text-white py-3 px-6 rounded-full font-semibold">Book Your
                    Stay</a>
            </div>

            <!-- Booking Form -->
            <div class="flex-1 bg-white bg-opacity-70 backdrop-blur-md p-6 rounded-lg shadow-xl max-w-md w-full">
                <form id="booking-form" class="space-y-4" action="{{ route('checkAvailability') }}" method="POST">
                    @csrf <!-- CSRF Token -->

                    <!-- Check-In Date -->
                    <div>
                        <label for="checkin" class="block text-sm font-medium text-gray-700">Check In</label>
                        <div class="relative max-w-sm">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                     xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                </svg>
                            </div>
                            <input datepicker id="checkin" name="checkin" type="text" placeholder="Select date"
                                   class="bg-white bg-opacity-80 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   required>
                        </div>
                    </div>

                    <!-- Check-Out Date -->
                    <div>
                        <label for="checkout" class="block text-sm font-medium text-gray-700">Check Out</label>
                        <div class="relative max-w-sm">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                     xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                </svg>
                            </div>
                            <input datepicker id="checkout" name="checkout" type="text" placeholder="Select date"
                                   class="bg-white bg-opacity-80 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   required>
                        </div>
                    </div>

                    <!-- Category -->
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                        <select id="category" name="category"
                                class="mt-1 block w-full p-2 border border-gray-300 bg-white bg-opacity-80 rounded-lg shadow-sm focus:ring-yellow-500 focus:border-yellow-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                required>
                            <option value="">Select Category</option>
                            <option value="rooms">Rooms</option>
                            <option value="activity">Activity</option>
                            <option value="cottages">Cottages</option>
                            <option value="function_hall">Function Hall</option>
                        </select>
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit"
                           class="w-full bg-yellow-500 hover:bg-yellow-600 text-white py-2 px-4 rounded-full font-semibold">
                            Check Availability
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

