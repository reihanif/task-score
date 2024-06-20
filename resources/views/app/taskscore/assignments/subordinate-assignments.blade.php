@extends('layouts.app')

@section('title', 'Create Assignment')

@section('content')
    <div class="col-span-full flex-row items-center justify-between space-y-3 sm:flex sm:space-x-4 sm:space-y-0">
        <div>
            <h5 class="mr-3 font-semibold dark:text-white">Subordinate Assignments</h5>
            <x-breadcrumbs class="mt-2"
                :menus="collect([
                    [
                        'name' => 'Subordinate Assignments',
                        'route' => null,
                    ],
                ])" />
        </div>
    </div>

    <div
        class="border-1 relative col-span-2 overflow-x-hidden rounded-lg border border-gray-200 p-4 dark:border-gray-700 dark:bg-gray-800">
        {{-- <div class="flex-row items-center justify-between space-y-3 sm:flex sm:space-x-4 sm:space-y-0">
            <div>
                <h5 class="mr-3 font-semibold dark:text-white">Subordinate Assignments</h5>
                <p class="text-gray-500 dark:text-gray-400">Manage all your existing subordinate assignment or add a new one
                </p>
            </div>
        </div> --}}

        <div class="grid gap-4 bg-white dark:bg-gray-800 md:grid-cols-2 md:flex-row md:space-y-0">
            <div class="inline-flex gap-2">
                <div class="grow"
                    id="search">
                    <label class="sr-only"
                        for="table-search-subordinate-assignments">Search</label>
                    <div class="relative">
                        <div class="rtl:inset-r-0 pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3">
                            <x-icons.search class="h-4 w-4 text-gray-500 dark:text-gray-400"></x-icons.search>
                        </div>
                        <input
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 ps-10 pt-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                            id="table-search-subordinate-assignments"
                            type="text"
                            placeholder="Search for assignment">
                    </div>
                </div>
                <div>
                    <select
                        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                        id="assignments-resolution-filter"
                        normal-select>
                        <option value=""
                            selected>All Resolution</option>
                        <option value="Resolved">Resolved</option>
                        <option value="Unresolved">Unresolved</option>
                        <option value="Reassigned">Reassigned</option>
                    </select>
                </div>
            </div>
            <div class="order-first grid justify-items-end md:order-last">
                <!-- Modal toggle -->
                <button
                    class="flex items-center justify-center rounded-lg bg-blue-700 px-4 py-2 text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    data-modal-target="create-assignment-modal"
                    data-modal-show="create-assignment-modal"
                    type="button">
                    <x-icons.plus class="-ml-1 mr-1 h-6 w-6">
                    </x-icons.plus>
                    Add Assignment
                </button>
            </div>
        </div>
        <!-- Create Modal -->
        @include('app.taskscore.assignments.modals.create')

        <!-- Table -->
        <div>
            <table
                class="table-clickable w-full text-left text-xs text-gray-500 rtl:text-right dark:text-gray-400 sm:text-sm"
                id="subordinate-assignments-table">
                <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <x-table-head class="whitespace-nowrap px-3 py-3"
                            scope="col">
                            No
                        </x-table-head>
                        <x-table-head class="min-w-60 px-3 py-3"
                            scope="col">
                            Subject
                        </x-table-head>
                        <x-table-head class="whitespace-nowrap px-3 py-3"
                            scope="col">
                            Assignee
                        </x-table-head>
                        <x-table-head class="whitespace-nowrap px-3 py-3"
                            scope="col">
                            Type
                        </x-table-head>
                        <x-table-head class="whitespace-nowrap px-3 py-3"
                            scope="col">
                            Status
                        </x-table-head>
                        <x-table-head class="whitespace-nowrap px-3 py-3"
                            scope="col">
                            Created at
                        </x-table-head>
                        @if (Auth::User()->role == 'superadmin')
                            <x-table-head class="px-3 py-3"
                                data-dt-order="disable"
                                scope="col" />
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($assignments as $key => $assignment)
                        <tr class="cursor-pointer border-b bg-white hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-600"
                            data-href="{{ route('taskscore.assignment.show', $assignment->id) }}">
                            <th class="whitespace-nowrap px-3 py-4 font-medium text-gray-900 dark:text-white"
                                scope="row">
                                {{ $loop->iteration }}
                            </th>
                            <th class="px-3 py-4 font-medium text-gray-900 dark:text-white"
                                scope="row">
                                {{ $assignment->subject }}
                            </th>
                            <td class="whitespace-nowrap px-3 py-4">
                                @foreach ($assignment->tasks->unique('assignee_id') as $task)
                                    @if ($loop->count > 1)
                                        <li>
                                            {{ $task->assignee->name }}
                                        </li>
                                    @else
                                        {{ $task->assignee->name }}
                                    @endif
                                @endforeach
                            </td>
                            <td class="whitespace-nowrap px-3 py-4">
                                {{ $assignment->type }}
                            </td>
                            <td class="whitespace-nowrap px-3 py-4">
                                @if ($assignment->isOpen())
                                    <span
                                        class="me-2 rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                                        Open
                                    </span>
                                @else
                                    <span
                                        class="me-2 rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800 dark:bg-red-900 dark:text-red-300">
                                        Closed
                                    </span>
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-3 py-4">
                                {{ $assignment->created_at->format('d F Y H:i') }}
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
                                                    <a class="block px-4 py-2 text-red-600 hover:bg-gray-100 dark:text-red-500 dark:hover:bg-gray-600 dark:hover:text-red-400"
                                                        data-modal-target="delete-assignment-modal-{{ $assignment->id }}"
                                                        data-modal-show="delete-assignment-modal-{{ $assignment->id }}"
                                                        type="button">Delete</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <x-modals.delete-assignment id="{{ $assignment->id }}"
                                            name="{{ $assignment->subject }}" />
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

@section('script')

@endsection
