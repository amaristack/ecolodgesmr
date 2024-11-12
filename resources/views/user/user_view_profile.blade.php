<x-layout>
    <x-user_nav/>
    <x-user_sidebar/>

    <div class="max-w-4xl mx-auto py-10 mt-8 sm:ml-64">
        <!-- Breadcrumb -->
        <nav class="flex mb-6 text-gray-700 ml-6 mt-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="/dashboard"
                       class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"
                             xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a2 2 0 001.995-1.85L12 16H8a2 2 0 001.995 1.85L10 18z"></path>
                        </svg>
                        Dashboard
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                             xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M10.293 15.707a1 1 0 010-1.414L13.586 11H3a1 1 0 110-2h10.586l-3.293-3.293a1 1 0 111.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z"
                                  clip-rule="evenodd"></path>
                        </svg>
                        <a href="#" class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Profile</a>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Page Heading -->
        <div class="flex justify-between items-center ml-6 pb-6">
            <h2 class="text-2xl font-semibold text-gray-700">Profile</h2>
        </div>

        <!-- Profile Information Display -->
        <div class="bg-white rounded-lg ml-6 p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- First Name -->
                <div class="flex flex-col">
                    <label for="first_name" class="text-gray-700 font-semibold mb-2">First Name</label>
                    <p id="first_name" class="rounded-lg border-gray-300 px-4 py-2 bg-gray-100">{{ $user->first_name }}</p>
                </div>

                <!-- Middle Name -->
                <div class="flex flex-col">
                    <label for="middle_name" class="text-gray-700 font-semibold mb-2">Middle Name</label>
                    <p id="middle_name" class="rounded-lg border-gray-300 px-4 py-2 bg-gray-100">{{ $user->middle_name }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <!-- Last Name -->
                <div class="flex flex-col">
                    <label for="last_name" class="text-gray-700 font-semibold mb-2">Last Name</label>
                    <p id="last_name" class="rounded-lg border-gray-300 px-4 py-2 bg-gray-100">{{ $user->last_name }}</p>
                </div>

                <!-- Address -->
                <div class="flex flex-col">
                    <label for="address" class="text-gray-700 font-semibold mb-2">Address</label>
                    <p id="address" class="rounded-lg border-gray-300 px-4 py-2 bg-gray-100">{{ $user->address }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <!-- Birth Date -->
                <div class="flex flex-col">
                    <label for="birth_date" class="text-gray-700 font-semibold mb-2">Birth Date</label>
                    <p id="birth_date" class="rounded-lg border-gray-300 px-4 py-2 bg-gray-100">{{ $user->birth_date }}</p>
                </div>

                <!-- Age -->
                <div class="flex flex-col">
                    <label for="age" class="text-gray-700 font-semibold mb-2">Age</label>
                    <p id="age" class="rounded-lg border-gray-300 px-4 py-2 bg-gray-100">{{ $user->age }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <!-- Email -->
                <div class="flex flex-col">
                    <label for="email" class="text-gray-700 font-semibold mb-2">Email Address</label>
                    <p id="email" class="rounded-lg border-gray-300 px-4 py-2 bg-gray-100">{{ $user->email }}</p>
                </div>
            </div>
        </div>

        <!-- Edit Profile Button -->
        <div class="flex justify-end mt-8">
            <a href="/profile/{{ $user->id }}/edit"
               class="px-6 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700">Edit Profile</a>
        </div>
    </div>
</x-layout>
