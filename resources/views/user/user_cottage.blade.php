<x-layout>
    <x-navbar/>
    <div class="relative bg-cover bg-center h-[350px] flex items-center justify-center"
         style="background-image: url('https://vnfoxcdnoahqenfjssdv.supabase.co/storage/v1/object/public/ecolodgesmr/images/main.jpg');">
        <div class="absolute inset-0 bg-gradient-to-b from-black/60 to-transparent"></div>
        <div class="container mx-auto relative z-10 text-center text-white">
            <h1 class="text-5xl font-extrabold mb-4">Choose your Cottage</h1>
            <nav class="text-white text-lg font-medium">
                <a href="/dashboard" class="hover:text-yellow-400">Home</a> /
                <a href="/pool" class="text-yellow-400">Cottages</a>
            </nav>
        </div>
    </div>

    <section class="container mx-auto px-4 py-12">
        <!-- Section Title -->
        <div class="text-center mb-8">
            <h2 class="text-lg text-yellow-500 font-semibold">Choose Your Cottages</h2>
            <h1 class="text-4xl font-bold text-gray-800 mb-4">Featured Beautiful and Affordable Cottages</h1>
            <p class="text-gray-600 max-w-2xl mx-auto">Discover the perfect spot to relax and unwind with our selection of beautiful and budget-friendly cottages.</p>
        </div>
        <!-- Cottage Cards Section -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @php
                // Array of dynamic highlights and descriptions
                $highlights = ['Best for Families', 'Beachside Comfort', 'Budget-Friendly', 'Hidden Gem', 'Exclusive Retreat', 'Nature Escape', 'Luxurious Stay', 'Cozy Ambiance'];
                $descriptions = [
                    'Enjoy a spacious cottage ideal for families, complete with breathtaking views and cozy amenities.',
                    'Relax in this charming beachside cottage that offers comfort and stunning sea views.',
                    'A perfect choice for those looking for quality and affordability, without compromise.',
                    'Discover this unique, secluded cottage, perfect for a peaceful getaway.',
                    'Experience luxury and exclusivity in this private retreat.',
                    'Immerse yourself in nature with this tranquil escape surrounded by greenery.',
                    'Indulge in a luxurious stay with premium amenities and a refined atmosphere.',
                    'Feel at home in this cozy, welcoming cottage perfect for relaxation.'
                ];
            @endphp

            @foreach($pool as $index => $pools)
                @php
                    // Assign highlight and description based on the index dynamically
                    $highlight = $highlights[$index % count($highlights)];
                    $description = $descriptions[$index % count($descriptions)];
                @endphp

                <div class="bg-white rounded-lg shadow-md overflow-hidden group hover:shadow-lg transition transform hover:-translate-y-1">
                    <div class="relative">
                        <img src="{{ Vite::asset('resources/images/' . strtolower($pools->cottage_name) . '.jpg') }}" alt="{{ $pools->cottage_type }}" class="w-full h-64 object-cover transition duration-300 ease-in-out group-hover:scale-105">
                        <div class="absolute top-0 left-0 bg-indigo-500 text-white font-bold py-1 px-3 rounded-br-lg">{{ $highlight }}</div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-2xl font-bold mb-2 text-gray-800">{{ $pools->cottage_type }}</h3>
                        <p class="text-gray-700 mb-3">{{ $description }}</p>
                        <p class="text-green-600 font-bold text-xl mb-1">PHP {{ number_format($pools->price, 2) }} Rent</p>
                        <div class="flex justify-between items-center mb-4">
                            <a href="/cottages/{{ $pools->pool_id }}" class="bg-yellow-500 text-white font-bold py-2 px-4 rounded-md transition hover:bg-yellow-600">Details</a>
                            <span class="text-yellow-500 text-sm font-semibold">{{ $highlight }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>


    <x-footer />
</x-layout>
