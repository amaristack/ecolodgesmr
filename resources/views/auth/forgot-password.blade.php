<x-layout>
    <x-navbar/>

    <div class="relative bg-cover bg-center h-[300px] flex items-center justify-center"
         style="background-image: url('https://vnfoxcdnoahqenfjssdv.supabase.co/storage/v1/object/public/ecolodgesmr/images/main.jpg');">
        <div class="absolute inset-0 bg-blue-500 opacity-50"></div>
        <div class="container mx-auto relative z-10 flex items-center justify-center">
            <div class="text-center text-white">
                <h1 class="text-5xl font-bold mb-6">Welcome to Sibugay</h1>
                <nav class="text-white text-lg font-bold mb-8">
                    <a href="/dashboard" class="hover:underline">Home</a> / <a href="/login" class="underline">Forgot Password</a>
                </nav>
            </div>
        </div>
    </div>

    <div class="w-full md:w-1/2 p-8 md:p-16 mx-auto">
        <!-- Success Alert -->
        <!-- Alert -->
        @if (session('status'))
            <div class="flex items-center p-4 mb-4 text-sm rounded-lg
        {{ session('status') === 'success' ? 'text-green-700 bg-green-100 dark:bg-green-200 dark:text-green-800' : (session('status') === 'info' ? 'text-blue-700 bg-blue-100 dark:bg-blue-200 dark:text-blue-800' : 'text-red-700 bg-red-100 dark:bg-red-200 dark:text-red-800') }}"
                 role="alert">
                <svg class="flex-shrink-0 inline w-5 h-5 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M18 8a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-7.293-.293-3-3a1 1 0 0 1 1.414-1.414l2.293 2.293 5.293-5.293a1 1 0 0 1 1.414 1.414l-6 6a1 1 0 0 1-1.414 0Z"/>
                </svg>
                <span class="sr-only">{{ session('status') === 'success' ? 'Success' : (session('status') === 'info' ? 'Info' : 'Error') }}</span>
                <div>
                    <span class="font-medium">{{ session('status') === 'success' ? 'Success!' : (session('status') === 'info' ? 'Info!' : 'Error!') }}</span> {{ session('message') }}
                </div>
            </div>
        @endif


        <div class="container mx-auto max-w-md p-8 border border-gray-300 rounded-lg mt-12">
            <h2 class="text-2xl font-bold mb-8 text-gray-800 text-center">Forgot Password</h2>
            <form action="{{ route('password.request') }}" method="post">
                @csrf
                <div class="mb-6">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                    <input type="email" id="email" name="email"
                           class="w-full px-6 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           value="{{ old('email')}}"
                           placeholder="you@example.com">
                </div>
                <x-fields_error name="email"/>
                <div class="flex space-x-4">
                    <button type="submit"
                            class="w-1/2 bg-yellow-400 text-white py-3 rounded-lg hover:bg-yellow-600 transition-colors font-bold">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
    <x-footer/>
</x-layout>
