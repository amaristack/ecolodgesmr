<x-layout>
    <x-navbar/>

    <div class="relative bg-cover bg-center h-[350px] flex items-center justify-center"
         style="background-image: url('{{ \Illuminate\Support\Facades\Vite::asset('resources/images/main.jpg') }}');">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-700 to-teal-500 opacity-70"></div>
        <div class="container mx-auto relative z-10 text-center text-white">
            <h1 class="text-5xl font-extrabold mb-6 text-shadow-lg">About Us</h1>
            <nav class="text-white text-lg font-semibold mb-8">
                <a href="/dashboard" class="hover:underline">Home</a> / <a href="/aboutus" class="underline">About Us</a>
            </nav>
        </div>
    </div>

    <div class="w-full max-w-[1140px] mx-auto my-12 p-6 sm:p-8 lg:p-12 bg-white rounded-lg shadow-xl">
        <!-- Heading -->
        <h1 class="text-3xl font-semibold mb-8 text-center text-gray-800">Discover the Heart of Nature at Sibugay Mountain Resort</h1>

        <!-- Section 1: What is an About Us Page -->
        <div class="bg-gray-50 p-6 rounded-xl shadow-md mb-8">
            <h2 class="text-2xl font-semibold mb-4">What is an About Us Page?</h2>
            <p class="text-lg text-gray-700 leading-relaxed">
                Welcome to Sibugay Mountain Resort, a place where tranquility and adventure meet. Nestled in the heart of Albuera’s lush hills, our resort offers a peaceful sanctuary for all who seek to escape the hustle and bustle of daily life. Whether you're here to relax, explore, or create lasting memories, we offer a variety of accommodations and activities to suit every guest's needs.
            </p>
            <p class="text-lg text-gray-700 leading-relaxed mt-4">
                Getting to the Resort is a scenic journey, just 3 kilometers from the main highway, through serene landscapes. For those without vehicles, we offer comfortable "habal-habal" (motorcycle taxi) services, ensuring easy access to our peaceful oasis.
            </p>
        </div>

        <!-- Section 2: History of Sibugay Mountain Resort -->
        <div class="bg-gray-50 p-6 rounded-xl shadow-md">
            <h2 class="text-2xl font-semibold mb-4">Our History</h2>
            <p class="text-lg text-gray-700 leading-relaxed">
                Founded in 2011 under the leadership of Mayor Erlinda E. Dela Victoria, Sibugay Mountain Resort was designed to promote eco-tourism in the region. The resort quickly became a favorite for both locals and visitors, thanks to its breathtaking landscapes and eco-friendly atmosphere.
            </p>
            <p class="text-lg text-gray-700 leading-relaxed mt-4">
                Since its inception, our resort has been committed to sustainability and environmental preservation, ensuring that future generations can experience the beauty of Albuera’s natural wonders. Our goal is to offer guests an immersive experience that blends adventure with serenity, offering various accommodations, activities, and dining options.
            </p>
            <p class="text-lg text-gray-700 leading-relaxed mt-4">
                From its humble beginnings, Sibugay Mountain Resort has expanded its offerings to include a variety of recreational activities such as hiking, swimming, and local tours, making it a perfect destination for both relaxation and adventure.
            </p>
            <p class="text-lg text-gray-700 leading-relaxed mt-4">
                Nearby attractions such as Magtalisik Falls and Languyon Falls have also made our resort a prime spot for those seeking outdoor adventure, providing the perfect blend of excitement and relaxation.
            </p>
            <p class="text-lg text-gray-700 leading-relaxed mt-4">
                Today, Sibugay Mountain Resort remains a tranquil escape, where visitors can unwind, appreciate nature, and create memories that last a lifetime.
            </p>
        </div>
    </div>

    <x-newsletter class="bg-gradient-to-r from-teal-500 to-blue-600 text-white py-10"/>
    <x-footer/>
</x-layout>
