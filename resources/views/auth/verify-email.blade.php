<x-layout>
    <x-navbar />

<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="bg-white border border-gray-200 p-8 rounded-lg shadow-lg max-w-md w-full mx-4 sm:mx-auto text-center">

        <h1 class="mb-4 text-xl font-bold">Verify Your Email!</h1>

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

        <form method="POST" action="{{ route('send.otp') }}" class="space-y-4">
            @csrf
            <div class="text-left">
                <label for="email" class="block mb-2 font-medium text-gray-700">Email:</label>
                <input
                    type="email"
                    name="email"
                    required
                    value="{{ old('email') }}"
                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                />
                @error('email')
                    <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                @enderror
            </div>
            <button
                type="submit"
                class="w-full px-4 py-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm text-center"
            >
                Send OTP
            </button>
        </form>


    </div>
</div>
<x-footer />
</x-layout>

