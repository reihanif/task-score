@if (request()->route()->named($attributes->get('data-route-name')))
    <li>
        <a class="group flex items-center rounded-lg bg-gray-100 p-2 text-gray-900 dark:bg-gray-700 dark:text-white"
            href="{{ route($attributes->get('data-route-name')) }}">
            <span class="*:h-5 *:w-5 *:flex-shrink-0 *:text-gray-900 *:transition *:duration-75 dark:*:text-white">
                {{ $slot }}
            </span>
            <span class="ms-3 flex-1 whitespace-nowrap">
                {{ $attributes->get('data-menu-name') }}
            </span>
            @if ($attributes->get('data-badge-content'))
                <div x-data="{ color: {{ '\'' . $attributes->get('data-badge-color') . '\'' }} }">
                    @if ($attributes->get('data-badge-color'))
                        <span
                            class="ms-3 inline-flex h-3 items-center justify-center rounded-full px-2 py-3 text-sm font-medium"
                            x-data="{ colorClass: 'bg-' + color + '-100 text-' + color + '-800 dark:bg-' + color + '-900 dark:text-' + color + '-300' }"
                            x-bind:class="colorClass">
                            {{ $attributes->get('data-badge-content') }}
                        </span>
                    @else
                        <span
                            class="ms-3 inline-flex h-3 items-center justify-center rounded-full bg-gray-100 px-2 py-3 text-sm font-medium text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                            {{ $attributes->get('data-badge-content') }}
                        </span>
                    @endif
                </div>
            @endif
        </a>
    </li>
@else
    <li>
        <a class="group flex items-center rounded-lg p-2 text-gray-900 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
            href="{{ route($attributes->get('data-route-name')) }}">
            <span
                class="*:h-5 *:w-5 *:flex-shrink-0 *:text-gray-500 *:transition *:duration-75 group-hover:*:text-gray-900 dark:*:text-gray-400 dark:group-hover:*:text-white">
                {{ $slot }}
            </span>
            <span class="ms-3 flex-1 whitespace-nowrap">
                {{ $attributes->get('data-menu-name') }}
            </span>
            @if ($attributes->get('data-badge-content'))
                <div x-data="{ color: {{ '\'' . $attributes->get('data-badge-color') . '\'' }} }">
                    @if ($attributes->get('data-badge-color'))
                        <span
                            class="ms-3 inline-flex h-3 items-center justify-center rounded-full px-2 py-3 text-sm font-medium"
                            x-data="{ colorClass: 'bg-' + color + '-100 text-' + color + '-800 dark:bg-' + color + '-900 dark:text-' + color + '-300' }"
                            x-bind:class="colorClass">
                            {{ $attributes->get('data-badge-content') }}
                        </span>
                    @else
                        <span
                            class="ms-3 inline-flex h-3 items-center justify-center rounded-full bg-gray-100 px-2 py-3 text-sm font-medium text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                            {{ $attributes->get('data-badge-content') }}
                        </span>
                    @endif
                </div>
            @endif
        </a>
    </li>
@endif
