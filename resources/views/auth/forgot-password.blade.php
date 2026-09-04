<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Aspirian</title>
</head>
<body>
    <h1>Forgot Password</h1>

    @if (session('status'))
        <p>{{ session('status') }}</p>
    @endif

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <p>Enter your email address and we will send you a password reset link.</p>

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div>
            <label for="email">Email</label>

            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autofocus
            >
        </div>

        <div>
            <button type="submit">
                Email Password Reset Link
            </button>
        </div>
    </form>

    <p>
        <a href="{{ route('login.form') }}">Back to Login</a>
    </p>
</body>
</html>