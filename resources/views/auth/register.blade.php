<x-layout>
    <x-navbar />
    <div class="relative bg-gradient-to-br from-blue-500 to-green-400 bg-cover bg-center h-[300px] flex items-center justify-center"
        style="background-image: url('https://vnfoxcdnoahqenfjssdv.supabase.co/storage/v1/object/public/ecolodgesmr/images/main.jpg');">
        <div class="absolute inset-0 bg-black opacity-30"></div>
        <div class="container mx-auto relative z-10 text-center text-white">
            <h1 class="text-5xl font-bold mb-4">Join us in Ecolodge SMR </h1>
            <nav class="text-lg mb-6">
                <a href="/dashboard" class="hover:underline">Home</a> / <a href="/register"
                    class="underline text-yellow-500">Register</a>
            </nav>
        </div>
    </div>

    <div class="w-full max-w-3xl p-12 bg-white border-2 border-gray-200 rounded-3xl shadow-xl mx-auto mt-10 mb-10">
        <h1 class="text-3xl font-bold text-center mb-8 text-black">Create Your Account</h1>
        <form class="p-4" action="/register" method="post">
            @csrf
            <div class="grid gap-6 mb-8 md:grid-cols-2">
                <div>
                    <label for="first_name" class="block mb-2 text-sm font-medium text-gray-700">First Name</label>
                    <input type="text" id="first_name" name="first_name"
                        class="bg-gray-100 border border-gray-300 text-gray-700 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-3"
                        placeholder="John" required />
                </div>
                <x-fields_error name="first_name" />
                <div>
                    <label for="middle_name" class="block mb-2 text-sm font-medium text-gray-700">Middle Initial</label>
                    <input type="text" id="middle_name" name="middle_name"
                        class="bg-gray-100 border border-gray-300 text-gray-700 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-3"
                        placeholder="A." required />
                </div>
                <x-fields_error name="middle_name" />
                <div>
                    <label for="last_name" class="block mb-2 text-sm font-medium text-gray-700">Last Name</label>
                    <input type="text" id="last_name" name="last_name"
                        class="bg-gray-100 border border-gray-300 text-gray-700 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-3"
                        placeholder="Doe" required />
                </div>
                <x-fields_error name="last_name" />
                <div>
                    <label for="address" class="block mb-2 text-sm font-medium text-gray-700">Address</label>
                    <input type="text" id="address" name="address"
                        class="bg-gray-100 border border-gray-300 text-gray-700 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-3"
                        placeholder="123 Main St." required />
                </div>
                <x-fields_error name="address" />
                <div>
                    <label for="birth_date" class="block mb-2 text-sm font-medium text-gray-700">Birth Date</label>
                    <input type="date" id="birth_date" name="birth_date"
                        class="bg-gray-100 border border-gray-300 text-gray-700 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-3"
                        required />
                </div>
                <x-fields_error name="birth_date" />
                <div>
                    <label for="age" class="block mb-2 text-sm font-medium text-gray-700">Age</label>
                    <input type="number" id="age" name="age"
                        class="bg-gray-100 border border-gray-300 text-gray-700 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-3"
                        required />
                </div>
                <x-fields_error name="age" />
                <div>
                    <label for="phone_number" class="block mb-2 text-sm font-medium text-gray-700">Phone Number</label>
                    <input type="number" id="phone_number" name="phone_number" placeholder="09...."
                        class="bg-gray-100 border border-gray-300 text-gray-700 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-3"
                        required />
                </div>
                <x-fields_error name="phone_number" />
            </div>

            <div class="mb-6">
                <label for="email" class="block mb-2 text-sm font-medium text-gray-700">Email Address</label>
                <input type="email" id="email" name="email"
                    class="bg-gray-100 border border-gray-300 text-gray-700 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-3"
                    placeholder="john.doe@example.com" required value="{{ old('email', session('verified_email')) }}"
                    readonly />
            </div>
            <x-fields_error name="email" />

            <div class="mb-6 relative">
                <label for="password" class="block mb-2 text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password" name="password"
                    class="bg-gray-100 border border-gray-300 text-gray-700 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-3"
                    placeholder="•••••••••" required />
                <span id="togglePassword" class="absolute inset-y-0 right-4 flex items-center cursor-pointer mt-6">
                    <i class="fas fa-eye text-gray-500"></i>
                </span>
            </div>
            <x-fields_error name="password" />

            <div class="mb-6 relative">
                <label for="confirm_password" class="block mb-2 text-sm font-medium text-gray-700">Confirm
                    Password</label>
                <input type="password" id="confirm_password" name="password_confirmation"
                    class="bg-gray-100 border border-gray-300 text-gray-700 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-3"
                    placeholder="•••••••••" required />
                <span id="toggleConfirmPassword"
                    class="absolute inset-y-0 right-4 flex items-center cursor-pointer mt-6">
                    <i class="fas fa-eye text-gray-500"></i>
                </span>
                <p id="password-match" class="text-sm mt-2"></p>
            </div>
            <x-fields_error name="password_confirmation" />

            <div class="flex items-start mb-6">
                <input id="remember" type="checkbox" value=""
                    class="w-4 h-4 border border-gray-300 rounded bg-gray-100 focus:ring-3 focus:ring-green-300"
                    required />
                <label for="remember" class="ml-2 text-sm font-medium text-gray-700">I agree with the <a
                        href="{{ route('terms_and_condition') }}" class="text-blue-600 hover:underline">terms and
                        conditions</a>.
                </label>
            </div>


            <div class="mb-6">
                {!! htmlFormSnippet() !!}
                <x-fields_error name="g-recaptcha-response" />
            </div>


            <button id="registerButton" type="submit"
                class="w-full text-white bg-gradient-to-r from-green-500 to-blue-600 hover:from-green-600 hover:to-blue-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-lg py-3 text-center transition duration-300 disabled:opacity-50 disabled:cursor-not-allowed"
                disabled>
                Register Now
            </button>

            <p class="mt-4 text-center text-sm text-gray-700">Already have an account? <a href="/login"
                    class="text-blue-600 hover:underline">Log
                    in here</a>.
            </p>
        </form>
    </div>

    <script>
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('confirm_password');
        const passwordMatchIndicator = document.getElementById('password-match');
        const togglePassword = document.getElementById('togglePassword');
        const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
        const termsCheckbox = document.getElementById('remember');
        const registerButton = document.getElementById('registerButton');
        const birthDateInput = document.getElementById('birth_date');
        const ageInput = document.getElementById('age');

        // Function to check if passwords match
        function checkPasswordMatch() {
            const passwordsMatch = passwordInput.value === confirmPasswordInput.value && passwordInput.value !== "";
            if (passwordsMatch) {
                passwordMatchIndicator.textContent = "Passwords match";
                passwordMatchIndicator.classList.add("text-green-600");
                passwordMatchIndicator.classList.remove("text-red-600");
            } else {
                passwordMatchIndicator.textContent = passwordInput.value && confirmPasswordInput.value ?
                    "Passwords do not match" : "";
                passwordMatchIndicator.classList.add("text-red-600");
                passwordMatchIndicator.classList.remove("text-green-600");
            }
            return passwordsMatch;
        }

        // Function to calculate age based on birth date
        function calculateAge(birthDate) {
            const today = new Date();
            const birthDateObj = new Date(birthDate);
            let age = today.getFullYear() - birthDateObj.getFullYear();
            const monthDiff = today.getMonth() - birthDateObj.getMonth();
            const dayDiff = today.getDate() - birthDateObj.getDate();

            if (monthDiff < 0 || (monthDiff === 0 && dayDiff < 0)) {
                age--;
            }
            return age;
        }

        // Function to check if reCAPTCHA is completed
        function isRecaptchaCompleted() {
            try {
                return grecaptcha && grecaptcha.getResponse().length > 0;
            } catch (e) {
                console.log("reCAPTCHA not yet loaded");
                return false;
            }
        }

        // Function to update the register button's disabled state
        function updateRegisterButtonState() {
            const passwordsMatch = checkPasswordMatch();
            const termsChecked = termsCheckbox.checked;
            const captchaCompleted = isRecaptchaCompleted();

            const shouldEnable = passwordsMatch && termsChecked && captchaCompleted;
            registerButton.disabled = !shouldEnable;
        }

        // Event listeners
        passwordInput.addEventListener('input', updateRegisterButtonState);
        confirmPasswordInput.addEventListener('input', updateRegisterButtonState);
        termsCheckbox.addEventListener('change', updateRegisterButtonState);

        birthDateInput.addEventListener('input', () => {
            const birthDateValue = birthDateInput.value;
            if (birthDateValue) {
                const age = calculateAge(birthDateValue);
                ageInput.value = age >= 0 ? age : '';
            } else {
                ageInput.value = '';
            }
        });

        togglePassword.addEventListener('click', () => {
            const type = passwordInput.type === 'password' ? 'text' : 'password';
            passwordInput.type = type;
            togglePassword.innerHTML = type === 'password' ?
                '<i class="fas fa-eye text-gray-500"></i>' :
                '<i class="fas fa-eye-slash text-gray-500"></i>';
        });

        toggleConfirmPassword.addEventListener('click', () => {
            const type = confirmPasswordInput.type === 'password' ? 'text' : 'password';
            confirmPasswordInput.type = type;
            toggleConfirmPassword.innerHTML = type === 'password' ?
                '<i class="fas fa-eye text-gray-500"></i>' :
                '<i class="fas fa-eye-slash text-gray-500"></i>';
        });

        // Initialize reCAPTCHA callback
        window.onloadCallback = function() {
            grecaptcha.render('g-recaptcha', {
                'sitekey': '6LezP98qAAAAAGswvCXvKZnMZVaP56xy59tkWzY0',
                'callback': updateRegisterButtonState,
                'expired-callback': updateRegisterButtonState
            });
        };

        // Initial state check
        updateRegisterButtonState();
    </script>

    <x-footer />
</x-layout>
