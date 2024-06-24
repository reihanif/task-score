<div>
    @if ($attributes->get('state') == 'initial')
        @if ($attributes->has('label'))
            <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
                for="{{ $attributes->get('id') }}">
                {{ $attributes->get('label') }}
                @if ($attributes->has('required'))
                    <span class="text-red-600 dark:text-red-500">*</span>
                @endif
            </label>
        @endif
        <div>
            <select class="tom-select"
                {{ $attributes }}>
                {{ $slot }}
            </select>
            @if ($attributes->has('helper'))
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    {{ $attributes->get('helper') }}
                </p>
            @endif
        </div>
    @elseif ($attributes->get('state') == 'error')
        @if ($attributes->has('label'))
            <label class="mb-2 block text-sm font-medium text-red-700 dark:text-red-500"
                for="{{ $attributes->get('id') }}">
                {{ $attributes->get('label') }}
                @if ($attributes->has('required'))
                    <span class="text-red-600 dark:text-red-500">*</span>
                @endif
            </label>
        @endif
        <div>
            <select class="tom-select"
                {{ $attributes }}>
                {{ $slot }}
            </select>
            @if ($attributes->has('helper'))
                <p class="mt-1 text-sm text-red-600 dark:text-red-500">
                    {{ $attributes->get('helper') }}
                </p>
            @endif
        </div>
    @else
        <input {{ $attributes }}>
    @endif
</div>
