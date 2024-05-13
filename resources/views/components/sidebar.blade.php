<aside id="sidebar"
    aria-label="Sidebar"
    {{ $attributes }}>
    <div class="h-full overflow-y-auto bg-white px-3 text-sm pb-4 dark:bg-gray-800">
        <ul class="space-y-2 font-medium">

            <x-sidebar-menu data-menu-name="Dashboard"
                data-route-name="homepage"
                data-menu-title="">
                <x-icons.chart-pie />
            </x-sidebar-menu>


            @if (in_array(Auth::User()->role, ['superadmin', 'admin', 'user']))
                @if (Auth::User()->unresolved_assignments->count() > 0)
                    <x-sidebar-menu data-menu-name="My Assignment"
<<<<<<< HEAD
                        data-route-name="taskscore.assignment.my-assignments"
=======
                        data-route-name="taskscore.assignment.unresolved"
>>>>>>> 9d5f96df3cf85817c1ccb721faf5362187b900e3
                        data-badge-content="{{ Auth::User()->unresolved_assignments->count() }}"
                        data-badge-color="blue">
                        <x-icons.person-fill-check />
                    </x-sidebar-menu>
                @else
                    <x-sidebar-menu data-menu-name="My Assignment"
<<<<<<< HEAD
                        data-route-name="taskscore.assignment.my-assignments">
=======
                        data-route-name="taskscore.assignment.unresolved">
>>>>>>> 9d5f96df3cf85817c1ccb721faf5362187b900e3
                        <x-icons.person-fill-check />
                    </x-sidebar-menu>
                @endif

                @if (!Auth::User()->position?->subordinates()->isEmpty())
                    <x-sidebar-menu data-menu-name="Subordinate Assignment"
<<<<<<< HEAD
                        data-route-name="taskscore.assignment.subordinate-assignments">
=======
                        data-route-name="taskscore.assignment.create">
>>>>>>> 9d5f96df3cf85817c1ccb721faf5362187b900e3
                        <x-icons.clipboard-plus-fill />
                    </x-sidebar-menu>
                @endif

                <x-sidebar-expanded-menu data-group-name="Pages"
                    :menu="collect([
                        [
                            'data-menu-name' => 'Home',
                            'data-route-name' => '',
                        ],
                        [
                            'data-menu-name' => 'About',
                            'data-route-name' => '',
                        ],
                    ])">
                    <x-icons.users-group />
                </x-sidebar-expanded-menu>
                <li>
                    <a class="group flex items-center rounded-lg p-2 text-gray-900 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                        href="#">
                        <x-icons.grid
                            class="h-5 w-5 flex-shrink-0 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"></x-icons.grid>
                        <span class="ms-3 flex-1 whitespace-nowrap">Kanban</span>
                        <span
                            class="ms-3 inline-flex items-center justify-center rounded-full bg-gray-100 px-2 text-sm font-medium text-gray-800 dark:bg-gray-700 dark:text-gray-300">Pro</span>
                    </a>
                </li>
            @endif
        </ul>

        @if (in_array(true, [
                Auth::User()->permission?->manage_user,
                Auth::User()->permission?->manage_department,
                Auth::User()->permission?->manage_position,
            ]) && in_array(Auth::User()->role, ['superadmin', 'admin']))
            <ul class="mt-4 space-y-2 border-t border-gray-200 pt-4 font-medium dark:border-gray-700">
                <h5 class="ps-2 text-sm font-semibold uppercase text-gray-500 dark:text-gray-400">
                    MANAGE
                </h5>

                @if (Auth::User()->permission->manage_user)
                    <x-sidebar-menu data-menu-name="Users"
                        data-route-name="users.index">
                        <x-icons.users />
                    </x-sidebar-menu>
                @endif

                @if (Auth::User()->permission->manage_department)
                    <x-sidebar-menu data-menu-name="Departments"
                        data-route-name="departments.index">
                        <x-icons.briefcase />
                    </x-sidebar-menu>
                @endif

                @if (Auth::User()->permission->manage_position)
                    <x-sidebar-expanded-menu data-group-name="Organizations"
                        data-group-title="Organizations management"
                        :menu="collect([
                            [
                                'data-menu-name' => 'Position',
                                'data-route-name' => 'positions.index',
                                'data-menu-title' => 'Position lists inside organizations',
                            ],
                            [
                                'data-menu-name' => 'Hierarchy',
                                'data-route-name' => 'hierarchy',
                                'data-menu-title' => 'Hierarchy organizations',
                            ],
                        ])">
                        <x-icons.users-group />
                    </x-sidebar-expanded-menu>
                @endif
            </ul>
        @endif
    </div>
</aside>
