@extends('layouts.app')

@section('title', 'Position')

@section('content')
    <div
        class="border-1 relative col-span-2 overflow-x-hidden rounded-lg border border-gray-200 p-4 dark:border-gray-700 dark:bg-gray-800">
        <div class="flex-row items-center justify-between space-y-3 sm:flex sm:space-x-4 sm:space-y-0">
            <div>
                <h5 class="mr-3 font-semibold dark:text-white">Positions</h5>
                <p class="text-gray-500 dark:text-gray-400">Manage all your existing position or add a new one</p>
            </div>
        </div>

        <div
            class="flex-column flex flex-wrap items-end justify-between space-y-4 bg-white pt-4 dark:bg-gray-800 md:flex-row md:space-y-0">
            <div id="search">
                <label class="sr-only"
                    for="table-search-users">Search</label>
                <div class="relative">
                    <div class="rtl:inset-r-0 pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3">
                        <x-icons.search class="h-4 w-4 text-gray-500 dark:text-gray-400"></x-icons.search>
                    </div>
                    <input
                        class="block w-auto rounded-lg border border-gray-300 bg-gray-50 ps-10 pt-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                        id="table-search-positions"
                        type="text"
                        autocomplete="off"
                        placeholder="Search for position">
                </div>
            </div>
            @if (Auth::User()->role == 'superadmin')
                <x-modals.create-position
                    class="flex items-center justify-center rounded-lg bg-blue-700 px-4 py-2 text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    :positions="$superiors">
                </x-modals.create-position>
            @endif
        </div>
        <div>
            <table class="table-clickable w-full text-left text-sm text-gray-500 rtl:text-right dark:text-gray-400"
                id="positions-table">
                <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <x-table-head class="whitespace-nowrap px-3 py-3"
                        scope="col">
                            No
                        </x-table-head>
                        <x-table-head class="whitespace-nowrap px-3 py-3"
                        scope="col">
                            Nama
                        </x-table-head>
                        <x-table-head class="whitespace-nowrap px-3 py-3"
                        scope="col">
                            Total Departments
                        </x-table-head>
                        <x-table-head class="whitespace-nowrap px-3 py-3"
                        scope="col">
                            Created at
                        </x-table-head>
                        <x-table-head class="whitespace-nowrap px-3 py-3"
                        scope="col">
                            Last Updated
                        </x-table-head>

                        @if (Auth::User()->role == 'superadmin')
                            <x-table-head class="px-3 py-3"
                                data-dt-order="disable"
                                scope="col"/>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($positions as $key => $position)
                        <tr class="cursor-pointer border-b bg-white hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-600"
                            data-href="{{ route('positions.show', $position->id) }}">
                            <th class="whitespace-nowrap px-3 py-4 font-medium text-gray-900 dark:text-white"
                                scope="row">
                                {{ $loop->iteration }}
                                {{-- {{ ($positions->currentpage() - 1) * $positions->perpage() + $key + 1 }} --}}
                            </th>
                            <th class="whitespace-nowrap px-3 py-4 font-medium text-gray-900 dark:text-white"
                                scope="row">
                                {{ $position->name }}
                            </th>
                            <td class="px-3 py-4 text-center">
                                {{ $position->departments->count() }}
                            </td>
                            <td class="whitespace-nowrap px-3 py-4">
                                {{ $position->created_at->format('d F Y, H:i') }}
                            </td>
                            <td class="whitespace-nowrap px-3 py-4">
                                {{ $position->updated_at->format('d F Y, H:i') }}
                            </td>
                            @if (Auth::User()->role == 'superadmin')
                                <td class="float-end py-4 pe-2 ps-6">
                                    <div class="flex items-center">
                                        <button
                                            class="table-row-button inline-flex items-center self-center rounded-lg p-2 text-center text-sm font-medium text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-700"
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
                                                <li>
                                                    <a class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                                        data-modal-target="edit-positions-modal-{{ $position->id }}"
                                                        data-modal-show="edit-positions-modal-{{ $position->id }}"
                                                        type="button">Edit</a>
                                                </li>
                                                <li>
                                                    <a class="block px-4 py-2 text-red-600 hover:bg-gray-100 dark:text-red-500 dark:hover:bg-gray-600 dark:hover:text-red-400"
                                                        data-modal-target="delete-positions-modal-{{ $position->id }}"
                                                        data-modal-show="delete-positions-modal-{{ $position->id }}"
                                                        type="button">Delete</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <x-modals.edit-position id="{{ $position->id }}"
                                            name="{{ $position->name }}"
                                            :position="$position"
                                            :positions="$superiors" />
                                        <x-modals.delete-position id="{{ $position->id }}"
                                            name="{{ $position->name }}" />
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
