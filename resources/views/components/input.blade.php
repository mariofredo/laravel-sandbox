@props (["name", "label", "type" => "text"])
<div class="flex flex-col gap-2">
    <!-- The best way to take care of the future is to take care of the present moment. - Thich Nhat Hanh -->
    <label class="text-sm font-medium" for="{{ $name }}">{{ $label }}</label>

    @if ($type === 'password')
        <div class="relative mt-1" x-data="{ show: false }">
            <input
                type="password"
                :type="show ? 'text' : 'password'"
                name="{{ $name }}"
                id="{{ $name }}"
                {{ $attributes->merge(['class' => 'w-full rounded border border-gray-300 py-2 pr-10 pl-3']) }}
            />
            <button
                type="button"
                aria-label="Show password"
                :aria-label="show ? 'Hide password' : 'Show password'"
                @click="show = ! show"
                class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 hover:text-gray-700"
            >
                {{-- Heroicons: eye --}}
                <svg x-show="show" x-cloak xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
                {{-- Heroicons: eye-slash --}}
                <svg x-show="! show" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                </svg>
            </button>
        </div>
    @else
        <input
            type="{{ $type }}"
            name="{{ $name }}"
            id="{{ $name }}"
            value="{{ old($name) }}"
            {{ $attributes->merge(['class' => 'mt-1 w-full rounded border border-gray-300 px-3 py-2']) }}
        />
    @endif

    @error ($name)
        <p class="text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
