<aside id="sidebar"
    aria-label="Sidebar"
    {{ $attributes }}>
    <div class="h-full overflow-y-auto bg-white px-3 pb-4 text-sm dark:bg-gray-800">
        <ul class="space-y-2 font-medium">

            <x-sidebar-menu data-menu-name="Dashboard"
                data-route-name="homepage"
                data-menu-title="">
                <x-icons.chart-pie />
            </x-sidebar-menu>


            @if (in_array(Auth::User()->role, ['superadmin', 'admin', 'user']))
                @if (Auth::User()->unresolvedAssignments()->count() > 0)
                    <x-sidebar-menu data-menu-name="My Assignment"
                        data-route-name="taskscore.assignment.my-assignments"
                        data-badge-content="{{ Auth::User()->unresolvedAssignments()->count() }}"
                        data-badge-color="blue">
                        <x-icons.person-fill-check />
                    </x-sidebar-menu>
                @else
                    <x-sidebar-menu data-menu-name="My Assignment"
                        data-route-name="taskscore.assignment.my-assignments">
                        <x-icons.person-fill-check />
                    </x-sidebar-menu>
                @endif

                @if (!Auth::User()->position?->subordinates()->isEmpty())
                    <x-sidebar-expanded-menu data-group-name="Subordinate"
                        data-group-title="Subordinate assignments"
                        :menu="collect([
                            [
                                'data-menu-name' => 'Assignments',
                                'data-route-name' => 'taskscore.assignment.subordinate-assignments',
                                'data-menu-title' => 'Subordinate assignment lists',
                            ],
                            [
                                'data-menu-name' => 'Submissions',
                                'data-route-name' => 'taskscore.assignment.subordinate-submissions',
                                'data-menu-title' => 'Subordinate assignment submissions',
                            ],
                            [
                                'data-menu-name' => 'Requests',
                                'data-route-name' => '',
                                'data-menu-title' => 'Subordinate assignment time extension requests',
                            ],
                        ])">
                        <x-icons.diagram />
                    </x-sidebar-expanded-menu>
                @endif
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
