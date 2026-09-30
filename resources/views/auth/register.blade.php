<x-layout>
    <div class="mx-auto max-w-sm rounded-lg bg-white p-6 shadow">
        <h1 class="mb-6 text-xl font-bold">Create account</h1>

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <x-input name="name" label="Name" required autofocus />

            <x-input name="email" label="Email" type="email" required />

            <x-input name="password" label="Password" type="password" required />

            <x-input
                name="password_confirmation"
                label="Confirm password"
                type="password"
                required
            />

            <button
                type="submit"
                class="w-full rounded bg-gray-900 py-2 text-white hover:bg-gray-700"
            >
                Register
            </button>
        </form>

        <p class="mt-4 text-center text-sm">
            Already registered?
            <a href="{{ route('login') }}" class="underline">Log in</a>
        </p>
    </div>
</x-layout>
