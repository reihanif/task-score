@if (request()->route()->named(['positions.*', 'hierarchy']))
    <li x-data="{ expanded: true }">
        <button
            class="group flex w-full items-center rounded-lg p-2 text-gray-900 transition duration-75 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
            type="button"
            x-on:click="expanded = ! expanded">
            <span class="*:h-5 *:w-5 *:text-gray-500 *:transition *:duration-75 group-hover:*:text-gray-900 dark:*:text-gray-400 dark:group-hover:*:text-white">
                <x-icons.users-group></x-icons.users-group>
            </span>
            <span class="ml-3 flex-1 whitespace-nowrap text-left">
                Organizations
            </span>
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
            <!-- Menu Item -->
            @if (request()->route()->named('positions.*'))
                <li>
                    <a class="group flex w-full items-center rounded-lg bg-gray-100 p-2 pl-10 text-base font-medium text-gray-900 transition duration-75 dark:bg-gray-700 dark:text-white"
                        href="{{ route('positions.index') }}">
                        Positions
                    </a>
                </li>
            @else
                <li>
                    <a class="group flex w-full items-center rounded-lg p-2 pl-10 text-base font-medium text-gray-900 transition duration-75 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                        href="{{ route('positions.index') }}">
                        Positions
                    </a>
                </li>
            @endif
            <!-- End of Menu Item -->
        </ul>
    </li>
@else
    <li x-data="{ expanded: false }">
        <button
            class="group flex w-full items-center rounded-lg p-2 text-gray-900 transition duration-75 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
            type="button"
            x-on:click="expanded = ! expanded">
            <x-icons.users-group
                class="h-5 w-5 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"></x-icons.users-group>
            <span class="ml-3 flex-1 whitespace-nowrap text-left">Organizations</span>
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
            <li>
                <a class="group flex w-full items-center rounded-lg p-2 pl-10 text-base font-medium text-gray-900 transition duration-75 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                    href="{{ route('positions.index') }}">
                    Positions
                </a>
            </li>
            <li>
                <a class="group flex w-full items-center rounded-lg p-2 pl-10 text-base font-medium text-gray-900 transition duration-75 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                    href="{{ route('hierarchy') }}">
                    Hierarchy
                </a>
            </li>
        </ul>
    </li>
@endif
