<x-layout>
    <div class="mx-auto max-w-sm rounded-lg bg-white p-6 shadow">
        <h1 class="mb-6 text-xl font-bold">Create account</h1>

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <div>
                <label for="name" class="block text-sm font-medium">Name</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus
                       class="mt-1 w-full rounded border border-gray-300 px-3 py-2">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required
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

            <div>
                <label for="password_confirmation" class="block text-sm font-medium">Confirm password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required
                       class="mt-1 w-full rounded border border-gray-300 px-3 py-2">
            </div>

            <button type="submit" class="w-full rounded bg-gray-900 py-2 text-white hover:bg-gray-700">
                Register
            </button>
        </form>

        <p class="mt-4 text-center text-sm">
            Already registered? <a href="{{ route('login') }}" class="underline">Log in</a>
        </p>
    </div>
</x-layout>
