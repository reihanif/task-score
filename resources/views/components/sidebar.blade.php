<aside id="sidebar"
    aria-label="Sidebar"
    {{ $attributes }}>
    <div class="h-full overflow-y-auto bg-white px-3 pb-4 dark:bg-gray-800">
        <ul class="space-y-2 font-medium">

            <x-sidebar-menu data-menu-name="Dashboard" data-route-name="homepage">
                <x-icons.chart-pie/>
            </x-sidebar-menu>


            @if (in_array(Auth::User()->role, ['superadmin', 'admin', 'user']))
            <x-sidebar-menu data-menu-name="Created Assignment" data-route-name="taskscore.assignment.create">
                <x-icons.clipboard-plus-fill/>
            </x-sidebar-menu>

            <x-sidebar-menu data-menu-name="My Assignment" data-route-name="taskscore.assignment.index" data-badge-content="3" data-badge-color="blue">
                <x-icons.person-fill-check/>
            </x-sidebar-menu>

                <li x-data="{ expanded: false }">
                    <button
                        class="group flex w-full items-center rounded-lg p-2 text-gray-900 transition duration-75 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                        type="button"
                        x-on:click="expanded = ! expanded">
                        <x-icons.desktop-pc class="h-5 w-5 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"></x-icons.desktop-pc>
                        <span class="ml-3 flex-1 whitespace-nowrap text-left">Pages</span>
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
                                href="#">Home</a>
                        </li>
                        <li>
                            <a class="group flex w-full items-center rounded-lg p-2 pl-10 text-base font-medium text-gray-900 transition duration-75 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                href="#">About</a>
                        </li>
                        <li>
                            <a class="group flex w-full items-center rounded-lg p-2 pl-10 text-base font-medium text-gray-900 transition duration-75 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                href="#">Services</a>
                        </li>
                        <li>
                            <a class="group flex w-full items-center rounded-lg p-2 pl-10 text-base font-medium text-gray-900 transition duration-75 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                href="#">Contact</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a class="group flex items-center rounded-lg p-2 text-gray-900 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                        href="#">
                        <x-icons.grid
                            class="h-5 w-5 flex-shrink-0 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"></x-icons.grid>
                        <span class="ms-3 flex-1 whitespace-nowrap">Kanban</span>
                        <span
                            class="ms-3 inline-flex items-center justify-center rounded-full px-2 text-sm font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">Pro</span>
                    </a>
                </li>
            @endif
        </ul>

        @if (in_array(true, [
                Auth::User()->permission->manage_user,
                Auth::User()->permission->manage_department,
                Auth::User()->permission->manage_position,
            ]) && in_array(Auth::User()->role, ['superadmin', 'admin']))
            <ul class="mt-4 space-y-2 border-t border-gray-200 pt-4 font-medium dark:border-gray-700">
                <h5 class="ps-2 text-sm font-semibold uppercase text-gray-500 dark:text-gray-400">
                    MANAGE
                </h5>

                @if (Auth::User()->permission->manage_user)
                    @if (request()->route()->named('users.index'))
                        <li>
                            <a class="group flex items-center rounded-lg bg-gray-100 p-2 text-gray-900 dark:bg-gray-700 dark:text-white"
                                href="{{ route('users.index') }}">
                                <x-icons.users
                                    class="h-5 w-5 flex-shrink-0 text-gray-500 text-gray-900 transition duration-75 dark:text-gray-400 dark:text-white"></x-icons.users>
                                <span class="ms-3 flex-1 whitespace-nowrap">Users</span>
                            </a>
                        </li>
                    @else
                        <li>
                            <a class="group flex items-center rounded-lg p-2 text-gray-900 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                href="{{ route('users.index') }}">
                                <x-icons.users
                                    class="h-5 w-5 flex-shrink-0 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"></x-icons.users>
                                <span class="ms-3 flex-1 whitespace-nowrap">Users</span>
                            </a>
                        </li>
                    @endif
                @endif

                @if (Auth::User()->permission->manage_department)
                    @if (request()->route()->named('departments.*'))
                        <li>
                            <a class="group flex items-center rounded-lg bg-gray-100 p-2 text-gray-900 dark:bg-gray-700 dark:text-white"
                                href="{{ route('departments.index') }}">
                                <x-icons.briefcase
                                    class="h-5 w-5 flex-shrink-0 text-gray-500 text-gray-900 transition duration-75 dark:text-gray-400 dark:text-white"></x-icons.briefcase>
                                <span class="ms-3 flex-1 whitespace-nowrap">Departments</span>
                            </a>
                        </li>
                    @else
                        <li>
                            <a class="group flex items-center rounded-lg p-2 text-gray-900 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                href="{{ route('departments.index') }}">
                                <x-icons.briefcase
                                    class="h-5 w-5 flex-shrink-0 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"></x-icons.briefcase>
                                <span class="ms-3 flex-1 whitespace-nowrap">Departments</span>
                            </a>
                        </li>
                    @endif
                @endif

                @if (Auth::User()->permission->manage_position)
                    @if (request()->route()->named(['positions.*', 'hierarchy']))
                        <li x-data="{ expanded: true }">
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
                                @if (request()->route()->named('hierarchy'))
                                    <li>
                                        <a class="group flex w-full items-center rounded-lg bg-gray-100 p-2 pl-10 text-base font-medium text-gray-900 transition duration-75 dark:bg-gray-700 dark:text-white"
                                            href="{{ route('hierarchy') }}">
                                            Hierarchy
                                        </a>
                                    </li>
                                @else
                                    <li>
                                        <a class="group flex w-full items-center rounded-lg p-2 pl-10 text-base font-medium text-gray-900 transition duration-75 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                            href="{{ route('hierarchy') }}">
                                            Hierarchy
                                        </a>
                                    </li>
                                @endif
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
                @endif
            </ul>
        @endif
    </div>
</aside>
