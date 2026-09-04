@extends('layouts.app')

@section('title', 'Change Password - Aspirian Student Platform')

@section('content')

<div class="card">

    <h1>Change Password</h1>

    <p>Update your account password securely.</p>

    @if ($errors->any())
        <div style="margin-bottom: 20px; color:#b91c1c;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 18px;">
            <label for="current_password"><strong>Current Password</strong></label>

            <input
                id="current_password"
                type="password"
                name="current_password"
                required
                autocomplete="current-password"
                style="display:block; width:100%; max-width:500px; padding:10px; margin-top:6px;"
            >
        </div>

        <div style="margin-bottom: 18px;">
            <label for="password"><strong>New Password</strong></label>

            <input
                id="password"
                type="password"
                name="password"
                required
                autocomplete="new-password"
                style="display:block; width:100%; max-width:500px; padding:10px; margin-top:6px;"
            >
        </div>

        <div style="margin-bottom: 18px;">
            <label for="password_confirmation"><strong>Confirm New Password</strong></label>

            <input
                id="password_confirmation"
                type="password"
                name="password_confirmation"
                required
                autocomplete="new-password"
                style="display:block; width:100%; max-width:500px; padding:10px; margin-top:6px;"
            >
        </div>

        <button
            type="submit"
            style="padding:10px 18px; border:0; border-radius:6px; cursor:pointer;"
        >
            Change Password
        </button>

        <a
            href="{{ route('profile.edit') }}"
            style="margin-left:12px;"
        >
            Cancel
        </a>
    </form>

</div>

@endsection