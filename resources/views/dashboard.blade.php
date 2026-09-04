@extends('layouts.app')

@section('title', 'Dashboard - Aspirian Student Platform')

@section('content')

<section class="welcome">
    <h1>Welcome, {{ auth()->user()->name }}</h1>
    <p>Your Aspirian Student Platform dashboard.</p>
</section>

<section class="card-grid">

    <div class="card">
    <h3>Profile</h3>

    <p><strong>Name:</strong> {{ auth()->user()->name }}</p>

    <p><strong>Email:</strong> {{ auth()->user()->email }}</p>

    <p>
        <strong>Role:</strong>
        {{ implode(', ', auth()->user()->roleNames()) ?: 'No role assigned' }}
    </p>

    <span class="status">Verified Account</span>
    </div>

    <div class="card">
        <h3>Coming Soon</h3>
        <p>Notes, tests, results and student tools will be added in upcoming phases.</p>
    </div>

</section>

@endsection