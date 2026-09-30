<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite (['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-100 text-gray-900">
    <nav class="bg-white shadow">
        <div
            class="mx-auto flex max-w-4xl items-center justify-between px-4 py-3"
        >
            <a
                href="/"
                class="font-semibold"
                >{{ config('app.name', 'Laravel') }}</a
            >

            <div class="flex items-center gap-4 text-sm">
                @guest
                    <a href="{{ route('login') }}" class="hover:underline"
                        >Login</a
                    >
                    <a href="{{ route('register') }}" class="hover:underline"
                        >Register</a
                    >
                @endguest

                @auth
                    <span>{{ auth()->user()->name }}</span>
                    <a href="{{ route('dashboard') }}" class="hover:underline"
                        >Dashboard</a
                    >
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="hover:underline">
                            Logout
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    </nav>

    <main class="mx-auto max-w-4xl px-4 py-10">{{ $slot }}</main>
</body>
</html>
