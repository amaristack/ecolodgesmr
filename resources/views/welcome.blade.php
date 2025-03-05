<x-layout>
    <x-navbar />
    <section class="h-full relative">
        <x-carousel />
    </section>



    <section class="container mx-auto px-4 py-8" data-aos="fade-up">
        <div class="w-full mx-auto p-8" data-aos="fade-up">
            <h1 class="text-3xl font-bold text-black text-center mb-8" data-aos="fade-up">About Us</h1>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Images Section -->
                <div class="space-y-4" data-aos="fade-up">
                    <div class="h-80" data-aos="zoom-in">
                        <img src="https://vnfoxcdnoahqenfjssdv.supabase.co/storage/v1/object/public/ecolodgesmr/images/main.jpg"
                            alt="Main Image" class="w-full h-full object-cover rounded-lg shadow-lg">
                    </div>
                    <div class="grid grid-cols-2 gap-4" data-aos="zoom-in">
                        <img src="https://vnfoxcdnoahqenfjssdv.supabase.co/storage/v1/object/public/ecolodgesmr/images/main image.jpg"
                            alt="Image 1" class="w-full h-full object-cover rounded-lg shadow-md">
                        <img src="https://vnfoxcdnoahqenfjssdv.supabase.co/storage/v1/object/public/ecolodgesmr/images/main pool.jpg"
                            alt="Image 2" class="w-full h-full object-cover rounded-lg shadow-md">
                    </div>
                </div>
                <div class="flex flex-col justify-center" data-aos="fade-up">
                    <h2 class="text-4xl font-bold mb-4 text-gray-800">Welcome to Ecolodge - Sibugay Mountain Resort</h2>
                    <p class="mb-6 text-gray-600">
                        Nestled in the heart of nature, Ecolodge - Sibugay Mountain Resort offers a serene escape from
                        the hustle and bustle of everyday life. Our resort is designed to provide you with the ultimate
                        relaxation experience, surrounded by lush greenery and breathtaking views. Whether you're
                        looking to unwind by our pristine pool, indulge in gourmet dining, or embark on an adventurous
                        canyoning expedition, we have something for everyone. Our canyoning tours take you through
                        stunning canyons, where you can experience the thrill of rappelling down waterfalls and
                        exploring hidden natural wonders. Join us for an unforgettable stay where luxury meets
                        adventure.
                    </p>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6" data-aos="fade-up">
                        <div class="flex flex-col items-center p-4 bg-white rounded-lg shadow-md" data-aos="zoom-in">
                            <svg class="w-10 h-10 text-yellow-400 mb-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 1.104-.896 2-2 2h-1v-1.586A1.986 1.986 0 0016 10h-1c-1.104 0-2 .896-2 2v1H8v-1c0-1.104-.896-2-2-2H5c-1.104 0-2 .896-2 2v1H2c-1.104 0-2 .896-2 2v7h22v-7c0-1.104-.896-2-2-2z">
                                </path>
                            </svg>
                            <p class="text-2xl font-bold">3</p>
                            <p class="text-gray-600">Rooms</p>
                        </div>
                        <div class="flex flex-col items-center p-4 bg-white rounded-lg shadow-md" data-aos="zoom-in">
                            <svg class="w-10 h-10 text-yellow-400 mb-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 10h4v4H3v-4zM9 10h4v4H9v-4zM15 10h4v4h-4v-4zM21 10h4v4h-4v-4z"></path>
                            </svg>
                            <p class="text-2xl font-bold">1200+</p>
                            <p class="text-gray-600">Customers</p>
                        </div>
                        <div class="flex flex-col items-center p-4 bg-white rounded-lg shadow-md" data-aos="zoom-in">
                            <svg class="w-10 h-10 text-yellow-400 mb-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 21l6-6 3 3 9-9"></path>
                            </svg>
                            <p class="text-2xl font-bold">10</p>
                            <p class="text-gray-600">Amenities</p>
                        </div>
                        <div class="flex flex-col items-center p-4 bg-white rounded-lg shadow-md" data-aos="zoom-in">
                            <svg class="w-10 h-10 text-yellow-400 mb-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3"></path>
                            </svg>
                            <p class="text-2xl font-bold">4</p>
                            <p class="text-gray-600">Activities</p>
                        </div>
                    </div>
                    @guest
                        <a href="/aboutus"
                            class="bg-yellow-400 hover:bg-yellow-500 text-white font-bold py-3 px-6 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-300 transition text-center"
                            data-aos="fade-up">
                            More About Us
                        </a>

                    @endguest
                </div>
            </div>
        </div>
    </section>


    <section class="container mx-auto px-4 py-12" data-aos="fade-up">
        <!-- Section Title -->
        <div class="text-center mb-8">
            <h2 class="text-lg text-yellow-500 font-semibold">Choose Your Activities</h2>
            <h1 class="text-4xl font-bold text-gray-800 mb-4">Featured Outdoor Activity</h1>
            <p class="text-gray-600 max-w-2xl mx-auto">Explore our wide range of activities that promise
                unforgettable experiences.</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach ($activities as $act)
                <div class="bg-white rounded-lg shadow-md overflow-hidden group" data-aos="flip-left">
                    <div class="relative">
                        <img src="{{ 'https://vnfoxcdnoahqenfjssdv.supabase.co/storage/v1/object/public/ecolodgesmr/images/' . $act->activity_name . '.jpg' }}"
                            alt="{{ $act->activity_name }}"
                            class="w-full h-64 object-cover transition duration-300 ease-in-out group-hover:scale-105">
                    </div>
                    <div class="p-6">
                        <h3 class="text-2xl font-bold mb-2 text-gray-800">{{ $act->activity_name }}</h3>
                        <p class="text-green-600 font-bold text-xl mb-1">PHP{{ $act->rate }} / Person</p>
                        <div class="flex justify-between items-center mb-4">
                            <a href="/activities/{{ $act->activity_id }}"
                                class="bg-yellow-500 text-white font-bold py-2 px-4 rounded-md transition hover:bg-yellow-600">Details</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Rooms Section -->
    <section class="container mx-auto px-4 py-12" data-aos="fade-up">
        <!-- Section Title -->
        <div class="text-center mb-8" data-aos="fade-up">
            <h2 class="text-lg text-yellow-500 font-semibold">Choose Your Rooms</h2>
            <h1 class="text-4xl font-bold text-gray-800 mb-4">Featured Rooms</h1>
            <p class="text-gray-600 max-w-2xl mx-auto">Experience luxury and comfort. Select from our carefully curated
                rooms that cater to your needs.</p>
        </div>
        <!-- Room Cards Section -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
            @foreach ($rooms as $room)
                <div class="bg-white rounded-lg shadow-md overflow-hidden group" data-aos="zoom-in-up">
                    <div class="relative">
                        <img src="{{ 'https://vnfoxcdnoahqenfjssdv.supabase.co/storage/v1/object/public/ecolodgesmr/images/' . $room->room_type . '.jpg' }}"
                            alt="{{ $room->room_type }}"
                            class="w-full h-64 object-cover transition duration-300 ease-in-out group-hover:scale-105">
                    </div>
                    <div class="p-6">
                        <h3 class="text-2xl font-bold mb-2 text-gray-800">{{ $room->room_type }}</h3>
                        <p class="text-green-600 font-bold text-xl mb-1">PHP{{ $room->rate }} / Night</p>
                        <div class="flex justify-between items-center mb-4">
                            <a href="/rooms/{{ $room->room_id }}"
                                class="bg-yellow-500 text-white font-bold py-2 px-4 rounded-md transition hover:bg-yellow-600">Details</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Download Our App Section -->
    <section class="py-16 bg-white container mx-auto px-4" data-aos="fade-up">
        <div class="flex flex-col lg:flex-row items-center gap-8 lg:gap-16 w-full max-w-6xl mx-auto">
            <!-- Phone Image -->
            <div class="flex-1 w-full flex justify-center lg:justify-end" data-aos="zoom-in">
                <div class="relative w-60 h-auto md:w-72 lg:w-80 aspect-[2/3]">
                    <img src="https://vnfoxcdnoahqenfjssdv.supabase.co/storage/v1/object/public/ecolodgesmr/images/phone.png"
                        alt="Phone Mockup" class="w-full h-full object-contain">
                </div>
            </div>

            <!-- Download App Content -->
            <div class="flex-1 text-center lg:text-left space-y-6" data-aos="fade-up">
                <h2 class="text-4xl font-bold text-gray-900">Download Our New App</h2>
                <p class="text-lg text-gray-600">
                    Experience a better way of booking and accessing resort amenities at Sibugay Mountain Resort.
                    Download our app and enjoy a user-friendly interface, exclusive offers, and seamless access.
                </p>
                <!-- QR Code Only -->
                <div class="flex justify-center mt-6">
                    <div class="bg-gray-200 p-4 rounded-lg shadow-md" data-aos="zoom-in">
                        <img src="https://vnfoxcdnoahqenfjssdv.supabase.co/storage/v1/object/public/ecolodgesmr/images/frame.png?t=2025-01-09T14%3A56%3A43.805Z"
                            alt="QR Code" class="w-32 h-32 object-contain">
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Reach Us Section -->
    <section class="py-10 px-4 md:px-6 lg:px-10 bg-gray-100">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-4xl font-bold text-center mb-10">Reach Us</h2>
            <div class="flex flex-col lg:flex-row gap-10">
                <!-- Contact Information -->
                <div class="flex-1 bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-2xl font-semibold mb-4">Contact Information</h3>
                    <ul class="space-y-4 text-lg">
                        <li class="flex items-center">
                            <svg class="w-6 h-6 text-blue-600 mr-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 10h1m0 0V7a4 4 0 014-4h8a4 4 0 014 4v3m-1 10h1m-5-2h1a4 4 0 004-4v-5a4 4 0 00-4-4H8a4 4 0 00-4 4v5a4 4 0 004 4h1m-5 2h1" />
                            </svg>
                            <span>Phone: 0915 502 2154</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-6 h-6 text-blue-600 mr-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 2v5m0 0v4m0-4H8m8 0H9m-3 5v2a4 4 0 004 4h4a4 4 0 004-4v-2m-8 4v-1a4 4 0 014-4h2a4 4 0 014 4v1m-8-6V9m0 5v-1m0-4v-2" />
                            </svg>
                            <span>Email: sibugaymountainresort@gmail.com</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-6 h-6 text-blue-600 mr-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 21h8M12 21V3m0 18c1.333-1.333 4-4 4-7a4 4 0 10-8 0c0 3 2.667 5.667 4 7z" />
                            </svg>
                            <span>Address: Purok 1, Albuera, Leyte Province, Philippines</span>
                        </li>
                    </ul>
                </div>

                <!-- Map Section -->
                <div class="flex-1 bg-white p-6 rounded-lg shadow-md h-[400px] overflow-hidden">
                    <h3 class="text-1xl font-semibold mb-4">Location Map</h3>
                    <iframe class="w-full h-full rounded-lg"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3916.869230975715!2d124.7040719151956!3d10.927800692716762!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3309a72342f8d4a1%3A0x84e7e9ebc9c25a13!2sSibugay%20Mountain%20Resort%2C%20Albuera%2C%20Leyte%2C%20Philippines!5e0!3m2!1sen!2sph!4v1697310000000!5m2!1sen!2sph"
                        frameborder="0" style="border:0;" allowfullscreen="" loading="lazy">
                    </iframe>
                </div>

            </div>
        </div>
    </section>



    <x-footer />

</x-layout>
