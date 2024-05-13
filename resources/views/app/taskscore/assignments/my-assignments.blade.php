@extends('layouts.app')

@section('title', 'My Assignment')

@section('content')
    <div class="col-span-2 flex-row items-center justify-between space-y-3 sm:flex sm:space-x-4 sm:space-y-0">
        <div>
            <h5 class="mr-3 font-semibold dark:text-white">My Assignment</h5>
            <x-breadcrumbs class="mt-2"
                :menus="collect([
                    [
                        'name' => 'My Assignment',
                        'route' => null,
                    ],
                ])" />
        </div>
    </div>

    <div class="col-span-2 space-y-4"  x-data="{ tab: 'unresolved' }">
        <x-tabs tabs-type="button"
            :tabs="collect([
                [
                    'name' => 'Unresolved',
                    'route' => 'unresolved',
                    'badge' => $unresolved_assignments->count()
                ],
                [
                    'name' => 'Resolved',
                    'route' => 'resolved',
                ],
            ])" />

        <div x-show="tab == 'unresolved'"
            class="border-1 relative col-span-2 overflow-x-hidden rounded-lg border border-gray-200 p-4 dark:border-gray-700 dark:bg-gray-800">
            <div class="flex-row items-center justify-between space-y-3 sm:flex sm:space-x-4 sm:space-y-0">
                <div>
                    <h5 class="mr-3 font-semibold dark:text-white">Unresolved Assignment</h5>
                    <p class="text-gray-500 dark:text-gray-400">Manage all your unresolved assignments
                    </p>
                </div>
            </div>

            <div
                class="flex-column flex flex-wrap items-end justify-between space-y-4 bg-white pt-4 dark:bg-gray-800 md:flex-row md:space-y-0">
                <div id="search">
                    <label class="sr-only"
                        for="table-search-unresolved-assignments">Search</label>
                    <div class="relative">
                        <div class="rtl:inset-r-0 pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3">
                            <x-icons.search class="h-4 w-4 text-gray-500 dark:text-gray-400"></x-icons.search>
                        </div>
                        <input
                            class="block w-auto rounded-lg border border-gray-300 bg-gray-50 ps-10 pt-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                            id="table-search-unresolved-assignments"
                            type="text"
                            placeholder="Search for assignment">
                    </div>
                </div>
            </div>
            <div>
                <table class="table-clickable w-full text-left text-sm text-gray-500 rtl:text-right dark:text-gray-400"
                    id="unresolved-assignments-table">
                    <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <x-table-head class="whitespace-nowrap px-3 py-3"
                                scope="col">
                                No
                            </x-table-head>
                            <x-table-head class="px-3 py-3"
                                scope="col">
                                Subject
                            </x-table-head>
                            <x-table-head class="whitespace-nowrap px-3 py-3"
                                scope="col">
                                Taskmaster
                            </x-table-head>
                            <x-table-head class="whitespace-nowrap px-3 py-3"
                                scope="col">
                                Created at
                            </x-table-head>
                            <x-table-head class="whitespace-nowrap px-3 py-3"
                                scope="col">
                                Due
                            </x-table-head>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($unresolved_assignments as $key => $assignment)
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
                                    {{ $assignment->taskmaster->name }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-4">
                                    {{ $assignment->created_at->format('d F Y H:i') }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-4">
                                    {{ $assignment->due->diffForHumans() }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div x-show="tab == 'resolved'"
            class="border-1 relative overflow-x-hidden rounded-lg border border-gray-200 p-4 dark:border-gray-700 dark:bg-gray-800">
            <div class="flex-row items-center justify-between space-y-3 sm:flex sm:space-x-4 sm:space-y-0">
                <div>
                    <h5 class="mr-3 font-semibold dark:text-white">Resolved Assignment</h5>
                    <p class="text-gray-500 dark:text-gray-400">View all your resolved assignments
                    </p>
                </div>
            </div>

            <div
                class="flex-column flex flex-wrap items-end justify-between space-y-4 bg-white pt-4 dark:bg-gray-800 md:flex-row md:space-y-0">
                <div id="search">
                    <label class="sr-only"
                        for="table-search-resolved-assignments">Search</label>
                    <div class="relative">
                        <div class="rtl:inset-r-0 pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3">
                            <x-icons.search class="h-4 w-4 text-gray-500 dark:text-gray-400"></x-icons.search>
                        </div>
                        <input
                            class="block w-auto rounded-lg border border-gray-300 bg-gray-50 ps-10 pt-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                            id="table-search-resolved-assignments"
                            type="text"
                            placeholder="Search for assignment">
                    </div>
                </div>
            </div>
            <div>
                <table class="table-clickable w-full text-left text-sm text-gray-500 rtl:text-right dark:text-gray-400"
                    id="resolved-assignments-table">
                    <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <x-table-head class="whitespace-nowrap px-3 py-3"
                                scope="col">
                                No
                            </x-table-head>
                            <x-table-head class="px-3 py-3"
                                scope="col">
                                Subject
                            </x-table-head>
                            <x-table-head class="whitespace-nowrap px-3 py-3"
                                scope="col">
                                Taskmaster
                            </x-table-head>
                            <x-table-head class="whitespace-nowrap px-3 py-3"
                                scope="col">
                                Created at
                            </x-table-head>
                            <x-table-head class="whitespace-nowrap px-3 py-3"
                                scope="col">
                                Due
                            </x-table-head>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($resolved_assignments as $key => $assignment)
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
                                    {{ $assignment->taskmaster->name }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-4">
                                    {{ $assignment->created_at->format('d F Y H:i') }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-4">
                                    {{ $assignment->due->diffForHumans() }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@section('script')
@endsection
