<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Aspirian Student Platform')</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f7f9;
            color: #1f2937;
        }

        .navbar {
            background: #172A26;
            color: white;
            padding: 14px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
        }

        .brand {
            font-size: 22px;
            font-weight: bold;
            white-space: nowrap;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            padding: 8px 10px;
            border-radius: 5px;
        }

        .nav-links a:hover,
        .nav-links a.active {
            background: rgba(255, 255, 255, 0.12);
        }

        .logout-button {
            background: transparent;
            border: 1px solid rgba(255,255,255,0.5);
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
        }

        .logout-button:hover {
            background: rgba(255,255,255,0.1);
        }

        .container {
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .card-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
        }

        .card {
            background: white;
            padding: 24px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.06);
        }

        .card h3 {
            margin-top: 0;
        }

        .status {
            display: inline-block;
            margin-top: 8px;
            padding: 5px 10px;
            border-radius: 20px;
            background: #e8f5e9;
            color: #256029;
            font-size: 13px;
            font-weight: bold;
        }

        @media (max-width: 700px) {
            .navbar {
                flex-wrap: wrap;
                padding: 14px 18px;
            }

            .nav-links {
                width: 100%;
                flex-wrap: wrap;
            }

            .container {
                margin-top: 25px;
            }
        }
    </style>

    @stack('styles')
</head>

<body>

<header class="navbar">

    <div class="brand">
        Aspirian Student Platform
    </div>

    @auth
        <nav class="nav-links">
            <a
                href="{{ route('dashboard') }}"
                class="{{ request()->routeIs('dashboard') ? 'active' : '' }}"
            >
                Dashboard
            </a>

            <a
                href="{{ route('profile.edit') }}"
                class="{{ request()->routeIs('profile.*') ? 'active' : '' }}"
            >
                Profile
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-button">
                    Logout
                </button>
            </form>
        </nav>
    @endauth

</header>

<main class="container">
    @yield('content')
</main>

@stack('scripts')

</body>
</html>