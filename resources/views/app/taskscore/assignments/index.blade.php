@extends('layouts.app')

@section('title', 'My Assignment')

@section('content')
    <div class="col-span-full flex-row items-center justify-between space-y-3 sm:flex sm:space-x-4 sm:space-y-0">
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

    <div
        class="border-1 relative col-span-2 overflow-x-hidden rounded-lg border border-gray-200 p-4 dark:border-gray-700 dark:bg-gray-800">
        <div class="flex-row items-center justify-between space-y-3 sm:flex sm:space-x-4 sm:space-y-0">
            <div>
                <h5 class="mr-3 font-semibold dark:text-white">Subordinate Assignments</h5>
                <p class="text-gray-500 dark:text-gray-400">Manage all your existing subordinate assignment or add a new one
                </p>
            </div>
        </div>

        <div
            class="flex-column flex flex-wrap items-end justify-between space-y-4 bg-white py-4 dark:bg-gray-800 md:flex-row md:space-y-0">
            <div id="search">
                <label class="sr-only"
                    for="table-search-users">Search</label>
                <div class="relative">
                    <div class="rtl:inset-r-0 pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3">
                        <x-icons.search class="h-4 w-4 text-gray-500 dark:text-gray-400"></x-icons.search>
                    </div>
                    <input
                        class="block w-auto rounded-lg border border-gray-300 bg-gray-50 ps-10 pt-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                        id="table-search-users"
                        type="text"
                        placeholder="Search for assignment">
                </div>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="table-clickable w-full text-left text-sm text-gray-500 rtl:text-right dark:text-gray-400">
                <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="whitespace-nowrap px-6 py-3"
                            scope="col">
                            No
                        </th>
                        <th class="whitespace-nowrap px-6 py-3"
                            scope="col">
                            Subject
                        </th>
                        <th class="whitespace-nowrap px-6 py-3"
                            scope="col">
                            Taskmaster
                        </th>
                        <th class="whitespace-nowrap px-6 py-3"
                            scope="col">
                            Created at
                        </th>
                        <th class="whitespace-nowrap px-6 py-3"
                            scope="col">
                            Deadline
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($assignments as $key => $assignment)
                        <tr class="cursor-pointer border-b bg-white hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-600"
                            data-href="{{ route('taskscore.assignment.show', $assignment->id) }}">
                            <th class="whitespace-nowrap px-6 py-4 font-medium text-gray-900 dark:text-white"
                                scope="row">
                                {{ ($assignments->currentpage() - 1) * $assignments->perpage() + $key + 1 }}
                            </th>
                            <th class="whitespace-nowrap px-6 py-4 font-medium text-gray-900 dark:text-white"
                                scope="row">
                                {{ $assignment->subject }}
                            </th>
                            <td class="whitespace-nowrap px-6 py-4">
                                {{ $assignment->taskmaster->name }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                {{ $assignment->created_at->format('d F Y H:i') }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                {{ $assignment->due->diffForHumans() }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center text-lg"
                                colspan="8">
                                <object class="mx-auto w-full p-10 sm:h-96 sm:w-96 sm:p-0"
                                    data="{{ asset('assets/illustrations/no-data-animate.svg') }}"></object>
                                <div class="mb-10">No data found</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $assignments->links() }}
        </div>
    </div>
@endsection

@section('script')
@endsection
