<x-layout>
    <div class="mx-auto max-w-sm rounded-lg bg-white p-6 shadow">
        <h1 class="mb-6 text-xl font-bold">Log in</h1>

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <x-input name="email" label="Email" type="email" />

            <x-input name="password" label="Password" type="password" />

            <button
                type="submit"
                class="w-full rounded bg-gray-900 py-2 text-white hover:bg-gray-700"
            >
                Log in
            </button>
        </form>

        <p class="mt-4 text-center text-sm">
            No account?
            <a href="{{ route('register') }}" class="underline">Register</a>
        </p>
    </div>
</x-layout>
