<x-layout>
    <div class="container">
        <h1>Processing Payment...</h1>
        <p>Please wait while we confirm your payment.</p>
        <div id="status-message"></div>
        <div id="error-message" class="alert alert-danger d-none">
            Unable to verify payment status. Please contact support if the issue persists.
        </div>
    </div>

    <script>
        function checkPaymentStatus() {
            fetch('{{ route("check-payment-status") }}')
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'Pending') {
                        window.location.href = '{{ route("payment-success") }}';
                    } else if (data.status === 'Failed') {
                        window.location.href = '{{ route("payment-failure") }}';
                    } else if (data.status === 'unknown') {
                        document.getElementById('error-message').classList.remove('d-none');
                        document.getElementById('status-message').innerText = 'Payment status is unclear. Please contact support.';
                    } else {
                        // Continue polling
                        setTimeout(checkPaymentStatus, 3000);
                    }
                })
                .catch(error => {
                    console.error('Error checking payment status:', error);
                    document.getElementById('error-message').classList.remove('d-none');
                    document.getElementById('status-message').innerText = 'An error occurred while verifying payment status.';
                });
        }

        // Start polling after the page loads
        window.onload = checkPaymentStatus;
    </script>
</x-layout>
