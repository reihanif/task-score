@if (request()->route()->named($attributes->get('data-route-name')))
    <li title="{{ $attributes->get('data-menu-title') }}">
        <a class="group flex items-center rounded-lg bg-gray-100 p-2 text-gray-900 dark:bg-gray-700 dark:text-white"
            href="{{ route($attributes->get('data-route-name')) }}">
            @if ($slot->toHtml() !== '')
                <span class="*:h-5 *:w-5 *:flex-shrink-0 *:text-gray-900 *:transition *:duration-75 dark:*:text-white">
                    {{ $slot }}
                </span>
                <span class="ms-3 flex-1 whitespace-nowrap">
                    {{ $attributes->get('data-menu-name') }}
                </span>
            @else
                <span class="flex-1 whitespace-nowrap">
                    {{ $attributes->get('data-menu-name') }}
                </span>
            @endif
            @if ($attributes->get('data-badge-content'))
                <x-sidebar-menu-badge data-state="{{ $attributes->get('data-badge-color') }}">
                    {{ $attributes->get('data-badge-content') }}
                </x-sidebar-menu-badge>
            @endif
        </a>
    </li>
@else
    <li title="{{ $attributes->get('data-menu-title') }}">
        <a class="group flex items-center rounded-lg p-2 text-gray-900 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
            href="{{ route($attributes->get('data-route-name')) }}">
            @if ($slot->toHtml() !== '')
                <span class="*:h-5 *:w-5 *:flex-shrink-0 *:text-gray-500 *:transition *:duration-75 group-hover:*:text-gray-900 dark:*:text-gray-400 dark:group-hover:*:text-white">
                    {{ $slot }}
                </span>
                <span class="ms-3 flex-1 whitespace-nowrap">
                    {{ $attributes->get('data-menu-name') }}
                </span>
            @else
                <span class="flex-1 whitespace-nowrap">
                    {{ $attributes->get('data-menu-name') }}
                </span>
            @endif
            @if ($attributes->get('data-badge-content'))
                <x-sidebar-menu-badge data-state="{{ $attributes->get('data-badge-color') }}">
                    {{ $attributes->get('data-badge-content') }}
                </x-sidebar-menu-badge>
            @endif
        </a>
    </li>
@endif
