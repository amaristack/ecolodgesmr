<x-layout>
    <x-navbar />

    <div id="print-section" class="container mx-auto my-10 p-8 bg-white shadow-lg rounded-xl max-w-3xl">
        <!-- Receipt Header with Logo -->
        <div class="text-center mb-8">
            <img src="{{ \Illuminate\Support\Facades\Vite::asset('resources/images/logo.png') }}" alt="Resort Logo" class="w-24 mx-auto mb-4">
            <h1 class="text-4xl font-bold text-gray-800">Booking Information</h1>
            <p class="text-gray-500">Thank you for choosing our resort! Here are your booking details.</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success p-4 bg-green-100 text-green-800 rounded-md">
                {{ session('success') }}
            </div>
        @endif
        <!-- Gradient Background for Main Section -->
        <div class="bg-gradient-to-r from-blue-100 to-blue-50 p-6 rounded-xl shadow-inner mb-8">
            <!-- Booking Information -->
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h2 class="text-xl font-semibold text-gray-700">Booking ID: {{ $booking->booking_id }}</h2>
                    <p class="text-sm text-gray-500">Booking Date: {{ \Carbon\Carbon::parse($booking->created_at)->format('F j, Y') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Check-in: {{ \Carbon\Carbon::parse($booking->check_in)->format('F j, Y') }}</p>
                    <p class="text-sm text-gray-500">Check-out: {{ \Carbon\Carbon::parse($booking->check_out)->format('F j, Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Guest Information -->
        <div class="bg-gradient-to-r from-blue-50 to-white p-4 rounded-lg mb-6">
            <h3 class="text-2xl font-semibold text-blue-600 mb-3">Guest Information</h3>
            <div class="text-gray-700">
                <p><strong>Name:</strong> {{ $booking->user->first_name }} {{ $booking->user->last_name }}</p>
                <p><strong>Email:</strong> {{ $booking->user->email }}</p>
                <p><strong>Contact Number:</strong> {{ $booking->user->phone_number }}</p>
                <p><strong>Special Requests:</strong> {{ $booking->special_requests ?? 'None' }}</p>
            </div>
        </div>

        <!-- Booking Summary -->
        <div class="bg-gradient-to-r from-gray-100 to-gray-50 p-4 rounded-lg mb-6">
            <h3 class="text-2xl font-semibold text-blue-600 mb-3">Booking Summary</h3>
            <div class="text-gray-700">
                <p><strong>Type:</strong>
                    @if($booking->room_id) Room
                    @elseif($booking->pool_id) Cottage
                    @elseif($booking->activity_id) Activity
                    @elseif($booking->hall_id) Hall
                    @else N/A
                    @endif
                </p>
                <p><strong>Booking Status:</strong>
                    <span class="px-2 py-1 text-xs font-semibold rounded-full
                        @if($booking->booking_status == 'Approved') bg-green-500 text-white
                        @elseif($booking->booking_status == 'Pending') bg-yellow-500 text-white
                        @else bg-red-500 text-white
                        @endif">
                        {{ $booking->booking_status }}
                    </span>
                </p>
            </div>
        </div>

        <!-- Payment Information -->
        <div class="bg-gradient-to-r from-blue-50 to-blue-100 p-4 rounded-lg mb-6">
            <h3 class="text-2xl font-semibold text-blue-600 mb-3">Payment Information</h3>
            <div class="text-gray-700">
                <p><strong>Payment Status:</strong>
                    <span class="px-2 py-1 text-xs font-semibold rounded-full
                        @if($booking->payment_status == 'Fully Paid') bg-green-500 text-white
                        @elseif($booking->payment_status == 'Partial') bg-yellow-500 text-white
                        @else bg-red-500 text-white
                        @endif">
                        {{ $booking->payment_status }}
                    </span>
                </p>
                <p><strong>Total Amount:</strong> PHP {{ $booking->total_amount }}</p>
                <p><strong>Paid Amount:</strong> PHP {{ $booking->payment_amount }}</p>
                <p><strong>Balance:</strong> PHP {{ $booking->total_amount - $booking->balance_due }}</p>
            </div>
        </div>

    </div>

    <!-- Button Section -->
    <!-- Button Section -->
    <div class="flex justify-center gap-4 mt-8">
        <button onclick="printReceipt()" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-6 rounded-md shadow-md transition">
            Print Receipt
        </button>

        @if($booking->payment_status == 'Partial' && $booking->booking_status != 'Cancelled')
            <!-- Cancel Booking Button -->
            <button id="cancel-button" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-6 rounded-md shadow-md transition">
                Cancel Booking
            </button>
        @endif

        <a href="{{ route('view.booking') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-6 rounded-md shadow-md transition">
            Back to Dashboard
        </a>
    </div>


    <!-- Flowbite Modal for Confirmation -->
    <div id="cancel-modal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex justify-center items-center">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h2 class="text-xl font-semibold text-gray-700">Confirm Cancellation</h2>
            <p class="mt-2 text-gray-600">Are you sure you want to cancel this booking?</p>

            <!-- Form to confirm the cancellation -->
            <form id="cancel-form" action="{{ route('cancel.booking', ['booking_id' => $booking->booking_id]) }}" method="POST">
                @csrf
                @method('POST') <!-- Using POST request for form submission -->
                <div class="flex justify-end gap-4 mt-4">
                    <button type="button" onclick="closeModal()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-md">
                        Cancel
                    </button>
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-md">
                        Yes, Cancel Booking
                    </button>
                </div>
            </form>
        </div>
    </div>

    <br>
    <hr>

    <x-footer />

    <script>
        function printReceipt() {
            const printContent = document.getElementById('print-section').innerHTML;
            const originalContent = document.body.innerHTML;

            document.body.innerHTML = printContent;
            window.print();
            document.body.innerHTML = originalContent;
        }

        document.getElementById('cancel-button').addEventListener('click', function() {
            document.getElementById('cancel-modal').classList.remove('hidden');
        });

        // Close the modal
        function closeModal() {
            document.getElementById('cancel-modal').classList.add('hidden');
        }
    </script>
</x-layout>
