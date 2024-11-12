<div class="relative w-full flex items-center justify-center" style="min-height: 60vh;">

    <!-- Background Image -->
    <img src="{{ asset('images/pool.jpg') }}" alt="Background Image"
         class="absolute inset-0 w-full h-full object-cover">

    <!-- Overlay to darken background for readability -->
    <div class="absolute inset-0 bg-black opacity-40"></div>

    @if(session()->has('success'))
        <!-- Success Message Container -->
        <div class="relative bg-green-500 text-white rounded-lg shadow-lg p-6 md:p-10 lg:p-12 w-11/12 sm:w-4/5 md:w-2/3 lg:w-1/2 xl:w-1/3 max-w-[500px] text-center z-10">
            <h2 class="text-xl md:text-2xl lg:text-3xl font-bold mb-4">Thank You for Subscribing!</h2>
            <p class="text-base md:text-lg lg:text-xl">You have successfully subscribed to our newsletter. Stay tuned for updates and special offers!</p>
        </div>

        {{ session()->forget('success') }}
    @else
        <!-- Newsletter Form Container -->
        <div class="relative bg-white rounded-lg shadow-lg p-6 md:p-10 lg:p-12 w-11/12 sm:w-4/5 md:w-2/3 lg:w-1/2 xl:w-1/3 max-w-[500px] text-center z-10">
            <h2 class="text-xl md:text-2xl lg:text-3xl font-bold mb-4">Subscribe to Our Newsletter</h2>
            <p class="mb-6 text-sm md:text-base lg:text-lg text-gray-600">Subscribe to the mailing list to receive updates on special offers, new arrivals, and our promotions.</p>

            <form action="{{ route('subscribe') }}" method="post">
                @csrf
                <div class="flex flex-col sm:flex-row items-center">
                    <input type="email" id="email" name="email"
                           class="w-full sm:w-2/3 border-2 border-yellow-400 p-3 sm:p-4 text-sm md:text-base rounded-md mb-4 sm:mb-0 sm:mr-4 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                           placeholder="Enter your email address" required>
                    <button type="submit"
                            class="w-full sm:w-auto bg-yellow-400 text-white font-bold py-3 px-6 sm:px-8 text-sm md:text-base rounded-md transition hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-200">Subscribe</button>
                </div>
            </form>
        </div>
    @endif
</div>
