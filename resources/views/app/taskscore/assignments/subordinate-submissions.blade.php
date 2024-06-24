@extends('layouts.app')

@section('title', 'Create Assignment')

@section('content')
    <div class="col-span-full flex-row items-center justify-between space-y-3 sm:flex sm:space-x-4 sm:space-y-0">
        <div>
            <h5 class="mr-3 font-semibold dark:text-white">Subordinate Submissions</h5>
            <x-breadcrumbs class="mt-2"
                :menus="collect([
                    [
                        'name' => 'Subordinate Submissions',
                        'route' => null,
                    ],
                ])" />
        </div>
    </div>

    <div
        class="border-1 relative col-span-2 overflow-x-hidden rounded-lg border border-gray-200 p-4 dark:border-gray-700 dark:bg-gray-800">

        <div class="grid gap-4 bg-white dark:bg-gray-800 md:grid-cols-2 md:flex-row md:space-y-0">
            <div class="inline-flex gap-2">
                <div class="grow"
                    id="search">
                    <label class="sr-only"
                        for="table-search-subordinate-submissions">Search</label>
                    <div class="relative">
                        <div class="rtl:inset-r-0 pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3">
                            <x-icons.search class="h-4 w-4 text-gray-500 dark:text-gray-400"></x-icons.search>
                        </div>
                        <input
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 ps-10 pt-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                            id="table-search-subordinate-submissions"
                            type="text"
                            placeholder="Search for subject">
                    </div>
                </div>
                <div>
                    <select
                        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                        id="submissions-resolution-filter"
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
            </div>
        </div>

        <!-- Table -->
        <div>
            <table
                class="table-clickable w-full text-left text-xs text-gray-500 rtl:text-right dark:text-gray-400 sm:text-sm"
                id="subordinate-submissions-table">
                <thead class="hidden bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <x-table-head class="px-3 py-3"
                            scope="col">
                            Subject
                        </x-table-head>
                        <x-table-head class="whitespace-nowrap px-3 py-3"
                            scope="col">
                            Assignee
                        </x-table-head>
                        <x-table-head class="whitespace-nowrap px-3 py-3"
                            scope="col">
                            Message
                        </x-table-head>
                        <x-table-head class="max-w-4 whitespace-nowrap px-3 py-3"
                            data-dt-order="disable"
                            scope="col">
                        </x-table-head>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($submissions as $submission)
                        @php
                            $isNotResponsed = is_null($submission->is_approve);
                        @endphp
                        <tr data-href="{{ route('taskscore.assignment.show', $submission->task->assignment->id) }}"
                            @class([
                                'cursor-pointer border-b bg-white hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-600' => !$isNotResponsed,
                                'cursor-pointer border-b bg-gray-100 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-600' => $isNotResponsed,
                            ])>
                            <td @class([
                                'px-3 py-4' => !$isNotResponsed,
                                'px-3 py-4 font-medium text-gray-900 dark:text-white' => $isNotResponsed,
                            ])
                                scope="row">
                                {{ $submission->task->uuid . ' ' . $submission->task->assignment->subject }}
                            </td>
                            <td @class([
                                'whitespace-nowrap px-3 py-4' => !$isNotResponsed,
                                'whitespace-nowrap px-3 py-4 font-medium text-gray-900 dark:text-white' => $isNotResponsed,
                            ])>
                                {{ $submission->task->assignee->name }}
                            </td>
                            <td @class([
                                'whitespace-nowrap px-3 py-4' => !$isNotResponsed,
                                'whitespace-nowrap px-3 py-4 font-medium text-gray-900 dark:text-white' => $isNotResponsed,
                            ])>
                                <div class="max-w-80 truncate">
                                    {{ strip_tags(Str::of($submission->detail)->toHtmlString) }}
                                </div>
                            </td>
                            <td data-sort="{{ $submission->created_at->format('YmdHMs') }}"
                                @class([
                                    'whitespace-nowrap px-3 py-4' => !$isNotResponsed,
                                    'whitespace-nowrap px-3 py-4 font-medium text-gray-900 dark:text-white' => $isNotResponsed,
                                ])>
                                @if ($submission->created_at->isToday())
                                    {{ $submission->created_at->format('H:i') }}
                                @elseif ($submission->created_at->isCurrentYear())
                                    {{ $submission->created_at->format('M d') }}
                                @else
                                    {{ $submission->created_at->format('Y M') }}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('script')

@endsection
