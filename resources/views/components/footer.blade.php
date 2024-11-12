@php use Illuminate\Support\Facades\Vite; @endphp
<footer class="bg-white">
    <div class="mx-auto w-full max-w-screen-xl p-4 py-6 lg:py-8">
        <div class="md:flex md:justify-between">
            <div class="mb-6 md:mb-0">
                <a href="https://flowbite.com/" class="flex items-center">
                    <img src="{{ Vite::asset('resources/images/logo1.jpg') }}" class="h-14 me-3" alt="FlowBite Logo" />
                    <span class="self-center text-2xl font-semibold whitespace-nowrap text-[#1f3347]">Ecolodge SMR</span>
                </a>
            </div>
            <div class="grid grid-cols-2 gap-8 sm:gap-6 sm:grid-cols-3">
                <div>
                    <h2 class="mb-6 text-lg font-bold uppercase text-[#1f3347]">Resources</h2>
                    <ul class="text-[#1f3347] font-medium">
                        <li class="mb-4">
                            <a href="https://www.facebook.com/ecolodgesibugaymountainresort" class="hover:underline">Ecolodge</a>
                        </li>
                        <li>
                            <a href="https://lgualbuera.com/" class="hover:underline">Albuera, Leyte</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h2 class="mb-6 text-lg font-bold uppercase text-[#1f3347]">Follow us</h2>
                    <ul class="text-[#1f3347] font-medium">
                        <li class="mb-4">
                            <a href="https://www.facebook.com/ecolodgesibugaymountainresort" class="hover:underline">Facebook</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h2 class="mb-6 text-lg font-bold uppercase text-[#1f3347]">Legal</h2>
                    <ul class="text-[#1f3347] font-medium">
                        <li class="mb-4">
                            <a href="/privacy" class="hover:underline">Privacy Policy</a>
                        </li>
                        <li>
                            <a href="/terms" class="hover:underline">Terms &amp; Conditions</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <hr class="my-6 border-gray-600 sm:mx-auto lg:my-8" />
        <div class="sm:flex sm:items-center sm:justify-between">
            <span class="text-sm text-[#1f3347] sm:text-center">© 2024 <a href="https://www.facebook.com/zesty.ellaine/" class="hover:underline">JSGUYA</a>. All Rights Reserved.</span>
            <div class="flex mt-4 sm:justify-center sm:mt-0">
                <a href="https://www.facebook.com/ecolodgesibugaymountainresort">
                    <svg class="w-4 h-4 text-[#1f3347]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 8 19">
                        <path fill-rule="evenodd" d="M6.135 3H8V0H6.135a4.147 4.147 0 0 0-4.142 4.142V6H0v3h2v9.938h3V9h2.021l.592-3H5V3.591A.6.6 0 0 1 5.592 3h.543Z" clip-rule="evenodd"/>
                    </svg>
                    <span class="sr-only">Facebook page</span>
                </a>
            </div>
        </div>
    </div>
</footer>
