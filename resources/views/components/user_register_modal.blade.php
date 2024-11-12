<div id="registration-modal" tabindex="-1" aria-hidden="true"
     class="{{ $errors->any() ? 'flex' : 'hidden' }} overflow-y-auto overflow-x-hidden fixed inset-0 z-50 justify-center items-center w-full h-full">
<div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">

            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    <i class="fa fa-user"></i> User Register
                </h3>
                <button type="button"
                        class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="registration-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>

            <div class="p-4 md:p-5">
                <form class="space-y-4" action="/register" method="post">
                    @csrf
                    <div>
                        <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">First Name</label>
                        <input type="text" name="first_name" id="first_name"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                               placeholder="First Name" value="{{ old('first_name') }}" required/>
                    </div>
                    <x-fields_error name="first_name"/>

                    <div>
                        <label for="middle_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Middle Name</label>
                        <input type="text" name="middle_name" id="middle_name"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                               placeholder="Middle Name" value="{{ old('middle_name') }}"/>
                    </div>
                    @error('middle_name')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <div>
                        <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Last Name</label>
                        <input type="text" name="last_name" id="last_name"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                               placeholder="Last Name" value="{{ old('last_name') }}" required/>
                    </div>
                    @error('last_name')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <div>
                        <label for="address" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Address</label>
                        <input type="text" name="address" id="address"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                               placeholder="Address" value="{{ old('address') }}" required/>
                    </div>
                    @error('address')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <div>
                        <label for="birth_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Birth Date</label>
                        <input type="date" name="birth_date" id="birth_date"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                               value="{{ old('birth_date') }}" required/>
                    </div>
                    @error('birth_date')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <div>
                        <label for="age" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Age</label>
                        <input type="number" name="age" id="age"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                               placeholder="Age" value="{{ old('age') }}" required/>
                    </div>
                    @error('age')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                        <input type="email" name="email" id="email"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                               placeholder="name@company.com" value="{{ old('email') }}" required/>
                    </div>
                    <x-fields_error name="email" />

                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                        <input type="password" name="password" id="password" placeholder="••••••••"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                               required/>
                    </div>
                    @error('password')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="••••••••"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                               required/>
                    </div>
                    @error('password_confirmation')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <button type="submit"
                            class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Register
                    </button>
                    <div class="text-sm font-medium text-gray-500 dark:text-gray-300">
                        Already have an account? <a href="#" data-modal-target="authentication-modal" data-modal-toggle="authentication-modal" data-modal-hide="registration-modal" class="text-blue-700 hover:underline dark:text-blue-500">Login here</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
