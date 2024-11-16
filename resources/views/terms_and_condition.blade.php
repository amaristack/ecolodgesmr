<x-layout>
    <x-navbar/>
    <div class="relative bg-cover bg-center h-[300px] flex items-center justify-center"
         style="background-image: url('https://vnfoxcdnoahqenfjssdv.supabase.co/storage/v1/object/public/ecolodgesmr/images/main.jpg');">
        <div class="absolute inset-0 bg-blue-500 opacity-50"></div>
        <div class="container mx-auto relative z-10 flex items-center justify-center">
            <div class="text-center text-white">
                <h1 class="text-5xl font-bold mb-6">Terms and Condition</h1>
                <nav class="text-white text-lg font-bold mb-8">
                    <a href="/dashboard" class="hover:underline">Home</a> / <a href="/terms" class="underline">Terms and
                        Condition</a>
                </nav>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto my-8 p-6 bg-white">
        <!-- Heading -->
        <h1 class="text-2xl font-bold mb-4">Terms and Conditions</h1>

        <!-- Section 1 -->
        <h2 class="text-xl font-semibold mt-6 mb-2">1. Introduction</h2>
        <p class="text-gray-700 mb-4">
            These Terms and Conditions govern the use of our website and services. By accessing or using our platform,
            you agree to abide by the terms set forth here.
        </p>

        <!-- Section 2 -->
        <h2 class="text-xl font-semibold mt-6 mb-2">2. User Responsibilities</h2>
        <p class="text-gray-700 mb-4">
            Users must provide accurate information and refrain from misusing our services. Failure to comply may result
            in account suspension or termination.
        </p>

        <!-- Section 3 -->
        <h2 class="text-xl font-semibold mt-6 mb-2">3. Prohibited Activities</h2>
        <ul class="list-disc list-inside mb-4 text-gray-700">
            <li>Posting unlawful content</li>
            <li>Attempting to compromise the website’s security</li>
            <li>Engaging in fraudulent activities</li>
        </ul>

        <!-- Section 4 -->
        <h2 class="text-xl font-semibold mt-6 mb-2">4. Intellectual Property</h2>
        <p class="text-gray-700 mb-4">
            All content on this website, including text, images, and other media, is protected by intellectual property
            laws. You may not reproduce, distribute, or create derivative works without permission.
        </p>

        <!-- Section 5 -->
        <h2 class="text-xl font-semibold mt-6 mb-2">5. Limitation of Liability</h2>
        <p class="text-gray-700 mb-4">
            We are not liable for any damages arising from the use of our services. Your use of the site is at your own
            risk.
        </p>

        <!-- Section 6 -->
        <h2 class="text-xl font-semibold mt-6 mb-2">6. Changes to Terms</h2>
        <p class="text-gray-700 mb-4">
            We reserve the right to modify these terms at any time. It is your responsibility to stay updated with any
            changes.
        </p>

    </div>

    <x-newsletter/>
    <x-footer/>
</x-layout>
