
<x-layout>
    <x-navbar />

    <div class="container mx-auto p-8 bg-red-200 mb-8 rounded-lg text-center">
        <h1 class="text-3xl font-bold mb-6">Payment Failed</h1>

        <p>{{ session('error', 'There was an issue processing your payment. Please try again.') }}</p>

        @if($type && $id)
            <a href="{{ route('checkout', ['type' => $type, 'id' => $id]) }}" class="mt-4 inline-block bg-blue-500 text-white px-5 py-3 rounded-lg">Return to Checkout</a>
        @else
            <a href="{{ route('home') }}" class="mt-4 inline-block bg-blue-500 text-white px-5 py-3 rounded-lg">Return to Home</a>
        @endif
    </div>

    <x-footer />
</x-layout>
