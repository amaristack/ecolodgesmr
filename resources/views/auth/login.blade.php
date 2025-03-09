<x-layout>
    <x-navbar />

    <div class="relative bg-gradient-to-br from-blue-500 to-green-400 bg-cover bg-center h-[300px] flex items-center justify-center"
         style="background-image: url('https://vnfoxcdnoahqenfjssdv.supabase.co/storage/v1/object/public/ecolodgesmr/images/main.jpg');">
        <div class="absolute inset-0 bg-black opacity-30"></div>
        <div class="container mx-auto relative z-10 text-center text-white">
            <h1 class="text-5xl font-bold mb-4">Welcome to Ecolodge Resort</h1>
            <nav class="text-lg mb-6">
                <a href="/dashboard" class="hover:underline">Home</a> /
                <a href="/login" class="underline text-yellow-500">Login</a>
            </nav>
        </div>
    </div>

    <div class="container mx-auto max-w-lg p-8 bg-white rounded-lg shadow-lg mt-16 mb-16">
        <h2 class="text-3xl font-semibold mb-8 text-center text-gray-800">Login to Your Account</h2>
        <form action="/login" method="post">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium mb-2">Email Address</label>
                <input type="email" id="email" name="email"
                       class="w-full px-6 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="you@example.com">
            </div>

            <div class="mb-6">
                <label for="password" class="block text-sm font-medium mb-2">Password</label>
                <input type="password" id="password" name="password"
                       class="w-full px-6 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="••••••••">
            </div>

            <div class="mb-6 flex items-center justify-between">
                <label class="inline-flex items-center">
                    <input type="checkbox" class="form-checkbox text-blue-600" name="remember">
                    <span class="ml-2 text-sm">Remember me</span>
                </label>
                <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:underline">Forgot password?</a>
            </div>

            <div class="mb-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" id="termsCheckbox" class="form-checkbox text-blue-600">
                    <span class="ml-2 text-sm">I agree to the <a href="#" id="showTerms" class="text-blue-600 hover:underline">Terms and Conditions</a></span>
                </label>
            </div>

            <div class="flex space-x-4">
                <button type="submit" id="loginButton" disabled
                        class="w-1/2 bg-blue-600 text-white py-3 rounded-lg transition-all font-bold disabled:opacity-50 disabled:cursor-not-allowed">
                    Login
                </button>
                <a href="{{ route('verify.email') }}"
                   class="w-1/2 bg-green-500 text-white py-3 rounded-lg hover:bg-green-600 transition-all text-center flex items-center justify-center">
                    Signup
                </a>
            </div>
        </form>
    </div>

    <x-footer />

    {{-- Include SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Get DOM elements
        const termsCheckbox = document.getElementById('termsCheckbox');
        const loginButton = document.getElementById('loginButton');

        // Enable/disable login button based on checkbox
        termsCheckbox.addEventListener('change', function() {
            loginButton.disabled = !this.checked;
        });

        document.getElementById('showTerms').addEventListener('click', function(event) {
            event.preventDefault();

            Swal.fire({
                title: "Terms and Conditions",
                width: "600px",
                html: `
                    <div style="text-align: left; max-height: 400px; overflow-y: auto; padding: 10px;">
                        <p class="mb-4">Please read these terms carefully before using our services:</p>

                        <h3 class="font-bold mb-2">1. Account Security</h3>
                        <ul class="list-disc pl-5 mb-4">
                            <li>You are responsible for maintaining your account security</li>
                            <li>Do not share your login credentials</li>
                            <li>Report any unauthorized access immediately</li>
                        </ul>

                        <h3 class="font-bold mb-2">2. Booking and Cancellation</h3>
                        <ul class="list-disc pl-5 mb-4">
                            <li>All bookings are subject to availability</li>
                            <li>Cancellation policies apply as per booking terms</li>
                            <li>Payment terms must be followed as specified</li>
                        </ul>

                        <h3 class="font-bold mb-2">3. Privacy and Data</h3>
                        <ul class="list-disc pl-5 mb-4">
                            <li>Your personal information will be protected</li>
                            <li>We follow strict data protection guidelines</li>
                            <li>Your data will only be used for booking purposes</li>
                        </ul>

                        <h3 class="font-bold mb-2">4. User Conduct</h3>
                        <ul class="list-disc pl-5">
                            <li>Respect our facilities and staff</li>
                            <li>Follow all resort rules and guidelines</li>
                            <li>Maintain appropriate behavior during your stay</li>
                        </ul>
                    </div>
                `,
                confirmButtonText: "I Understand",
                confirmButtonColor: "#3085d6",
            });
        });
    </script>
</x-layout>
