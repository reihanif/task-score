@if ($attributes->get('data-state') == 'green')
    <span
        class="ms-1 inline-flex h-3 items-center justify-center rounded-full px-2 py-3 text-sm font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
        {{ $slot }}
    </span>
@elseif ($attributes->get('data-state') == 'blue')
    <span
        class="ms-1 inline-flex h-3 items-center justify-center rounded-full px-2 py-3 text-sm font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300">
        {{ $slot }}
    </span>
@elseif ($attributes->get('data-state') == 'yellow')
    <span
        class="ms-1 inline-flex h-3 items-center justify-center rounded-full px-2 py-3 text-sm font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300">
        {{ $slot }}
    </span>
@elseif ($attributes->get('data-state') == 'red')
    <span
        class="ms-1 inline-flex h-3 items-center justify-center rounded-full px-2 py-3 text-sm font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300">
        {{ $slot }}
    </span>
@else
    <span
        class="ms-1 inline-flex h-3 items-center justify-center rounded-full px-2 py-3 text-sm font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
        {{ $slot }}
    </span>
@endif
