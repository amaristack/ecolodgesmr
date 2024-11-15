<x-layout>
    <x-navbar />
    <div class="relative bg-cover bg-center h-[300px] flex items-center justify-center"
         style="background-image: url('{{ \Illuminate\Support\Facades\Vite::asset('resources/images/main.jpg') }}');">
        <div class="absolute inset-0 bg-blue-500 opacity-50"></div>
        <div class="container mx-auto relative z-10 flex items-center justify-center">
            <div class="text-center text-white">
                <h1 class="text-5xl font-bold mb-6">Welcome to Sibugay</h1>
                <nav class="text-white text-lg font-bold mb-8">
                    <a href="/dashboard" class="hover:underline">Home</a> / <a href="/dashboard/{id}" class="underline">User Dashboard</a>
                </nav>
            </div>
        </div>
    </div>

    <div class="flex flex-col md:flex-row container mx-auto my-8 items-center md:items-start justify-center">
        <div class="w-full md:w-1/4 md:h-screen bg-white shadow-lg mb-8 md:mb-0 rounded-3xl">
            <div class="text-center p-8">
                <div class="w-20 h-20 rounded-full bg-red-500 flex items-center justify-center mx-auto">
                    <img src="{{ \Illuminate\Support\Facades\Vite::asset('resources/images/mario.png') }}" alt="" class="rounded-full"/>
                </div>
                <h3 class="mt-4 text-lg font-semibold">{{ $user->first_name }} {{ $user->last_name }}</h3>
                <p class="text-sm text-gray-500">{{ $user->email }}</p>
            </div>
            <div class="mt-8">
                    <x-sidebar/>
            </div>
        </div>

{{--    Right Text    --}}
        <div class="w-full md:w-3/4 p-8">
            <h1 class="text-2xl font-bold mb-4">Hello, {{ $user->first_name }}</h1>
            <p class="text-gray-600">From your account dashboard, you can view your <span class="font-semibold">recent booking</span>, <span class="font-semibold">profile</span> and <span class="font-semibold">change password</span>.</p>
        </div>
    </div>

<x-footer/>
</x-layout>
