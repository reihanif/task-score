@extends('layouts.app')

@section('title', $department->name)

@section('content')
    <div class="space-y-4 lg:grid lg:grid-cols-12 lg:gap-4">
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
                <div
                    class="border-1 relative space-y-4 rounded-lg border border-gray-200 p-4 dark:border-gray-700 dark:bg-gray-800">
                    <div class="flex-row items-center justify-between space-y-3 sm:flex sm:space-x-4 sm:space-y-0">
                        <div>
                            <h5 class="mr-3 font-semibold dark:text-white">Details</h5>
                        </div>
                        <button
                            class="hidden items-center self-center rounded-lg p-2 text-center text-sm font-medium text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-700 sm:block"
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
                                        data-modal-show="edit-departments-modal-{{ $department->id }}"
                                        type="button">Edit</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <x-modals.edit-department :department="$department"
                        :positions="$positions" />
                    <div class="text-gray-500 dark:text-gray-400">
                        <p class="mb-1 inline-flex font-medium text-gray-600 dark:text-white">
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

        <div class="relative grid sm:col-span-full md:col-span-8">
            <div class="overflow-x-hidden">
                <div class="border-1 relative rounded-lg border border-gray-200 p-4 dark:border-gray-700 dark:bg-gray-800">
                    <div class="flex-row items-center justify-between space-y-3 sm:flex sm:space-x-4 sm:space-y-0">
                        <div>
                            <h5 class="mr-3 font-semibold dark:text-white">{{ $department->name }} Users</h5>
                            <p class="text-gray-500 dark:text-gray-400">Manage all users inside {{ $department->name }}
                                department </p>
                        </div>
                    </div>

                    <div
                        class="flex-column flex flex-wrap items-end justify-between space-y-4 bg-white py-4 dark:bg-gray-800 md:flex-row md:space-y-0">
                        <div id="search">
                            <label class="sr-only"
                                for="table-search-users">Search</label>
                            <div class="relative">
                                <div
                                    class="rtl:inset-r-0 pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3">
                                    <x-icons.search class="h-4 w-4 text-gray-500 dark:text-gray-400"></x-icons.search>
                                </div>
                                <input
                                    class="block w-auto rounded-lg border border-gray-300 bg-gray-50 ps-10 pt-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                    id="table-search-users"
                                    type="text"
                                    placeholder="Search for department">
                            </div>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-gray-500 rtl:text-right dark:text-gray-400">
                            <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th class="px-6 py-3"
                                        scope="col">
                                        No
                                    </th>
                                    <th class="px-6 py-3"
                                        scope="col">
                                        Nama
                                    </th>
                                    <th class="px-6 py-3"
                                        scope="col">
                                        Username
                                    </th>
                                    <th class="px-6 py-3"
                                        scope="col">
                                        Position
                                    </th>
                                    <th class="px-6 py-3"
                                        scope="col">
                                        Role
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
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
                                            {{ $user->username }}
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4">
                                            {{ $user->position->name }}
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4">
                                            {{ ucwords($user->role) }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center text-lg"
                                            colspan="5">
                                            <object class="mx-auto w-full p-10 sm:h-72 sm:w-72 sm:p-0"
                                                data="{{ asset('assets/illustrations/no-data-animate.svg') }}"></object>
                                            <div class="mb-10">No data found</div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
