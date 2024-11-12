<!DOCTYPE html>
<html>
<head>
    <title>Redirecting to Payment</title>
</head>
<body>
<script>
    // Open the PayMongo checkout URL in a new tab
    window.open('{{ $checkoutUrl }}', '_blank');

    // Redirect the current tab to a status checking page
    window.location.href = '{{ route("payment-status") }}';
</script>
</body>
</html>
