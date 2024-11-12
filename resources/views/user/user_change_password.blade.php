<x-layout>
    <x-navbar/>

    <!-- Banner Section -->
    <div class="relative bg-cover bg-center h-[300px] flex items-center justify-center"
         style="background-image: url('{{ \Illuminate\Support\Facades\Vite::asset('resources/images/main.jpg') }}');">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-blue-400 opacity-60"></div>
        <div class="container mx-auto relative z-10 flex items-center justify-center">
            <div class="text-center text-white">
                <h1 class="text-5xl font-extrabold mb-4">Welcome to Sibugay</h1>
                <nav class="text-white text-lg font-semibold mb-4">
                    <a href="/dashboard" class="hover:underline">Home</a> /
                    <a href="/dashboard/{id}" class="underline">User Dashboard</a>
                </nav>
            </div>
        </div>
    </div>

    <!-- Main Content Section -->
    <div class="container mx-auto my-12 flex flex-col md:flex-row items-center md:items-start justify-center gap-8">
        <!-- Sidebar -->
        <div class="w-full md:w-1/4 bg-white shadow-lg rounded-xl p-6">
            <div class="text-center">
                <div class="w-24 h-24 rounded-full bg-red-500 flex items-center justify-center mx-auto mb-4">
                    <img src="{{ \Illuminate\Support\Facades\Vite::asset('resources/images/mario.png') }}" alt=""
                         class="rounded-full"/>
                </div>
                <h3 class="text-xl font-semibold text-gray-800">{{ $user->first_name }} {{ $user->last_name }}</h3>
                <p class="text-gray-500">{{ $user->email }}</p>
            </div>
            <div class="mt-6">
                <x-sidebar/>
            </div>
        </div>

        <!-- Change Password Form -->
        <div class="w-full md:w-3/4 bg-white shadow-lg rounded-xl p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Change Password</h2>

            <!-- Success Message -->
            @if (session('success'))
                <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-lg mb-4" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded-lg mb-4" role="alert">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form for Changing Password -->
            <form action="{{ route('profile.updatePassword', $user->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="relative">
                    <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                    <input type="password" name="current_password" id="current_password"
                           class="w-full px-4 py-5 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500 transition sm:text-sm">
                    <span class="absolute inset-y-0 right-3 flex items-center cursor-pointer" onclick="togglePasswordVisibility('current_password', 'currentPasswordIcon')">
                        <i id="currentPasswordIcon" class="fas fa-eye text-gray-500"></i>
                    </span>
                </div>

                <div class="relative">
                    <label for="new_password" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                    <input type="password" name="new_password" id="new_password"
                           class="w-full px-4 py-5 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500 transition sm:text-sm">
                    <span class="absolute inset-y-0 right-3 flex items-center cursor-pointer" onclick="togglePasswordVisibility('new_password', 'newPasswordIcon')">
                        <i id="newPasswordIcon" class="fas fa-eye text-gray-500"></i>
                    </span>
                </div>

                <div class="relative">
                    <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                    <input type="password" name="new_password_confirmation" id="confirm_password"
                           class="w-full px-4 py-5 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500 transition sm:text-sm">
                    <span class="absolute inset-y-0 right-3 flex items-center cursor-pointer" onclick="togglePasswordVisibility('confirm_password', 'confirmPasswordIcon')">
                        <i id="confirmPasswordIcon" class="fas fa-eye text-gray-500a"></i>
                    </span>
                </div>

                <div class="flex justify-end mt-6">
                    <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-6 rounded-lg hover:bg-blue-600 transition">
                        Update Password
                    </button>
                </div>
            </form>
        </div>
    </div>

    <x-footer/>

    <!-- JavaScript for Password Toggle -->
    <script>
        function togglePasswordVisibility(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>

    <!-- Font Awesome CDN -->
  </x-layout>
