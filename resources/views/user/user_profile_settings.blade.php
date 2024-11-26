<x-layout>
    <x-navbar/>

    <!-- Hero Section -->
    <div class="relative bg-cover bg-center h-[350px] flex items-center justify-center"
         style="background-image: url('https://vnfoxcdnoahqenfjssdv.supabase.co/storage/v1/object/public/ecolodgesmr/images/main.jpg');">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-indigo-700 opacity-60"></div>
        <div class="container mx-auto relative z-10 flex items-center justify-center">
            <div class="text-center text-white">
                <h1 class="text-4xl md:text-5xl font-extrabold mb-4">Welcome to Sibugay Resort</h1>
                <nav class="text-lg font-medium">
                    <a href="/dashboard" class="hover:underline">Home</a> /
                    <a href="/dashboard/{id}" class="underline">User Dashboard</a>
                </nav>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto flex flex-col md:flex-row my-12 gap-8">

        <!-- Profile Sidebar -->
        <div class="w-full md:w-1/4 bg-white shadow-lg rounded-xl p-6">
            <div class="text-center">
                <div class="w-24 h-24 rounded-full bg-red-500 mx-auto flex items-center justify-center overflow-hidden mb-4">
                    <img src="https://vnfoxcdnoahqenfjssdv.supabase.co/storage/v1/object/public/ecolodgesmr/images/mario.png?t=2024-11-19T05%3A51%3A38.924Z" alt="User Avatar" class="rounded-full"/>
                </div>
                <h3 class="text-lg font-semibold">{{ $user->first_name }} {{ $user->last_name }}</h3>
                <p class="text-sm text-gray-500">{{ $user->email }}</p>
            </div>
            <div class="mt-6">
                <x-sidebar/>
            </div>
        </div>

        <!-- Edit Profile Form -->
        <div class="w-full md:w-3/4 bg-white shadow-lg rounded-xl p-8">
            <h1 class="text-2xl font-semibold mb-6 text-gray-700">Edit Profile</h1>
            <form action="/user/{{ $user->id }}" method="POST" class="space-y-6">
                @csrf
                @method('PATCH')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- First Name -->
                    <div class="flex flex-col">
                        <label for="first_name" class="text-sm font-medium text-gray-700">First Name</label>
                        <input type="text" name="first_name" id="first_name" value="{{ $user->first_name }}"
                               class="mt-2 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <x-fields_error name="first_name"/>
                    </div>

                    <!-- Middle Name -->
                    <div class="flex flex-col">
                        <label for="middle_name" class="text-sm font-medium text-gray-700">Middle Name</label>
                        <input type="text" name="middle_name" id="middle_name" value="{{ $user->middle_name }}"
                               class="mt-2 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <x-fields_error name="middle_name"/>
                    </div>

                    <!-- Last Name -->
                    <div class="flex flex-col">
                        <label for="last_name" class="text-sm font-medium text-gray-700">Last Name</label>
                        <input type="text" name="last_name" id="last_name" value="{{ $user->last_name }}"
                               class="mt-2 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <x-fields_error name="last_name"/>
                    </div>
                </div>

                <!-- Email -->
                <div class="flex flex-col mt-4">
                    <label for="email" class="text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" value="{{ $user->email }}"
                           class="mt-2 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <x-fields_error name="email"/>
                </div>

                <!-- Phone Number -->
                <div class="flex flex-col mt-4">
                    <label for="phone" class="text-sm font-medium text-gray-700">Phone Number</label>
                    <input type="text" name="phone_number" id="phone" value="{{ $user->phone_number ?? '' }}"
                           class="mt-2 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <x-fields_error name="phone_number"/>
                </div>

                <!-- Address -->
                <div class="flex flex-col mt-4">
                    <label for="address" class="text-sm font-medium text-gray-700">Address</label>
                    <textarea name="address" id="address" rows="3"
                              class="mt-2 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ $user->address ?? '' }}</textarea>
                    <x-fields_error name="address"/>
                </div>

                <!-- Save Button -->
                <div class="flex justify-end mt-6">
                    <button type="submit"
                            class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-bold py-2 px-6 rounded-lg shadow-md hover:bg-indigo-700 transition">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

    <x-footer/>
</x-layout>
