<x-layout>
    <div class="mx-auto max-w-sm rounded-lg bg-white p-6 shadow">
        <h1 class="mb-6 text-xl font-bold">Log in</h1>

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                       class="mt-1 w-full rounded border border-gray-300 px-3 py-2">
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium">Password</label>
                <input id="password" name="password" type="password" required
                       class="mt-1 w-full rounded border border-gray-300 px-3 py-2">
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full rounded bg-gray-900 py-2 text-white hover:bg-gray-700">
                Log in
            </button>
        </form>

        <p class="mt-4 text-center text-sm">
            No account? <a href="{{ route('register') }}" class="underline">Register</a>
        </p>
    </div>
</x-layout>
