@extends('layouts.app')

@section('title', 'My Profile - Aspirian Student Platform')

@section('content')

<div class="card">

    <h1>My Profile</h1>

    @if (session('status'))
        <p class="status">{{ session('status') }}</p>
    @endif

    @if ($errors->any())
        <div style="margin-bottom: 20px; color:#b91c1c;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 18px;">
            <label for="name"><strong>Name</strong></label>

            <input
                id="name"
                type="text"
                name="name"
                value="{{ old('name', $user->name) }}"
                required
                style="display:block; width:100%; max-width:500px; padding:10px; margin-top:6px;"
            >

            @error('name')
                <p style="color:#b91c1c;">{{ $message }}</p>
            @enderror
        </div>

        <div style="margin-bottom: 18px;">
            <strong>Email</strong>
            <p>{{ $user->email }}</p>
        </div>

        <div style="margin-bottom: 18px;">
            <strong>Role</strong>
            <p>{{ implode(', ', $user->roleNames()) ?: 'No role assigned' }}</p>
        </div>

        <button
            type="submit"
            style="padding:10px 18px; border:0; border-radius:6px; cursor:pointer;"
        >
            Update Profile
        </button>
    </form>

    <hr style="margin:30px 0; border:0; border-top:1px solid #e5e7eb;">

    <h2>Account Security</h2>

    <p>Keep your account secure by changing your password regularly.</p>

    <a
        href="{{ route('password.edit') }}"
        style="display:inline-block; padding:10px 18px; background:#172A26; color:white; text-decoration:none; border-radius:6px;"
    >
        Change Password
    </a>

</div>

@endsection