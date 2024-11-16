<x-layout>
    <x-navbar />

    <div class="relative bg-gradient-to-br from-blue-500 to-green-400 bg-cover bg-center h-[300px] flex items-center justify-center"
         style="background-image: url('https://vnfoxcdnoahqenfjssdv.supabase.co/storage/v1/object/public/ecolodgesmr/images/main.jpg');">
        <div class="absolute inset-0 bg-black opacity-30"></div>
        <div class="container mx-auto relative z-10 text-center text-white">
            <h1 class="text-5xl font-bold mb-4">Welcome to Ecolodge Resort </h1>
            <nav class="text-lg mb-6">
                <a href="/dashboard" class="hover:underline">Home</a> / <a href="/login" class="underline text-yellow-500">Login</a>
            </nav>
        </div>
    </div>

    <div class="container mx-auto max-w-lg p-8 bg-white rounded-lg shadow-lg mt-16 mb-16">
        @if (session('success'))
            <div class="p-4 mb-4 text-sm text-green-800 bg-green-50 border border-green-300 rounded-lg" role="alert">
                <svg class="w-4 h-4 inline me-3" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Z M9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z M12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                <span class="font-medium">Success!</span> {{ session('success') }}
            </div>
        @endif

        <h2 class="text-3xl font-semibold mb-8 text-center text-gray-800">Login to Your Account</h2>
        <form action="/login" method="post">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium mb-2">Email Address</label>
                <input type="email" id="email" name="email"
                       class="w-full px-6 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="you@example.com" value="{{ old('email') }}">
            </div>
            <x-fields_error name="email"/>
            <div class="mb-6">
                <label for="password" class="block text-sm font-medium mb-2">Password</label>
                <input type="password" id="password" name="password"
                       class="w-full px-6 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="••••••••">
            </div>
            <x-fields_error name="password"/>
            <div class="mb-6 flex items-center justify-between">
                <label class="inline-flex items-center">
                    <input type="checkbox" class="form-checkbox text-blue-600" name="remember">
                    <span class="ml-2 text-sm">Remember me</span>
                </label>
                <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:underline">Forgot password?</a>
            </div>
            <div class="flex space-x-4">
                <button type="submit"
                        class="w-1/2 bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition-all font-bold">
                    Login
                </button>
                <a href="/register"
                   class="w-1/2 bg-green-500 text-white py-3 rounded-lg hover:bg-green-600 transition-all text-center flex items-center justify-center">
                    Signup
                </a>
            </div>
        </form>
    </div>

    <x-newsletter />
    <x-footer />
</x-layout>
