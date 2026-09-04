<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Aspirian</title>
</head>
<body>
    <h1>Reset Password</h1>

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <input
            type="hidden"
            name="token"
            value="{{ request()->route('token') }}"
        >

        <div>
            <label for="email">Email</label>

            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email', request()->email) }}"
                required
                autofocus
            >
        </div>

        <div>
            <label for="password">New Password</label>

            <input
                id="password"
                type="password"
                name="password"
                required
            >
        </div>

        <div>
            <label for="password_confirmation">Confirm New Password</label>

            <input
                id="password_confirmation"
                type="password"
                name="password_confirmation"
                required
            >
        </div>

        <div>
            <button type="submit">
                Reset Password
            </button>
        </div>
    </form>

    <p>
        <a href="{{ route('login.form') }}">Back to Login</a>
    </p>
</body>
</html>