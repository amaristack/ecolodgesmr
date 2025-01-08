<!-- resources/views/auth/verify-otp.blade.php -->
<x-layout>
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="bg-white border border-gray-200 p-8 rounded-lg shadow-lg max-w-md w-full mx-4 sm:mx-auto text-center">
            <x-navbar />

            <h1 class="mb-4 text-xl font-bold">Verify Your OTP</h1>

            @if(session('success'))
                <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('verify.otp.post') }}" class="space-y-4">
                @csrf
                <div class="text-left">
                    <label for="otp" class="block mb-2 font-medium text-gray-700">OTP:</label>
                    <input
                        type="text"
                        name="otp"
                        required
                        maxlength="6"
                        autofocus
                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    />
                    @error('otp')
                        <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                    @enderror
                </div>
                <button
                    type="submit"
                    class="w-full px-4 py-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm text-center"
                >
                    Verify OTP
                </button>
            </form>

            <form method="POST" action="{{ route('send.otp') }}" class="mt-4">
                @csrf
                <!-- Pass the email from session -->
                <input type="hidden" name="email" value="{{ session('verified_email') }}">
                <button
                    type="submit"
                    class="w-full px-4 py-2 text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm text-center"
                >
                    Resend OTP
                </button>
            </form>

            <x-footer />
        </div>
    </div>
</x-layout>
