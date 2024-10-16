@extends('layouts.app')

@section('title', $department->name)

@section('content')
    <div class="lg:grid lg:grid-cols-12 lg:gap-4">
        <div class="col-span-full flex-row items-center justify-between space-y-3 sm:flex sm:space-x-4 sm:space-y-0">
            <div>
                <h5 class="mr-3 font-semibold dark:text-white">{{ $department->name }} Department</h5>
                <x-breadcrumbs class="mt-2"
                               :menus="collect([
                                   ['name' => 'Departments', 'route' => route('departments.index')],
                                   ['name' => $department->name, 'route' => null],
                               ])" />
            </div>
        </div>

        <div class="col-span-full md:order-2 md:col-span-4">
            <div class="grid">
                <div class="relative space-y-4 rounded-lg border border-gray-200 p-4 dark:border-gray-700 dark:bg-gray-800">
                    <div class="flex-row items-center justify-between space-y-3 sm:flex sm:space-x-4 sm:space-y-0">
                        <div>
                            <h5 class="mr-3 font-semibold dark:text-white">Details</h5>
                        </div>

                        <button class="hidden items-center self-center rounded-lg p-2 text-center text-sm font-medium text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-700 sm:block"
                                id="dropdownMenuIconButton"
                                data-dropdown-toggle="dropdownDots"
                                data-dropdown-placement="bottom-start"
                                type="button">
                            <svg class="h-4 w-4 text-gray-500 dark:text-gray-400"
                                 aria-hidden="true"
                                 xmlns="http://www.w3.org/2000/svg"
                                 fill="currentColor"
                                 viewBox="0 0 4 15">
                                <path
                                      d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                            </svg>
                        </button>
                        <div class="z-10 hidden w-40 divide-y divide-gray-100 rounded-lg bg-white shadow dark:divide-gray-600 dark:bg-gray-700"
                             id="dropdownDots">
                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                aria-labelledby="dropdownMenuIconButton">
                                <li>
                                    <a class="block cursor-pointer px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                       data-modal-target="edit-departments-modal-{{ $department->id }}"
                                       data-modal-toggle="edit-departments-modal-{{ $department->id }}"
                                       type="button">Edit</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <x-modals.edit-department :department="$department"
                                              :positions="$positions" />

                    <div>
                        <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-300">
                            Assignments Summary
                        </p>
                        <div class="rounded-lg bg-gray-50 p-3 dark:bg-gray-700">
                            <div class="grid grid-cols-3 gap-3">
                                <dl
                                    class="flex h-[78px] flex-col items-center justify-center rounded-lg bg-orange-50 dark:bg-gray-600">
                                    <dt
                                        class="mb-1 flex h-8 w-8 items-center justify-center rounded-full bg-orange-100 text-sm font-medium text-orange-600 dark:bg-gray-500 dark:text-orange-300">
                                        {{ $department->unresolved_assignments_count }}
                                    </dt>
                                    <dd class="text-sm font-medium text-orange-600 dark:text-orange-300">Unresolved</dd>
                                </dl>
                                <dl
                                    class="flex h-[78px] flex-col items-center justify-center rounded-lg bg-teal-50 dark:bg-gray-600">
                                    <dt
                                        class="mb-1 flex h-8 w-8 items-center justify-center rounded-full bg-teal-100 text-sm font-medium text-teal-600 dark:bg-gray-500 dark:text-teal-300">
                                        {{ $department->pending_assignments_count }}
                                    </dt>
                                    <dd class="text-sm font-medium text-teal-600 dark:text-teal-300">Pending</dd>
                                </dl>
                                <dl
                                    class="flex h-[78px] flex-col items-center justify-center rounded-lg bg-blue-50 dark:bg-gray-600">
                                    <dt
                                        class="mb-1 flex h-8 w-8 items-center justify-center rounded-full bg-blue-100 text-sm font-medium text-blue-600 dark:bg-gray-500 dark:text-blue-300">
                                        {{ $department->resolved_assignments_count }}
                                    </dt>
                                    <dd class="text-sm font-medium text-blue-600 dark:text-blue-300">Resolved</dd>
                                </dl>
                            </div>
                            <div class="mt-2 space-y-1 border-t border-gray-200 pt-2 dark:border-gray-600"
                                 id="more-details">
                                <dl class="flex items-center justify-between">
                                    <dt class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                        Total assignments in department:
                                    </dt>
                                    <dd
                                        class="inline-flex items-center rounded-md bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-800 dark:bg-gray-600 dark:text-gray-300">
                                        {{ $department->assignments_count }}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>

                    <div class="text-gray-500 dark:text-gray-400">
                        <p class="mb-0.5 text-sm font-medium text-gray-600 dark:text-gray-300">
                            Authorized Position
                        </p>
                        @if (!$department->positions->isEmpty())
                            @if (count($department->positions) > 1)
                                @foreach ($department->positions->sortBy('level') as $position)
                                    <li>
                                        {{ $position->name }}
                                    </li>
                                @endforeach
                            @elseif (count($department->positions) == 1)
                                @foreach ($department->positions->sortBy('level') as $position)
                                    <p>{{ $position->name }}</p>
                                @endforeach
                            @else
                                <p>No authorized position</p>
                            @endif
                        @else
                            <p>No users</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-span-full md:col-span-8 space-y-4">
            <div class="grid gap-3 rounded-lg border border-gray-200 p-4 dark:border-gray-700 dark:bg-gray-800 md:grid-cols-2">
                <div class="space-y-4">
                    <div class="mb-1 items-center"
                         x-data="{ expanded: false }">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-300">
                            SysAssignments Usage
                        </p>
                        <button class="inline-flex items-center text-sm font-medium text-blue-700 hover:underline dark:text-blue-600"
                                type="button"
                                x-on:click="expanded = !expanded">
                            {{ $assignments_radial['start']->format('d M') }} -
                            {{ $assignments_radial['end']->format('d M') }}
                            <svg class="ms-2 h-3 w-3 transition"
                                 aria-hidden="true"
                                 :class="expanded ? 'rotate-180' : ''"
                                 xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 10 6">
                                <path stroke="currentColor"
                                      stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="m1 1 4 4 4-4" />
                            </svg>
                        </button>
                        <div class="relative mt-2"
                             x-show="expanded"
                             x-transition>
                            <div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3">
                                <svg class="h-4 w-4 text-gray-500 dark:text-gray-400"
                                     aria-hidden="true"
                                     xmlns="http://www.w3.org/2000/svg"
                                     fill="currentColor"
                                     viewBox="0 0 20 20">
                                    <path
                                          d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                </svg>
                            </div>
                            <form x-data="{ submit() { $refs.form.submit() } }"
                                  x-ref="form"
                                  action=""
                                  method="GET">
                                <input class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 ps-10 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                       name="daterange"
                                       data-single-mode="false"
                                       type="text"
                                       value="{{ $assignments_radial['start']->format('d F Y') . ' - ' . $assignments_radial['end']->format('d F Y') }}"
                                       autocomplete="off"
                                       x-on:change="submit"
                                       placeholder="Date range"
                                       datepicker
                                       datepicker-predefined-ranges>
                            </form>
                        </div>

                        @include('app.departments.assignments-radial-chart')

                        <div>
                            <div class="rounded-lg bg-gray-50 p-3 dark:bg-gray-700">
                                <div class="space-y-1 border-gray-200 dark:border-gray-600"
                                     id="more-details">
                                    <dl class="flex items-center justify-between">
                                        <dt class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                            Total users in department:
                                        </dt>
                                        <dd
                                            class="inline-flex items-center rounded-md bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-800 dark:bg-gray-600 dark:text-gray-300">
                                            {{ $assignments_radial['total_users'] }}
                                        </dd>
                                    </dl>
                                    <dl class="flex items-center justify-between">
                                        <dt class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                            Total users that has assignments:
                                        </dt>
                                        <dd
                                            class="inline-flex items-center rounded-md bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-800 dark:bg-gray-600 dark:text-gray-300">
                                            {{ $assignments_radial['total_users_has_tasks'] }}
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-300">
                        Total Assignments by User
                    </p>

                    @include('app.departments.assignments-treemap-chart')
                </div>
            </div>

            <div class="relative grid">
                <div class="overflow-x-hidden">
                    <div
                         class="border-1 relative rounded-lg border border-gray-200 p-4 dark:border-gray-700 dark:bg-gray-800">
                        <div class="flex-row items-center justify-between space-y-3 sm:flex sm:space-x-4 sm:space-y-0">
                            <div>
                                <h5 class="mr-3 font-semibold dark:text-white">{{ $department->name }} Users</h5>
                                <p class="text-gray-500 dark:text-gray-400">Manage all users inside
                                    {{ $department->name }}
                                    department </p>
                            </div>
                        </div>

                        <div
                             class="flex-column mt-2 flex flex-wrap items-end justify-between space-y-4 bg-white dark:bg-gray-800 md:flex-row md:space-y-0">
                            <div id="search">
                                <label class="sr-only"
                                       for="table-search-users">Search</label>
                                <div class="relative">
                                    <div
                                         class="rtl:inset-r-0 pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3">
                                        <x-icons.search class="h-4 w-4 text-gray-500 dark:text-gray-400"></x-icons.search>
                                    </div>
                                    <input class="block w-auto rounded-lg border border-gray-300 bg-gray-50 ps-10 pt-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                           data-filter-target="department-users"
                                           data-filter-column="1"
                                           data-filter-smart="true"
                                           type="search"
                                           autocomplete="off"
                                           placeholder="Search for users">
                                </div>
                            </div>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="datatables w-full text-left text-sm text-gray-500 rtl:text-right dark:text-gray-400"
                                   id="department-users"
                                   data-page-length="-1">
                                <thead
                                       class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <x-table-head class="px-3 py-3"
                                                      scope="col">
                                            No
                                        </x-table-head>
                                        <x-table-head class="px-3 py-3"
                                                      scope="col">
                                            Nama
                                        </x-table-head>
                                        <x-table-head class="px-3 py-3"
                                                      scope="col">
                                            Position
                                        </x-table-head>
                                        <x-table-head class="px-3 py-3"
                                                      scope="col">
                                            Last Login
                                        </x-table-head>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($department->users->sortBy('name') as $user)
                                        <tr
                                            class="border-b bg-white hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-600">
                                            <th class="whitespace-nowrap px-6 py-4 font-medium text-gray-900 dark:text-white"
                                                scope="row">
                                                {{ $loop->iteration }}
                                            </th>
                                            <th class="whitespace-nowrap px-6 py-4 font-medium text-gray-900 dark:text-white"
                                                scope="row">
                                                {{ $user->name }}
                                            </th>
                                            <td class="whitespace-nowrap px-6 py-4">
                                                {{ $user->position->name }}
                                            </td>
                                            <td class="whitespace-nowrap px-6 py-4" data-order="{{ $user->last_login_at?->format('YmdHis') }}">
                                                {{ $user->last_login_at?->diffForHumans() ?? '-' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
