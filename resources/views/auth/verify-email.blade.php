<!-- resources/views/auth/verify-email.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Verify Email</title>
    <!-- Include your CSS here -->
</head>
<body>
    <h1>Verify Your Email</h1>

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

    <form method="POST" action="{{ route('send.otp') }}">
        @csrf
        <label for="email">Email:</label>
        <input type="email" name="email" required value="{{ old('email') }}">
        @error('email')
            <div style="color: red;">{{ $message }}</div>
        @enderror
        <button type="submit">Send OTP</button>
    </form>
</body>
</html>
