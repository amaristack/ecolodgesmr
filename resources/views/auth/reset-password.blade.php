<x-layout>
    <x-navbar/>
    <div class="relative bg-cover bg-center h-[300px] flex items-center justify-center w-full"
         style="background-image: url('{{ \Illuminate\Support\Facades\Vite::asset('resources/images/main.jpg') }}');">
        <div class="absolute inset-0 bg-blue-500 opacity-50"></div>
        <div class="container mx-auto relative z-10 flex items-center justify-center">
            <div class="text-center text-white">
                <h1 class="text-5xl font-bold mb-6">Welcome to Sibugay</h1>
                <nav class="text-white text-lg font-bold mb-8">
                    <a href="/dashboard" class="hover:underline">Home</a> / <a href="/register"
                                                                               class="underline">Reset Your Password</a>
                </nav>
            </div>
        </div>
    </div>



    <div class="w-full max-w-2xl p-12 bg-white border-2 border-gray-200 rounded-lg shadow-lg mx-auto mt-2 mb-2">
        <h1 class="text-2xl font-bold text-center mb-8 text-black mt-1">Reset Your Password</h1>
        <form class="p-4" action="{{ route('password.update') }}" method="post">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">
            <div class="mb-6">

                <label for="email" class="block mb-2 text-sm font-medium text-black">Email address</label>
                <input type="email" id="email" name="email" value="{{ old('email')}}"
                       class="bg-white border border-gray-300 text-black text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                       placeholder="john.doe@company.com" required/>
            </div>
            <x-fields_error name="email"/>
            <div class="mb-6">
                <label for="password" class="block mb-2 text-sm font-medium text-black">Password</label>
                <input type="password" id="password" name="password"
                       class="bg-white border border-gray-300 text-black text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                       placeholder="•••••••••" required/>
            </div>
            <x-fields_error name="password"/>
            <div class="mb-6">
                <label for="confirm_password" class="block mb-2 text-sm font-medium text-black">Confirm
                    password</label>
                <input type="password" id="confirm_password" name="password_confirmation"
                       class="bg-white border border-gray-300 text-black text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                       placeholder="•••••••••" required/>
            </div>
            <button type="submit"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">
                Reset Password
            </button>
        </form>
    </div>
    <x-newsletter/>
    <x-footer/>
</x-layout>
