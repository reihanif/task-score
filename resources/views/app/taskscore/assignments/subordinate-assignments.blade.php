@extends('layouts.app')

@section('title', 'Create Assignment')

@section('content')
    <div class="col-span-full flex-row items-center justify-between space-y-3 sm:flex sm:space-x-4 sm:space-y-0">
        <div>
            <h5 class="mr-3 font-semibold dark:text-white">Subordinate</h5>
            <x-breadcrumbs class="mt-2"
                           :menus="collect([
                               [
                                   'name' => 'Subordinate',
                                   'route' => null,
                               ],
                           ])" />
        </div>
    </div>

    <div class="col-span-full grid grid-cols-12 gap-4">
        <div class="col-span-full sm:order-2 sm:col-span-3">
            <div class="border-1 max-h-80 relative space-y-4 overflow-x-hidden rounded-lg border border-gray-200 dark:border-gray-700 dark:bg-gray-800">
                    <div class="sticky top-0 bg-white dark:bg-gray-700 pb-2 p-4">
                        <h5 class="mr-3 font-semibold dark:text-white">My Subordinates</h5>
                        <p class="text-gray-500 dark:text-gray-400">Your subordinates list</p>
                    </div>
                    <div class="pt-0 p-4">
                        <ul class="max-w-md divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($assignees as $assignee)
                                <li class="py-3 first:pt-0 last:pb-0 sm:py-4">
                                    <div class="flex items-center space-x-4 rtl:space-x-reverse">
                                        <div class="flex-shrink-0">
                                            <img class="h-8 w-8 rounded-full"
                                                 src="https://ui-avatars.com/api/?name={{ urlencode($assignee->name) }}&background=0D8ABC&color=fff&bold=true"
                                                 title="{{ $assignee->name }}"
                                                 alt="{{ $assignee->name }} image">
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <p class="truncate text-sm font-medium text-gray-900 dark:text-white"
                                               title="{{ $assignee->name }}">
                                                {{ $assignee->name }}
                                            </p>
                                            <p class="truncate text-sm text-gray-500 dark:text-gray-400"
                                               title="{{ $assignee->position?->name }}">
                                                {{ $assignee->position?->name }}
                                            </p>
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <li class="py-3 first:pt-0 last:pb-0 sm:py-4">
                                    <div class="flex items-center space-x-4 rtl:space-x-reverse">
                                        <div class="min-w-0 flex-1">
                                            <p class="truncate text-sm text-gray-900 dark:text-white">
                                                You don't have subordinate
                                            </p>
                                        </div>
                                    </div>
                                </li>
                            @endforelse
                        </ul>
                    </div>
            </div>
        </div>

        <div
             class="border-1 relative col-span-full overflow-x-hidden rounded-lg border border-gray-200 p-4 dark:border-gray-700 dark:bg-gray-800 sm:col-span-9">
            <div class="mb-4 flex-row items-center justify-between space-y-3 sm:flex sm:space-x-4 sm:space-y-0">
                <div>
                    <h5 class="mr-3 font-semibold dark:text-white">Subordinate Assignments</h5>
                    <p class="text-gray-500 dark:text-gray-400">Manage all your subordinate assignments or add a new one</p>
                </div>
            </div>
            <div class="grid gap-4 bg-white dark:bg-gray-800 md:grid-cols-2 md:flex-row md:space-y-0">
                <div class="inline-flex gap-2">
                    <div class="grow">
                        <div class="relative">
                            <div
                                 class="rtl:inset-r-0 pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3">
                                <x-icons.search class="h-4 w-4 text-gray-500 dark:text-gray-400"></x-icons.search>
                            </div>
                            <input class="block w-full rounded-lg border border-gray-300 bg-gray-50 ps-10 pt-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                   data-filter-target="subordinate-assignments-table"
                                   data-filter-column="1"
                                   data-filter-case-insensitive="true"
                                   type="search"
                                   placeholder="Search for assignment">
                        </div>
                    </div>
                    <div>
                        <button class="hover:text-primary-700 flex w-full items-center justify-center rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700 md:w-auto"
                                data-modal-target="filter-modal"
                                data-modal-toggle="filter-modal"
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
                <div class="order-first grid justify-items-end md:order-last">
                    <!-- Modal toggle -->
                    <button class="flex items-center justify-center rounded-lg bg-blue-700 px-4 py-2 text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                            data-modal-target="create-assignment-modal"
                            data-modal-toggle="create-assignment-modal"
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
                <table class="datatables table-clickable w-full text-left text-xs text-gray-500 rtl:text-right dark:text-gray-400 sm:text-sm"
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
                                Category
                            </x-table-head>
                            <x-table-head class="whitespace-nowrap px-3 py-3"
                                          data-dt-order="disable"
                                          scope="col">
                                Assignee
                            </x-table-head>
                            <x-table-head class="whitespace-nowrap px-3 py-3"
                                          data-dt-order="disable"
                                          scope="col">
                                Submission
                            </x-table-head>
                            <x-table-head class="whitespace-nowrap px-3 py-3"
                                          data-dt-order="disable"
                                          scope="col">
                                Time Extension
                            </x-table-head>
                            <x-table-head class="whitespace-nowrap px-3 py-3"
                                          data-dt-order="disable"
                                          scope="col">
                                Due
                            </x-table-head>
                            <x-table-head class="whitespace-nowrap px-3 py-3"
                                          data-dt-order="disable"
                                          scope="col">
                                Score
                            </x-table-head>
                            <x-table-head class="whitespace-nowrap px-3 py-3"
                                          scope="col">
                                Created at
                            </x-table-head>
                            @if (auth()->user()->role == 'superadmin')
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
                                    @if ($assignment->is_recurring)
                                        <span class="inline-block align-middle">
                                            <x-icons.arrow-repeat class="h-4 w-4 text-yellow-500" />
                                        </span>
                                    @endif
                                </th>
                                <td class="whitespace-nowrap px-3 py-4">
                                    {{ $assignment->type }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-4">
                                    <ul class="list-none space-y-3">
                                        @foreach ($assignment->tasks as $task)
                                            <li>
                                                {{ $task->uuid . ' - ' . $task->assignee->name }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td class="whitespace-nowrap px-3 py-4">
                                    <ul class="list-none space-y-3">
                                        @foreach ($assignment->tasks as $task)
                                                <li>
                                                    @if ($task->latestsubmission?->isWaitingApproval())
                                                        <span
                                                              class="inline-flex h-4 w-fit items-center justify-center rounded-full bg-yellow-200 px-1.5 text-xs font-semibold text-yellow-800">
                                                            {{ $task->submission_status }}
                                                        </span>
                                                    @elseif ($task->latestsubmission?->isApproved())
                                                        <span
                                                              class="inline-flex h-4 w-fit items-center justify-center rounded-full bg-green-200 px-1.5 text-xs font-semibold text-green-800">
                                                            {{ $task->submission_status }}
                                                        </span>
                                                    @elseif ($task->latestsubmission?->isRejected())
                                                        <span
                                                              class="inline-flex h-4 w-fit items-center justify-center rounded-full bg-red-200 px-1.5 text-xs font-semibold text-red-800">
                                                            {{ $task->submission_status }}
                                                        </span>
                                                    @else
                                                        <span
                                                              class="inline-flex h-4 w-fit items-center justify-center rounded-full px-1.5 text-xs font-semibold text-gray-800 dark:text-gray-400">
                                                            {{ $task->submission_status }}
                                                        </span>
                                                    @endif
                                                </li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td class="whitespace-nowrap px-3 py-4">
                                    <ul class="list-none space-y-3">
                                        @foreach ($assignment->tasks as $task)
                                                <li>
                                                    @if ($task->latestTimeExtension?->isWaitingApproval())
                                                        <span
                                                              class="inline-flex h-4 w-fit items-center justify-center rounded-full bg-yellow-200 px-1.5 text-xs font-semibold text-yellow-800">
                                                            {{ $task->time_extension_status }}
                                                        </span>
                                                    @elseif ($task->latestTimeExtension?->isApproved())
                                                        <span
                                                              class="inline-flex h-4 w-fit items-center justify-center rounded-full bg-green-200 px-1.5 text-xs font-semibold text-green-800">
                                                            {{ $task->time_extension_status }}
                                                        </span>
                                                    @elseif ($task->latestTimeExtension?->isRejected())
                                                        <span
                                                              class="inline-flex h-4 w-fit items-center justify-center rounded-full bg-red-200 px-1.5 text-xs font-semibold text-red-800">
                                                            {{ $task->time_extension_status }}
                                                        </span>
                                                    @else
                                                        <span
                                                              class="inline-flex h-4 w-fit items-center justify-center rounded-full px-1.5 text-xs font-semibold text-gray-800 dark:text-gray-400">
                                                            {{ $task->time_extension_status }}
                                                        </span>
                                                    @endif
                                                </li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td class="whitespace-nowrap px-3 py-4">
                                    <ul class="list-none space-y-3">
                                        @foreach ($assignment->tasks as $task)
                                                <li>
                                                    {{ $task->due->format('d M Y, H:i') }}
                                                </li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-center">
                                    <ul class="list-none space-y-3">
                                        @foreach ($assignment->tasks as $task)
                                                @if ($task->score == 100)
                                                    <li class="align-items-center flex gap-1">
                                                        {{ $task->score . '%' }}
                                                        <span>
                                                            <svg class="inline-block h-4 w-4"
                                                                 xmlns="http://www.w3.org/2000/svg"
                                                                 viewBox="0 0 448 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                                                <path fill="currentColor"
                                                                      d="M48 128c-17.7 0-32 14.3-32 32s14.3 32 32 32l352 0c17.7 0 32-14.3 32-32s-14.3-32-32-32L48 128zm0 192c-17.7 0-32 14.3-32 32s14.3 32 32 32l352 0c17.7 0 32-14.3 32-32s-14.3-32-32-32L48 320z" />
                                                            </svg>
                                                        </span>
                                                    </li>
                                                @elseif ($task->score > 100)
                                                    <li
                                                        class="align-items-center flex gap-1 text-green-600 dark:text-green-500">
                                                        {{ $task->score . '%' }}
                                                        <span>
                                                            <svg class="inline-block h-4 w-4"
                                                                 xmlns="http://www.w3.org/2000/svg"
                                                                 viewBox="0 0 384 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                                                <path fill="currentColor"
                                                                      d="M214.6 41.4c-12.5-12.5-32.8-12.5-45.3 0l-160 160c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 141.2 160 448c0 17.7 14.3 32 32 32s32-14.3 32-32l0-306.7L329.4 246.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3l-160-160z" />
                                                            </svg>
                                                        </span>
                                                    </li>
                                                @elseif (!$task->isResolved() && $task->score < 100)
                                                    <li>
                                                        -
                                                    </li>
                                                @elseif ($task->score < 100)
                                                    <li
                                                        class="align-items-center flex gap-1 text-red-600 dark:text-red-500">
                                                        {{ $task->score . '%' }}
                                                        <span>
                                                            <svg class="inline-block h-4 w-4"
                                                                 xmlns="http://www.w3.org/2000/svg"
                                                                 viewBox="0 0 384 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                                                <path fill="currentColor"
                                                                      d="M169.4 470.6c12.5 12.5 32.8 12.5 45.3 0l160-160c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L224 370.8 224 64c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 306.7L54.6 265.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l160 160z" />
                                                            </svg>
                                                        </span>
                                                    </li>
                                                @endif
                                        @endforeach
                                    </ul>
                                </td>
                                <td class="whitespace-nowrap px-3 py-4"
                                    data-search="{{ $assignment->created_at->format('Ymd') }}"
                                    data-order="{{ $assignment->created_at->format('YmdHis') }}">
                                    {{ $assignment->created_at->format('d M Y, H:i') }}
                                </td>
                                @if (auth()->user()->role == 'superadmin')
                                    <td class="float-end py-4 pe-2 ps-6">
                                        <div class="flex items-center">
                                            <button class="table-row-button inline-flex items-center self-center rounded-lg p-2 text-center text-sm font-medium text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-700"
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
                                                           data-modal-toggle="delete-assignment-modal-{{ $assignment->id }}"
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
    </div>

    <x-modal id="filter-modal" data-title="Filter">
        <!-- Filter -->
        <div class="z-10 p-3">
            <div class="grid sm:grid-cols-2 gap-2">
                <div class="sm:col-span-2">
                    <h6 class="mb-1.5 text-sm font-medium text-gray-900 dark:text-white">Assignee</h6>
                    <select class="ts-sm"
                            hascaption
                            data-filter-target="subordinate-assignments-table"
                            data-filter-column="3">
                        <option value=""
                                selected>All Assignee</option>
                        @foreach ($assignees as $assignee)
                            <option value="{{ $assignee->name }}" data-caption="{{ $assignee->position?->name }}">{{ $assignee->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <h6 class="mb-1.5 text-sm font-medium text-gray-900 dark:text-white">Submission</h6>
                    <select class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                            data-filter-target="subordinate-assignments-table"
                            data-filter-column="4"
                            normal-select>
                        <option value=""
                                selected>All Submission</option>
                        <option value="-">-</option>
                        <option value="Waiting for approval">Waiting for approval</option>
                        <option value="Rejected">Rejected</option>
                        <option value="Resolved">Resolved</option>
                    </select>
                </div>
                <div>
                    <h6 class="mb-1.5 text-sm font-medium text-gray-900 dark:text-white">Time Extension</h6>
                    <select class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                            data-filter-target="subordinate-assignments-table"
                            data-filter-column="5"
                            normal-select>
                        <option value=""
                                selected>All Time Extension</option>
                        <option value="-">-</option>
                        <option value="Waiting for approval">Waiting for approval</option>
                        <option value="Rejected">Rejected</option>
                        <option value="Resolved">Resolved</option>
                    </select>
                </div>
                <div>
                    <h6 class="mb-1.5 text-sm font-medium text-gray-900 dark:text-white">Created date</h6>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3.5">
                            <svg class="h-4 w-4 text-gray-500 dark:text-gray-400"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor"
                                viewBox="0 0 20 20">
                                <path
                                    d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                            </svg>
                        </div>
                        <input class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 ps-10 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                            type="text"
                            datepicker
                            datepicker-predefined-ranges
                            data-single-mode="false"
                            data-format="DD MMM YYYY"
                            data-reset-button="true"
                            data-position="top"
                            data-filter-target="subordinate-assignments-table"
                            data-filter-column="8"
                            data-filter-range
                            autocomplete="off"
                            placeholder="Select date">
                    </div>
                </div>
                <div>
                    <h6 class="mb-1.5 text-sm font-medium text-gray-900 dark:text-white">Category</h6>
                    <select data-filter-target="subordinate-assignments-table"
                            data-filter-column="2">
                        <option value=""
                                selected>All Category</option>
                        @foreach ($categories as $key => $category)
                            <option value="{{ $category }}" data-order="{{ str_pad($key, 2, '0', STR_PAD_LEFT) }}">{{ $category }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mt-4 text-end">
                <button type="button" data-filter-target="subordinate-assignments-table" data-filter-reset class="px-3 py-2 text-xs font-medium text-center text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Reset</button>
            </div>
        </div>
        <!-- End of Filter -->
    </x-modal>
@endsection
