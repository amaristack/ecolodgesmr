<x-layout>
    <x-navbar />

    <main class="max-w-[1140px] mx-auto p-4">
        <!-- Back Button -->
        <a href="{{ url()->previous() }}"
           class="inline-flex items-center bg-yellow-600 text-white hover:bg-yellow-700 focus:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 rounded-md px-3 py-1.5 mb-6 transition"
           aria-label="Go back to the previous page">
            <i class="fas fa-arrow-left mr-2" aria-hidden="true"></i> Back
        </a>



        <!-- Promotional Offers Section -->
        <div class="space-y-6 mt-6">
            <!-- Offer Card 1 -->
            <div class="bg-yellow-100 p-6 rounded-md shadow-md">
                <h2 class="text-2xl font-bold mb-3">SECRET SALE - HALLOWEEN SPACATION</h2>
                <p class="text-sm">Buy 1 Night Spacation, Get 1 Extension Night Free!</p>
                <p class="text-xl font-semibold mt-4">From PHP 10,000.00</p>
                <button class="mt-6 bg-blue-600 text-white py-2 px-5 rounded-md hover:bg-blue-700 transition">
                    Show 1 Available
                </button>
            </div>

            <!-- Offer Card 2 -->
            <div class="bg-yellow-100 p-6 rounded-md shadow-md">
                <h2 class="text-2xl font-bold mb-3">Halloween Long Weekend (Spook & Sweet)</h2>
                <p class="text-sm">A Thrilling Halloween Long Weekend Experience.</p>
                <p class="text-xl font-semibold mt-4">From PHP 7,150.00</p>
                <button class="mt-6 bg-blue-600 text-white py-2 px-5 rounded-md hover:bg-blue-700 transition">
                    Show 2 Available
                </button>
            </div>

            <!-- Room Details Card -->
            <div class="bg-white p-6 rounded-md shadow-md">
                <h3 class="text-xl font-bold">Classic Studio</h3>
                <p class="text-sm mt-3">
                    Sleeps 2 • 1 King Bed • 1 Bathroom • 30m² • Non-smoking • Cable/Satellite TV •
                    Wireless Internet • Tea/Coffee Maker • Air-conditioning
                </p>
                <button class="mt-6 bg-blue-600 text-white py-2 px-5 rounded-md hover:bg-blue-700 transition">
                    More Info
                </button>
            </div>
        </div>
    </main>

    <x-footer />
</x-layout>
