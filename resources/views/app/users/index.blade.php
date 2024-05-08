@extends('layouts.app')

@section('title', 'Users')

@section('content')
    <!-- Filter Dropdown -->
    <div class="z-10 hidden w-72 space-y-3 rounded-lg bg-white p-3 shadow dark:bg-gray-700"
        id="filter-dropdown">
        <div>
            <h6 class="mb-1.5 text-sm font-medium text-gray-900 dark:text-white">Choose position</h6>
            <select
                id="users-position-filter">
                <option value=""
                    selected>All Position</option>
                @foreach ($positions as $position)
                    <option value="{{ $position->name }}">{{ $position->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <h6 class="mb-1.5 text-sm font-medium text-gray-900 dark:text-white">Choose role</h6>
            <select
                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                id="users-role-filter"
                normal-select>
                <option value=""
                    selected>All Role</option>
                <option value="Superadmin">Superadmin</option>
                <option value="Admin">Admin</option>
                <option value="User">User</option>
                <option value="Guest">Guest</option>
            </select>
        </div>
    </div>
    <!-- End of Filter Dropdown -->

    <div
        class="border-1 relative overflow-x-hidden rounded-lg border border-gray-200 p-4 dark:border-gray-700 dark:bg-gray-800">
        <div class="flex-row items-center justify-between space-y-3 sm:flex sm:space-x-4 sm:space-y-0">
            <div>
                <h5 class="mr-3 font-semibold dark:text-white">Users</h5>
                <p class="text-gray-500 dark:text-gray-400">Manage all your existing users or add a new one</p>
            </div>
        </div>

        <div
            class="grid grid-cols-2 space-y-4 bg-white pt-4 dark:bg-gray-800 md:flex-row md:space-y-0">
            <div class="inline-flex gap-2">
                <div id="search" class="grow">
                    <label class="sr-only"
                        for="table-search-users">Search</label>
                    <div class="relative">
                        <div class="rtl:inset-r-0 pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3">
                            <x-icons.search class="h-4 w-4 text-gray-500 dark:text-gray-400"></x-icons.search>
                        </div>
                        <input
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 ps-10 pt-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                            id="table-search-users"
                            type="text"
                            placeholder="Search for users">
                    </div>
                </div>
                <div>
                    <button
                        class="hover:text-primary-700 flex w-full items-center justify-center rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700 md:w-auto"
                        id="filter-dropdown-button"
                        data-dropdown-toggle="filter-dropdown"
                        type="button">
                        <svg class="mr-2 h-4 w-4 text-gray-400"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            viewbox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z"
                                clip-rule="evenodd" />
                        </svg>
                        Filter
                        <svg class="-mr-1 ml-1.5 h-5 w-5"
                            aria-hidden="true"
                            fill="currentColor"
                            viewbox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path clip-rule="evenodd"
                                fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="grid justify-items-end">
                <a class="flex items-center justify-center rounded-lg bg-blue-700 px-4 py-2 text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    href="{{ route('users.create') }}">
                    <svg class="-ml-1 mr-2 h-3.5 w-3.5"
                        aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20"
                        fill="currentColor">
                        <path
                            d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z" />
                    </svg>
                    Add new user
                </a>
            </div>
        </div>
        <div>
            <table class="table-clickable w-full text-left text-sm text-gray-500 rtl:text-right dark:text-gray-400"
                id="users-table">
                <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="px-3 py-3"
                            scope="col">
                            <div class="flex items-center">
                                <span class="grow">
                                    No
                                </span>
                                <span class="ms-2 text-gray-300 dark:text-gray-500">
                                    <svg class="sort-asc h-3 w-3"
                                        aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path fill-rule="evenodd"
                                            d="M5.575 13.729C4.501 15.033 5.43 17 7.12 17h9.762c1.69 0 2.618-1.967 1.544-3.271l-4.881-5.927a2 2 0 0 0-3.088 0l-4.88 5.927Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <svg class="sort-desc h-3 w-3"
                                        aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path fill-rule="evenodd"
                                            d="M18.425 10.271C19.499 8.967 18.57 7 16.88 7H7.12c-1.69 0-2.618 1.967-1.544 3.271l4.881 5.927a2 2 0 0 0 3.088 0l4.88-5.927Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </span>
                            </div>
                        </th>
                        <th class="px-3 py-3"
                            scope="col">
                            <div class="flex items-center">
                                <span class="grow">
                                    Name
                                </span>
                                <span class="ms-2 text-gray-300 dark:text-gray-500">
                                    <svg class="sort-asc h-3 w-3"
                                        aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path fill-rule="evenodd"
                                            d="M5.575 13.729C4.501 15.033 5.43 17 7.12 17h9.762c1.69 0 2.618-1.967 1.544-3.271l-4.881-5.927a2 2 0 0 0-3.088 0l-4.88 5.927Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <svg class="sort-desc h-3 w-3"
                                        aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path fill-rule="evenodd"
                                            d="M18.425 10.271C19.499 8.967 18.57 7 16.88 7H7.12c-1.69 0-2.618 1.967-1.544 3.271l4.881 5.927a2 2 0 0 0 3.088 0l4.88-5.927Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </span>
                            </div>
                        </th>
                        <th class="px-3 py-3"
                            scope="col">
                            <div class="flex items-center">
                                <span class="grow">
                                    Position
                                </span>
                                <span class="ms-2 text-gray-300 dark:text-gray-500">
                                    <svg class="sort-asc h-3 w-3"
                                        aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path fill-rule="evenodd"
                                            d="M5.575 13.729C4.501 15.033 5.43 17 7.12 17h9.762c1.69 0 2.618-1.967 1.544-3.271l-4.881-5.927a2 2 0 0 0-3.088 0l-4.88 5.927Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <svg class="sort-desc h-3 w-3"
                                        aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path fill-rule="evenodd"
                                            d="M18.425 10.271C19.499 8.967 18.57 7 16.88 7H7.12c-1.69 0-2.618 1.967-1.544 3.271l4.881 5.927a2 2 0 0 0 3.088 0l4.88-5.927Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </span>
                            </div>
                        </th>
                        <th class="px-3 py-3"
                            scope="col">
                            <div class="flex items-center">
                                <span class="grow">
                                    Role
                                </span>
                                <span class="ms-2 text-gray-300 dark:text-gray-500">
                                    <svg class="sort-asc h-3 w-3"
                                        aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path fill-rule="evenodd"
                                            d="M5.575 13.729C4.501 15.033 5.43 17 7.12 17h9.762c1.69 0 2.618-1.967 1.544-3.271l-4.881-5.927a2 2 0 0 0-3.088 0l-4.88 5.927Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <svg class="sort-desc h-3 w-3"
                                        aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path fill-rule="evenodd"
                                            d="M18.425 10.271C19.499 8.967 18.57 7 16.88 7H7.12c-1.69 0-2.618 1.967-1.544 3.271l4.881 5.927a2 2 0 0 0 3.088 0l4.88-5.927Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </span>
                            </div>
                        </th>
                        <th class="px-3 py-3"
                            scope="col">
                            <div class="flex items-center">
                                <span class="grow">
                                    Created at
                                </span>
                                <span class="ms-2 text-gray-300 dark:text-gray-500">
                                    <svg class="sort-asc h-3 w-3"
                                        aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path fill-rule="evenodd"
                                            d="M5.575 13.729C4.501 15.033 5.43 17 7.12 17h9.762c1.69 0 2.618-1.967 1.544-3.271l-4.881-5.927a2 2 0 0 0-3.088 0l-4.88 5.927Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <svg class="sort-desc h-3 w-3"
                                        aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path fill-rule="evenodd"
                                            d="M18.425 10.271C19.499 8.967 18.57 7 16.88 7H7.12c-1.69 0-2.618 1.967-1.544 3.271l4.881 5.927a2 2 0 0 0 3.088 0l4.88-5.927Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </span>
                            </div>
                        </th>
                        <th class="px-3 py-3"
                            scope="col">
                            <div class="flex items-center">
                                <span class="grow">
                                    Last Updated
                                </span>
                                <span class="ms-2 text-gray-300 dark:text-gray-500">
                                    <svg class="sort-asc h-3 w-3"
                                        aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path fill-rule="evenodd"
                                            d="M5.575 13.729C4.501 15.033 5.43 17 7.12 17h9.762c1.69 0 2.618-1.967 1.544-3.271l-4.881-5.927a2 2 0 0 0-3.088 0l-4.88 5.927Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <svg class="sort-desc h-3 w-3"
                                        aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path fill-rule="evenodd"
                                            d="M18.425 10.271C19.499 8.967 18.57 7 16.88 7H7.12c-1.69 0-2.618 1.967-1.544 3.271l4.881 5.927a2 2 0 0 0 3.088 0l4.88-5.927Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </span>
                            </div>
                        </th>
                        <th class="px-3 py-3"
                            data-dt-order="disable"
                            scope="col">
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $key => $user)
                        <tr class="cursor-pointer border-b bg-white hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-600"
                            data-href="{{ route('account.settings', $user->id) }}">
                            <th class="max-w-4 whitespace-nowrap px-3 py-4 font-medium text-gray-900 dark:text-white"
                                scope="row">
                                <div>
                                    {{ $loop->iteration }}
                                    {{-- {{ ($users->currentpage() - 1) * $users->perpage() + $key + 1 }} --}}
                                </div>
                            </th>
                            <td class="whitespace-nowrap px-3 py-4 text-gray-900 dark:text-white">
                                <div class="flex">
                                    <div>
                                        <div class="text-base font-semibold">{{ $user->name }}</div>
                                        @if ($user->email)
                                            <div class="font-normal text-gray-500">{{ $user->email }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-3 py-4">
                                @if ($user->position)
                                    <a class="hover:underline"
                                        href="{{ route('positions.show', $user->position->id) }}">
                                        {{ $user->position->name }}
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-3 py-4">
                                <div class="flex items-center">
                                    @if ($user->role == 'guest')
                                        <div class="me-2 h-2.5 w-2.5 rounded-full bg-gray-500"></div>
                                        {{ ucwords($user->role) }}
                                    @elseif ($user->role == 'user')
                                        <div class="me-2 h-2.5 w-2.5 rounded-full bg-blue-500"></div>
                                        {{ ucwords($user->role) }}
                                    @elseif ($user->role == 'admin')
                                        <div class="me-2 h-2.5 w-2.5 rounded-full bg-yellow-500"></div>
                                        {{ ucwords($user->role) }}
                                    @elseif ($user->role == 'superadmin')
                                        <div class="me-2 h-2.5 w-2.5 rounded-full bg-red-500"></div>
                                        {{ ucwords($user->role) }}
                                    @endif
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-3 py-4">
                                {{ $user->created_at->format('d F Y, H:i') }}
                            </td>
                            <td class="whitespace-nowrap px-3 py-4">
                                {{ $user->updated_at->format('d F Y, H:i') }}
                            </td>
                            <td class="flex items-start py-4 pe-2 ps-6">
                                @if (in_array(true, [
                                        Auth::User()->role == 'superadmin',
                                        $user->id !== Auth::User()->id &&
                                        Auth::User()->role == 'admin' &&
                                        !in_array($user->role, ['superadmin', 'admin']),
                                        $user->id !== Auth::User()->id && Auth::User()->role == 'superadmin',
                                    ]))
                                    <div class="w-full">
                                        <button
                                            class="table-row-button float-right inline-flex items-center self-center rounded-lg p-2 text-center text-sm font-medium text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-700"
                                            id="dropdownMenuIconButton{{ $key }}"
                                            data-dropdown-toggle="dropdownDots{{ $key }}"
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
                                        <div class="table-row-button z-10 hidden w-40 divide-y divide-gray-100 rounded-lg bg-white shadow dark:divide-gray-600 dark:bg-gray-700"
                                            id="dropdownDots{{ $key }}">
                                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                                aria-labelledby="dropdownMenuIconButton{{ $key }}">
                                                @if (in_array(true, [
                                                        // superadmin can edit everyone account
                                                        Auth::User()->role == 'superadmin', // Check if logged in user role is superadmin

                                                        // user can't edit their own account
                                                        // admin can edit except user's with admin & superadmin role
                                                        $user->id !== Auth::User()->id &&
                                                        Auth::User()->role == 'admin' &&
                                                        ($user->role !== 'superadmin' || $user->role !== 'admin'), // Check if user in row is not the same as logged in user and logged in user role is admin and user in row role is not superadmin
                                                    ]))
                                                    <li>
                                                        <a class="block cursor-pointer px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                                            type="button"
                                                            href="{{ route('users.edit', $user->id) }}">
                                                            Edit
                                                        </a>
                                                    </li>
                                                @endif
                                                <!-- Only superadmin can delete user, and they can't delete their own account -->
                                                <!-- Check if user in row is not the same as logged in user and logged in user role is superadmin -->
                                                @if ($user->id !== Auth::User()->id && Auth::User()->role == 'superadmin')
                                                    <li>
                                                        <a class="block cursor-pointer px-4 py-2 text-red-600 hover:bg-gray-100 dark:text-red-500 dark:hover:bg-gray-600 dark:hover:text-red-400"
                                                            data-modal-target="delete-users-modal-{{ $user->id }}"
                                                            data-modal-show="delete-users-modal-{{ $user->id }}"
                                                            type="button">Delete</a>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                    @if ($user->id !== Auth::User()->id && Auth::User()->role == 'superadmin')
                                        <!-- Modal Delete toggle -->
                                        <x-modals.delete-user
                                            class="ms-3 font-medium text-red-600 hover:text-red-400 dark:text-red-500 dark:hover:text-red-400"
                                            id="{{ $user->id }}"
                                            name="{{ $user->name }}">
                                            <x-icons.outline-trash-bin class="h-6 w-6"></x-icons.outline-trash-bin>
                                        </x-modals.delete-user>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endsection

    @section('script')
        <script></script>
    @endsection
