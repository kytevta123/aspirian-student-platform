<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email - Aspirian</title>
</head>
<body>
    <h1>Verify Your Email Address</h1>

    @if (session('status'))
        <p>{{ session('status') }}</p>
    @endif

    <p>
        Thanks for registering! Before continuing, please verify your email
        address by clicking the link that was sent to your email.
    </p>

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf

        <button type="submit">
            Resend Verification Email
        </button>
    </form>

    <form method="POST" action="{{ route('logout') }}">
        @csrf

        <button type="submit">
            Log Out
        </button>
    </form>
</body>
</html>