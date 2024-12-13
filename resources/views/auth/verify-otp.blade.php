<!-- resources/views/auth/verify-otp.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Verify OTP</title>
    <!-- Include your CSS here -->
</head>
<body>
    <h1>Enter OTP</h1>

    @if(session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="color: red;">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('verify.otp.post') }}">
        @csrf

        <label for="otp">OTP:</label>
        <input type="text" name="otp" required maxlength="6" autofocus>
        @error('otp')
            <div style="color: red;">{{ $message }}</div>
        @enderror

        <button type="submit">Verify OTP</button>
    </form>

    <form method="POST" action="{{ route('send.otp') }}">
        @csrf
        <!-- Pass the email from session -->
        <input type="hidden" name="email" value="{{ session('verified_email') }}">
        <button type="submit">Resend OTP</button>
    </form>
</body>
</html>
