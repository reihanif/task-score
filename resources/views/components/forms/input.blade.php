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
            <input {{ $attributes->merge(['class' => 'block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 focus:border-blue-600 focus:ring-blue-600 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500 sm:text-sm']) }}
                {{ $attributes }}>
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
            <input {{ $attributes->merge(['class' => 'block w-full rounded-lg border border-red-500 bg-red-50 p-2.5 text-sm text-red-900 placeholder-red-700 focus:border-red-500 focus:ring-red-500 dark:border-red-500 dark:bg-gray-700 dark:text-red-500 dark:placeholder-red-500']) }}
                {{ $attributes }}>
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
