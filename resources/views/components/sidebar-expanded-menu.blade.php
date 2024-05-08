@if (request()->route()->named($routes))
    <li x-data="{ expanded: true }" title="{{ $attributes->get('data-group-title') }}">
        <button
            class="group flex w-full items-center rounded-lg p-2 text-gray-900 transition duration-75 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
            type="button"
            x-on:click="expanded = ! expanded">
            @if ($slot->toHtml() !== '')
                <span class="*:h-5 *:w-5 *:flex-shrink-0 *:text-gray-900 *:transition *:duration-75 dark:*:text-white">
                    {{ $slot }}
                </span>
                <span class="ms-3 flex-1 whitespace-nowrap text-left">
                    {{ $attributes->get('data-group-name') }}
                </span>
            @else
                <span class="flex-1 whitespace-nowrap text-left">
                    {{ $attributes->get('data-group-name') }}
                </span>
            @endif
            <!-- Chevron Icons -->
            <svg class="h-6 w-6 transition"
                aria-hidden="true"
                :class="expanded ? 'rotate-180' : ''"
                fill="currentColor"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                    clip-rule="evenodd">
                </path>
            </svg>
            <!-- End of Chevron Icons -->
        </button>
        <ul class="space-y-2 py-2"
            x-show="expanded"
            x-collapse>
            @foreach ($menus as $key => $menu)
                <!-- Menu Item -->
                @if (request()->route()->named($menu['data-route-name']))
                    <li title="{{ array_key_exists('data-menu-title', $menu) ? $menu['data-menu-title'] : null }}">
                        <a class="group flex w-full items-center rounded-lg bg-gray-100 p-2 pl-10  font-medium text-gray-900 transition duration-75 dark:bg-gray-700 dark:text-white"
                            href="{{ $menu['data-route-name'] ? route($menu['data-route-name']) : '#' }}">
                            {{ $menu['data-menu-name'] }}
                        </a>
                    </li>
                @else
                    <li title="{{ array_key_exists('data-menu-title', $menu) ? $menu['data-menu-title'] : null }}">
                        <a class="group flex w-full items-center rounded-lg p-2 pl-10  font-medium text-gray-900 transition duration-75 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                            href="{{ $menu['data-route-name'] ? route($menu['data-route-name']) : '#' }}">
                            {{ $menu['data-menu-name'] }}
                        </a>
                    </li>
                @endif
                <!-- End of Menu Item -->
            @endforeach
        </ul>
    </li>
@else
    <li x-data="{ expanded: false }" title="{{ $attributes->get('data-group-title') }}">
        <button
            class="group flex w-full items-center rounded-lg p-2 text-gray-900 transition duration-75 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
            type="button"
            x-on:click="expanded = ! expanded">
            @if ($slot->toHtml() !== '')
                <span
                    class="*:h-5 *:w-5 *:text-gray-500 *:transition *:duration-75 group-hover:*:text-gray-900 dark:*:text-gray-400 dark:group-hover:*:text-white">
                    {{ $slot }}
                </span>
                <span class="ms-3 flex-1 whitespace-nowrap text-left">
                    {{ $attributes->get('data-group-name') }}
                </span>
            @else
                <span class="flex-1 whitespace-nowrap text-left">
                    {{ $attributes->get('data-group-name') }}
                </span>
            @endif
            <svg class="h-6 w-6 transition"
                aria-hidden="true"
                :class="expanded ? 'rotate-180' : ''"
                fill="currentColor"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                    clip-rule="evenodd"></path>
            </svg>
        </button>
        <ul class="space-y-2 py-2"
            x-show="expanded"
            x-collapse>
            @foreach ($menus as $key => $menu)
                <!-- Menu Item -->
                @if (request()->route()->named($menu['data-route-name']))
                    <li title="{{ array_key_exists('data-menu-title', $menu) ? $menu['data-menu-title'] : null }}">
                        <a class="group flex w-full items-center rounded-lg bg-gray-100 p-2 pl-10  font-medium text-gray-900 transition duration-75 dark:bg-gray-700 dark:text-white"
                            href="{{ $menu['data-route-name'] ? route($menu['data-route-name']) : '#' }}">
                            {{ $menu['data-menu-name'] }}
                        </a>
                    </li>
                @else
                    <li title="{{ array_key_exists('data-menu-title', $menu) ? $menu['data-menu-title'] : null }}">
                        <a class="group flex w-full items-center rounded-lg p-2 pl-10  font-medium text-gray-900 transition duration-75 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                            href="{{ $menu['data-route-name'] ? route($menu['data-route-name']) : '#' }}">
                            {{ $menu['data-menu-name'] }}
                        </a>
                    </li>
                @endif
                <!-- End of Menu Item -->
            @endforeach
        </ul>
    </li>
@endif
