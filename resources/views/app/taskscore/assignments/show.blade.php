@extends('layouts.app')

@section('title', $assignment->subject)

@section('content')
    <div class="grid grid-cols-12 gap-4">
        <div class="col-span-full">
            <div class="flex-row items-center justify-between space-y-3 sm:flex sm:space-x-4 sm:space-y-0">
                <div class="w-full space-y-3">
                    <!-- User is Taskmaster of the assignment -->
                    @if (Auth::user()->isTaskmaster())
                        @if ($assignment->hasParent())
                            <x-breadcrumbs class="mb-2"
                                :menus="collect([
                                    [
                                        'name' => 'Assignment',
                                        'route' => route('taskscore.assignment.create'),
                                    ],
                                    [
                                        'name' => $assignment->parent->subject,
                                        'route' => route('taskscore.assignment.show', $assignment->parent_id),
                                    ],
                                    [
                                        'name' => $assignment->subject,
                                        'route' => null,
                                    ],
                                ])" />
                        @else
                            <x-breadcrumbs class="mb-2"
                                :menus="collect([
                                    [
                                        'name' => 'Assignment',
                                        'route' => route('taskscore.assignment.create'),
                                    ],
                                    [
                                        'name' => $assignment->subject,
                                        'route' => null,
                                    ],
                                ])" />
                        @endif
                        <!-- User is Assignee of the assignment -->
                    @elseif (Auth::user()->isAssignee())
                        <!-- Assignment is resolved -->
                        @if ($assignment->isResolved())
                            <x-breadcrumbs class="mb-2"
                                :menus="collect([
                                    [
                                        'name' => 'My Assignment',
                                        'route' => route('taskscore.assignment.resolved'),
                                    ],
                                    [
                                        'name' => $assignment->subject,
                                        'route' => null,
                                    ],
                                ])" />
                            <!-- Assignment is not resolved -->
                        @else
                            <x-breadcrumbs class="mb-2"
                                :menus="collect([
                                    [
                                        'name' => 'My Assignment',
                                        'route' => route('taskscore.assignment.unresolved'),
                                    ],
                                    [
                                        'name' => $assignment->subject,
                                        'route' => null,
                                    ],
                                ])" />
                        @endif
                    @endif
                    <h6 class="text-lg font-bold dark:text-white">{{ $assignment->subject }}</h6>

                    <!-- Button if user is a taskmaster -->
                    @if (Auth::User()->isTaskmaster())
                        <div class="grid grid-cols-12 gap-4">
                            <div class="col-span-9 inline-flex w-full space-x-1.5">
                                <div class="inline-flex md:grow">
                                    <!-- Edit Button -->
                                    <div>
                                        <button
                                            class="inline-flex rounded-lg border border-gray-200 bg-white px-3 py-2 text-center text-xs font-medium text-gray-500 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700"
                                            type="button">
                                            <svg class="me-1 h-3.5 w-3.5"
                                                aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg"
                                                fill="currentColor"
                                                viewBox="0 0 24 24">
                                                <path fill-rule="evenodd"
                                                    d="M11.32 6.176H5c-1.105 0-2 .949-2 2.118v10.588C3 20.052 3.895 21 5 21h11c1.105 0 2-.948 2-2.118v-7.75l-3.914 4.144A2.46 2.46 0 0 1 12.81 16l-2.681.568c-1.75.37-3.292-1.263-2.942-3.115l.536-2.839c.097-.512.335-.983.684-1.352l2.914-3.086Z"
                                                    clip-rule="evenodd" />
                                                <path fill-rule="evenodd"
                                                    d="M19.846 4.318a2.148 2.148 0 0 0-.437-.692 2.014 2.014 0 0 0-.654-.463 1.92 1.92 0 0 0-1.544 0 2.014 2.014 0 0 0-.654.463l-.546.578 2.852 3.02.546-.579a2.14 2.14 0 0 0 .437-.692 2.244 2.244 0 0 0 0-1.635ZM17.45 8.721 14.597 5.7 9.82 10.76a.54.54 0 0 0-.137.27l-.536 2.84c-.07.37.239.696.588.622l2.682-.567a.492.492 0 0 0 .255-.145l4.778-5.06Z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Edit
                                        </button>
                                    </div>
                                </div>
                                @if ($assignment->isResolved() && $assignment->isOpen())
                                    <div class="inline-flex space-x-1.5">
                                        <!-- Approve Button -->
                                        <div>
                                            <button
                                                class="inline-flex rounded-lg border border-gray-200 bg-white px-3 py-2 text-center text-xs font-medium text-gray-500 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700"
                                                data-modal-show="approve-assignment-modal-{{ $assignment->id }}"
                                                data-modal-target="approve-assignment-modal-{{ $assignment->id }}"
                                                type="button">
                                                <svg class="me-1 h-3.5 w-3.5"
                                                    aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    fill="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path d="M9 7V2.221a2 2 0 0 0-.5.365L4.586 6.5a2 2 0 0 0-.365.5H9Z" />
                                                    <path fill-rule="evenodd"
                                                        d="M11 7V2h7a2 2 0 0 1 2 2v16a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V9h5a2 2 0 0 0 2-2Zm4.707 5.707a1 1 0 0 0-1.414-1.414L11 14.586l-1.293-1.293a1 1 0 0 0-1.414 1.414l2 2a1 1 0 0 0 1.414 0l4-4Z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                Approve
                                            </button>
                                            <x-modals.approve-assignment id="{{ $assignment->id }}"
                                                name="{{ $assignment->subject }}" />
                                        </div>

                                        <!-- Reassign Button -->
                                        <div>
                                            <button
                                                class="inline-flex rounded-lg border border-gray-200 bg-white px-3 py-2 text-center text-xs font-medium text-gray-500 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700"
                                                data-modal-target="reassign-assignment-modal"
                                                data-modal-show="reassign-assignment-modal"
                                                type="button">
                                                <svg class="me-1 h-3.5 w-3.5"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    fill="currentColor"
                                                    viewBox="0 0 16 16">
                                                    <path
                                                        d="M5.921 11.9 1.353 8.62a.72.72 0 0 1 0-1.238L5.921 4.1A.716.716 0 0 1 7 4.719V6c1.5 0 6 0 7 8-2.5-4.5-7-4-7-4v1.281c0 .56-.606.898-1.079.62z" />
                                                </svg>
                                                Reassign
                                            </button>
                                            <!-- Reassign Modal -->
                                            <x-modal id="reassign-assignment-modal"
                                                data-title="Reassign assignment">
                                                <!-- Modal body -->
                                                <form class="p-4 md:p-5"
                                                    x-on:submit="loading = ! loading"
                                                    action="{{ route('taskscore.assignment.reassign', $assignment->id) }}"
                                                    method="post"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="mb-5">
                                                        <div class="space-y-4">
                                                            <div
                                                                class="space-y-4 sm:grid sm:grid-cols-2 sm:space-x-4 sm:space-y-0">
                                                                <x-forms.select id="input-assignee"
                                                                    name="assignee"
                                                                    label="Assignee"
                                                                    state="initial"
                                                                    readonly>
                                                                    <option value="{{ $assignment->assigned_to }}"
                                                                        selected>{{ $assignment->assignee->name }}</option>
                                                                </x-forms.select>
                                                                <x-forms.select id="input-category"
                                                                    name="category"
                                                                    label="Category"
                                                                    state="initial"
                                                                    readonly>
                                                                    <option value="{{ $assignment->type }}">
                                                                        {{ $assignment->type }}
                                                                    </option>
                                                                </x-forms.select>
                                                            </div>
                                                            <div class="col-span-2">
                                                                <x-forms.input id="input-subject"
                                                                    name="subject"
                                                                    type="text"
                                                                    autocomplete="off"
                                                                    label="Subject"
                                                                    placeholder="Assignment subject"
                                                                    state="initial"></x-forms.input>
                                                            </div>
                                                            <div class="col-span-2">
                                                                <x-forms.text-editor name="description"
                                                                    label="Description"
                                                                    placeholder="Assignment description and details"
                                                                    required>
                                                                </x-forms.text-editor>
                                                            </div>
                                                            <div class="col-span-2">
                                                                <label
                                                                    class="mb-2 inline-flex gap-1 text-sm font-medium text-gray-900 dark:text-white"
                                                                    for="file">Attachment
                                                                    <button
                                                                        class="text-gray-400 hover:text-gray-900 dark:text-gray-500 dark:hover:text-white"
                                                                        data-tooltip-target="tooltip-default"
                                                                        type="button">
                                                                        <svg class="h-4 w-4"
                                                                            aria-hidden="true"
                                                                            fill="currentColor"
                                                                            viewBox="0 0 20 20"
                                                                            xmlns="http://www.w3.org/2000/svg">
                                                                            <path fill-rule="evenodd"
                                                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                                                                                clip-rule="evenodd"></path>
                                                                        </svg>
                                                                    </button>

                                                                    <div class="tooltip invisible absolute z-10 inline-block rounded-lg bg-gray-900 px-3 py-2 text-sm font-normal text-white opacity-0 shadow-sm transition-opacity duration-300 dark:bg-gray-700"
                                                                        id="tooltip-default"
                                                                        role="tooltip">
                                                                        Attach documents that related to this assignment
                                                                        <div class="tooltip-arrow"
                                                                            data-popper-arrow></div>
                                                                    </div>
                                                                </label>
                                                                <input id="file"
                                                                    name="attachments[]"
                                                                    type="file"
                                                                    multiple
                                                                    max-files="2">
                                                            </div>
                                                            <div class="space-y-4"
                                                                x-data="{ selectedOption: '' }">
                                                                <div>
                                                                    <p
                                                                        class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                                                                        Assignment deadline
                                                                    </p>
                                                                    <ul
                                                                        class="w-full items-center rounded-lg border border-gray-200 bg-white text-sm font-medium text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:flex">
                                                                        <li
                                                                            class="w-full border-b border-gray-200 dark:border-gray-600 sm:border-b-0 sm:border-r">
                                                                            <div class="flex items-center ps-3">
                                                                                <input
                                                                                    class="h-4 w-4 border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-500 dark:bg-gray-600 dark:ring-offset-gray-700 dark:focus:ring-blue-600 dark:focus:ring-offset-gray-700"
                                                                                    id="horizontal-list-radio-license"
                                                                                    type="radio"
                                                                                    value="interval-time"
                                                                                    x-model="selectedOption"
                                                                                    required>
                                                                                <label
                                                                                    class="ms-2 w-full py-3 text-sm font-medium text-gray-900 dark:text-gray-300"
                                                                                    for="horizontal-list-radio-license">Select
                                                                                    by interval</label>
                                                                            </div>
                                                                        <li class="w-full dark:border-gray-600">
                                                                            <div class="flex items-center ps-3">
                                                                                <input
                                                                                    class="h-4 w-4 border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-500 dark:bg-gray-600 dark:ring-offset-gray-700 dark:focus:ring-blue-600 dark:focus:ring-offset-gray-700"
                                                                                    id="horizontal-list-radio-passport"
                                                                                    type="radio"
                                                                                    value="exact-time"
                                                                                    x-model="selectedOption"
                                                                                    required>
                                                                                <label
                                                                                    class="ms-2 w-full py-3 text-sm font-medium text-gray-900 dark:text-gray-300"
                                                                                    for="horizontal-list-radio-passport">Select
                                                                                    exact time</label>
                                                                            </div>
                                                                        </li>
                                                                        </li>
                                                                    </ul>
                                                                </div>

                                                                <!-- Select Timetable -->
                                                                <div class="sm:grid sm:grid-cols-2"
                                                                    x-show="selectedOption !== ''">
                                                                    <template x-if="selectedOption === 'exact-time'">
                                                                        <div
                                                                            class="col-span-full space-y-4 sm:grid sm:grid-cols-2 sm:space-x-4 sm:space-y-0">
                                                                            <x-forms.input class="cursor-pointer"
                                                                                id="input-date"
                                                                                name="date"
                                                                                format="dd/mm/yy"
                                                                                type="date"
                                                                                value="{{ date('Y-m-d') }}"
                                                                                onclick="showPicker()"
                                                                                autocomplete="off"
                                                                                state="initial"
                                                                                label="Date"
                                                                                required />
                                                                            <x-forms.input class="cursor-pointer"
                                                                                id="input-time"
                                                                                name="time"
                                                                                type="time"
                                                                                x-data="{ timeValue: addMinutesFromCurrentTime(60) }"
                                                                                x-bind:value="timeValue"
                                                                                onclick="showPicker()"
                                                                                state="initial"
                                                                                label="Time"
                                                                                required />
                                                                        </div>
                                                                    </template>

                                                                    <template x-if="selectedOption === 'interval-time'">
                                                                        <ul class="col-span-2 mb-5 grid w-full grid-cols-6 gap-2"
                                                                            id="timetable">
                                                                            <li>
                                                                                <input class="peer hidden"
                                                                                    id="10-am"
                                                                                    name="timetable"
                                                                                    type="radio"
                                                                                    value="20"
                                                                                    checked>
                                                                                <label
                                                                                    class="inline-flex w-full cursor-pointer items-center justify-center rounded-lg border border-gray-200 bg-white px-2 py-1 text-center text-sm font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-900 peer-checked:border-blue-700 peer-checked:bg-blue-50 peer-checked:text-blue-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:border-gray-600 dark:hover:bg-gray-600 dark:hover:text-white dark:peer-checked:border-blue-500 dark:peer-checked:bg-blue-900 dark:peer-checked:text-blue-500"
                                                                                    for="10-am">
                                                                                    20 Minutes
                                                                                </label>
                                                                            </li>
                                                                            <li>
                                                                                <input class="peer hidden"
                                                                                    id="10-30-am"
                                                                                    name="timetable"
                                                                                    type="radio"
                                                                                    value="30">
                                                                                <label
                                                                                    class="inline-flex w-full cursor-pointer items-center justify-center rounded-lg border border-gray-200 bg-white px-2 py-1 text-center text-sm font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-900 peer-checked:border-blue-700 peer-checked:bg-blue-50 peer-checked:text-blue-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:border-gray-600 dark:hover:bg-gray-600 dark:hover:text-white dark:peer-checked:border-blue-500 dark:peer-checked:bg-blue-900 dark:peer-checked:text-blue-500"
                                                                                    for="10-30-am">
                                                                                    30 Minutes
                                                                                </label>
                                                                            </li>
                                                                            <li>
                                                                                <input class="peer hidden"
                                                                                    id="11-am"
                                                                                    name="timetable"
                                                                                    type="radio"
                                                                                    value="45">
                                                                                <label
                                                                                    class="inline-flex w-full cursor-pointer items-center justify-center rounded-lg border border-gray-200 bg-white px-2 py-1 text-center text-sm font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-900 peer-checked:border-blue-700 peer-checked:bg-blue-50 peer-checked:text-blue-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:border-gray-600 dark:hover:bg-gray-600 dark:hover:text-white dark:peer-checked:border-blue-500 dark:peer-checked:bg-blue-900 dark:peer-checked:text-blue-500"
                                                                                    for="11-am">
                                                                                    45 Minutes
                                                                                </label>
                                                                            </li>
                                                                            <li>
                                                                                <input class="peer hidden"
                                                                                    id="11-30-am"
                                                                                    name="timetable"
                                                                                    type="radio"
                                                                                    value="60">
                                                                                <label
                                                                                    class="inline-flex w-full cursor-pointer items-center justify-center rounded-lg border border-gray-200 bg-white px-2 py-1 text-center text-sm font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-900 peer-checked:border-blue-700 peer-checked:bg-blue-50 peer-checked:text-blue-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:border-gray-600 dark:hover:bg-gray-600 dark:hover:text-white dark:peer-checked:border-blue-500 dark:peer-checked:bg-blue-900 dark:peer-checked:text-blue-500"
                                                                                    for="11-30-am">
                                                                                    1 Hours
                                                                                </label>
                                                                            </li>
                                                                            <li>
                                                                                <input class="peer hidden"
                                                                                    id="12-am"
                                                                                    name="timetable"
                                                                                    type="radio"
                                                                                    value="120">
                                                                                <label
                                                                                    class="inline-flex w-full cursor-pointer items-center justify-center rounded-lg border border-gray-200 bg-white px-2 py-1 text-center text-sm font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-900 peer-checked:border-blue-700 peer-checked:bg-blue-50 peer-checked:text-blue-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:border-gray-600 dark:hover:bg-gray-600 dark:hover:text-white dark:peer-checked:border-blue-500 dark:peer-checked:bg-blue-900 dark:peer-checked:text-blue-500"
                                                                                    for="12-am">
                                                                                    2 Hours
                                                                                </label>
                                                                            </li>
                                                                            <li>
                                                                                <input class="peer hidden"
                                                                                    id="12-30-pm"
                                                                                    name="timetable"
                                                                                    type="radio"
                                                                                    value="180">
                                                                                <label
                                                                                    class="inline-flex w-full cursor-pointer items-center justify-center rounded-lg border border-gray-200 bg-white px-2 py-1 text-center text-sm font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-900 peer-checked:border-blue-700 peer-checked:bg-blue-50 peer-checked:text-blue-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:border-gray-600 dark:hover:bg-gray-600 dark:hover:text-white dark:peer-checked:border-blue-500 dark:peer-checked:bg-blue-900 dark:peer-checked:text-blue-500"
                                                                                    for="12-30-pm">
                                                                                    3 Hours
                                                                                </label>
                                                                            </li>
                                                                            <li>
                                                                                <input class="peer hidden"
                                                                                    id="1-pm"
                                                                                    name="timetable"
                                                                                    type="radio"
                                                                                    value="240">
                                                                                <label
                                                                                    class="inline-flex w-full cursor-pointer items-center justify-center rounded-lg border border-gray-200 bg-white px-2 py-1 text-center text-sm font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-900 peer-checked:border-blue-700 peer-checked:bg-blue-50 peer-checked:text-blue-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:border-gray-600 dark:hover:bg-gray-600 dark:hover:text-white dark:peer-checked:border-blue-500 dark:peer-checked:bg-blue-900 dark:peer-checked:text-blue-500"
                                                                                    for="1-pm">
                                                                                    4 Hours
                                                                                </label>
                                                                            </li>
                                                                            <li>
                                                                                <input class="peer hidden"
                                                                                    id="1-30-pm"
                                                                                    name="timetable"
                                                                                    type="radio"
                                                                                    value="300">
                                                                                <label
                                                                                    class="inline-flex w-full cursor-pointer items-center justify-center rounded-lg border border-gray-200 bg-white px-2 py-1 text-center text-sm font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-900 peer-checked:border-blue-700 peer-checked:bg-blue-50 peer-checked:text-blue-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:border-gray-600 dark:hover:bg-gray-600 dark:hover:text-white dark:peer-checked:border-blue-500 dark:peer-checked:bg-blue-900 dark:peer-checked:text-blue-500"
                                                                                    for="1-30-pm">
                                                                                    5 Hours
                                                                                </label>
                                                                            </li>
                                                                            <li>
                                                                                <input class="peer hidden"
                                                                                    id="2-pm"
                                                                                    name="timetable"
                                                                                    type="radio"
                                                                                    value="1440">
                                                                                <label
                                                                                    class="inline-flex w-full cursor-pointer items-center justify-center rounded-lg border border-gray-200 bg-white px-2 py-1 text-center text-sm font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-900 peer-checked:border-blue-700 peer-checked:bg-blue-50 peer-checked:text-blue-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:border-gray-600 dark:hover:bg-gray-600 dark:hover:text-white dark:peer-checked:border-blue-500 dark:peer-checked:bg-blue-900 dark:peer-checked:text-blue-500"
                                                                                    for="2-pm">
                                                                                    1 Days
                                                                                </label>
                                                                            </li>
                                                                            <li>
                                                                                <input class="peer hidden"
                                                                                    id="2-30-pm"
                                                                                    name="timetable"
                                                                                    type="radio"
                                                                                    value="2880">
                                                                                <label
                                                                                    class="inline-flex w-full cursor-pointer items-center justify-center rounded-lg border border-gray-200 bg-white px-2 py-1 text-center text-sm font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-900 peer-checked:border-blue-700 peer-checked:bg-blue-50 peer-checked:text-blue-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:border-gray-600 dark:hover:bg-gray-600 dark:hover:text-white dark:peer-checked:border-blue-500 dark:peer-checked:bg-blue-900 dark:peer-checked:text-blue-500"
                                                                                    for="2-30-pm">
                                                                                    2 Days
                                                                                </label>
                                                                            </li>
                                                                            <li>
                                                                                <input class="peer hidden"
                                                                                    id="3-pm"
                                                                                    name="timetable"
                                                                                    type="radio"
                                                                                    value="4320">
                                                                                <label
                                                                                    class="inline-flex w-full cursor-pointer items-center justify-center rounded-lg border border-gray-200 bg-white px-2 py-1 text-center text-sm font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-900 peer-checked:border-blue-700 peer-checked:bg-blue-50 peer-checked:text-blue-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:border-gray-600 dark:hover:bg-gray-600 dark:hover:text-white dark:peer-checked:border-blue-500 dark:peer-checked:bg-blue-900 dark:peer-checked:text-blue-500"
                                                                                    for="3-pm">
                                                                                    3 Days
                                                                                </label>
                                                                            </li>
                                                                            <li>
                                                                                <input class="peer hidden"
                                                                                    id="3-30-pm"
                                                                                    name="timetable"
                                                                                    type="radio"
                                                                                    value="5760">
                                                                                <label
                                                                                    class="inline-flex w-full cursor-pointer items-center justify-center rounded-lg border border-gray-200 bg-white px-2 py-1 text-center text-sm font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-900 peer-checked:border-blue-700 peer-checked:bg-blue-50 peer-checked:text-blue-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:border-gray-600 dark:hover:bg-gray-600 dark:hover:text-white dark:peer-checked:border-blue-500 dark:peer-checked:bg-blue-900 dark:peer-checked:text-blue-500"
                                                                                    for="3-30-pm">
                                                                                    4 Days
                                                                                </label>
                                                                            </li>
                                                                        </ul>
                                                                    </template>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="flex place-content-end">
                                                        <button
                                                            class="inline-flex items-center rounded-lg bg-blue-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                                            type="submit">
                                                            Reassign
                                                        </button>
                                                    </div>
                                                </form>
                                            </x-modal>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Dropdown Menu -->
                            <div class="col-span-3 inline-flex flex-row-reverse">
                                <button
                                    class="rounded-lg border border-gray-200 p-2 text-center text-sm font-medium text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-700"
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
                                <div class="table-row-button z-10 hidden w-40 divide-y divide-gray-100 rounded-lg bg-white shadow dark:divide-gray-600 dark:bg-gray-700"
                                    id="dropdownDots">
                                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                        aria-labelledby="dropdownMenuIconButton">
                                        <li>
                                            <!-- Delete Button -->
                                            <a class="block cursor-pointer px-4 py-2 text-red-600 hover:bg-gray-100 dark:text-red-500 dark:hover:bg-gray-600 dark:hover:text-red-400"
                                                data-modal-target="delete-assignment-modal-{{ $assignment->id }}"
                                                data-modal-show="delete-assignment-modal-{{ $assignment->id }}"
                                                type="button">Delete</a>
                                        </li>
                                    </ul>
                                </div>
                                <!-- Delete Modal -->
                                <x-modals.delete-assignment id="{{ $assignment->id }}"
                                    name="{{ $assignment->subject }}" />
                            </div>
                        </div>
                    @endif

                    <!-- Button if user is an assignee -->
                    @if (!$assignment->isResolved() && Auth::User()->isAssignee())
                        <div>
                            <!-- Resolve Button -->
                            <button
                                class="inline-flex rounded-lg border border-gray-200 bg-white px-3 py-2 text-center text-xs font-medium text-gray-500 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700"
                                data-modal-target="resolve-assignment-modal"
                                data-modal-show="resolve-assignment-modal"
                                type="button">
                                <svg class="me-1 h-3.5 w-3.5"
                                    aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M9 2a1 1 0 0 0-1 1H6a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2h-2a1 1 0 0 0-1-1H9Zm1 2h4v2h1a1 1 0 1 1 0 2H9a1 1 0 0 1 0-2h1V4Zm5.707 8.707a1 1 0 0 0-1.414-1.414L11 14.586l-1.293-1.293a1 1 0 0 0-1.414 1.414l2 2a1 1 0 0 0 1.414 0l4-4Z"
                                        clip-rule="evenodd" />
                                </svg>
                                Resolve
                            </button>
                            <!-- Resolve Modal -->
                            <x-modal id="resolve-assignment-modal"
                                data-title="Resolve assignment">
                                <!-- Modal body -->
                                <form class="p-4 md:p-5"
                                    x-on:submit="loading = ! loading"
                                    action="{{ route('taskscore.assignment.resolve', $assignment->id) }}"
                                    method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('put')
                                    <div class="mb-5">
                                        <div class="space-y-4">
                                            <div class="col-span-2">
                                                <x-forms.text-editor name="resolution"
                                                    label="Description"
                                                    placeholder="Resolution description and details"
                                                    required>
                                                </x-forms.text-editor>
                                            </div>
                                            <div class="col-span-2">
                                                <label
                                                    class="mb-2 inline-flex gap-1 text-sm font-medium text-gray-900 dark:text-white"
                                                    for="file">Attachment
                                                    <button
                                                        class="text-gray-400 hover:text-gray-900 dark:text-gray-500 dark:hover:text-white"
                                                        data-tooltip-target="tooltip-default"
                                                        type="button">
                                                        <svg class="h-4 w-4"
                                                            aria-hidden="true"
                                                            fill="currentColor"
                                                            viewBox="0 0 20 20"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd"
                                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                    </button>

                                                    <div class="tooltip invisible absolute z-10 inline-block rounded-lg bg-gray-900 px-3 py-2 text-sm font-normal text-white opacity-0 shadow-sm transition-opacity duration-300 dark:bg-gray-700"
                                                        id="tooltip-default"
                                                        role="tooltip">
                                                        Attach documents that related to this assignment
                                                        <div class="tooltip-arrow"
                                                            data-popper-arrow></div>
                                                    </div>
                                                </label>
                                                <input id="file"
                                                    name="attachments[]"
                                                    type="file"
                                                    required
                                                    multiple>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex place-content-end">
                                        <button
                                            class="inline-flex items-center rounded-lg bg-blue-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                            type="submit">
                                            Submit
                                        </button>
                                    </div>
                                </form>
                            </x-modal>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Assignment Details -->
        <div class="col-span-full md:order-2 md:col-span-3">
            <div class="grid">
                <div
                    class="border-1 relative space-y-4 rounded-lg border border-gray-200 p-4 text-sm dark:border-gray-700 dark:bg-gray-800">
                    @if ($assignment->hasParent())
                        <div class="text-gray-500 dark:text-gray-400">
                            <p class="font-medium uppercase text-gray-600 dark:text-gray-300">Related to</p>
                            <a class="hover:underline"
                                href="{{ route('taskscore.assignment.show', $assignment->parent_id) }}">{{ $assignment->parent->subject }}
                            </a>
                        </div>
                    @endif
                    <div class="text-gray-500 dark:text-gray-400">
                        <p class="font-medium uppercase text-gray-600 dark:text-gray-300">Status</p>
                        <p class="mt-1">
                            @if ($assignment->status == 'open')
                                <span
                                    class="me-2 rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                                    {{ ucfirst($assignment->status) }}
                                </span>
                            @elseif ($assignment->status == 'reassigned')
                                <span
                                    class="me-2 rounded-full bg-yellow-100 px-2.5 py-0.5 text-xs font-medium text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300">
                                    {{ ucfirst($assignment->status) }}
                                </span>
                            @elseif ($assignment->status == 'closed')
                                <span
                                    class="me-2 rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800 dark:bg-red-900 dark:text-red-300">
                                    {{ ucfirst($assignment->status) }}
                                </span>
                            @endif
                        </p>
                    </div>
                    <div class="text-gray-500 dark:text-gray-400">
                        <p class="font-medium uppercase text-gray-600 dark:text-gray-300">Due</p>
                        <p>
                            {{ $assignment->due->format('d F Y H:i') . ' ' . '(' . $assignment->due->diffForHumans() . ')' }}
                        </p>
                    </div>
                    <div class="text-gray-500 dark:text-gray-400">
                        <p class="font-medium uppercase text-gray-600 dark:text-gray-300">Taskmaster</p>
                        <x-popover.user-profile id="taskmaster-{{ $assignment->taskmaster->id }}"
                            :user="$assignment->taskmaster" />

                    </div>
                    <div class="text-gray-500 dark:text-gray-400">
                        <p class="font-medium uppercase text-gray-600 dark:text-gray-300">Assignee</p>
                        <x-popover.user-profile id="assignee-{{ $assignment->assignee->id }}"
                            :user="$assignment->assignee" />
                    </div>
                    <div class="text-gray-500 dark:text-gray-400">
                        <p class="font-medium uppercase text-gray-600 dark:text-gray-300">Category</p>
                        <p>
                            {{ $assignment->type }}
                        </p>
                    </div>
                    <div class="text-gray-500 dark:text-gray-400">
                        <p class="font-medium uppercase text-gray-600 dark:text-gray-300">Created at</p>
                        <p>
                            {{ $assignment->created_at->format('d F Y H:i') }}
                        </p>
                    </div>
                    @if ($assignment->created_at->format('d F Y H:i') !== $assignment->updated_at->format('d F Y H:i'))
                        <div class="text-gray-500 dark:text-gray-400">
                            <p class="font-medium uppercase text-gray-600 dark:text-gray-300">Last Update at</p>
                            <p>
                                {{ $assignment->updated_at->format('d F Y H:i') }}
                            </p>
                        </div>
                    @endif
                    @if ($assignment->status == 'closed')
                        <div class="text-gray-500 dark:text-gray-400">
                            <p class="text-sm font-medium uppercase text-gray-600 dark:text-gray-300">Closed at</p>
                            <p>
                                {{ $assignment->closed_at->format('d F Y H:i') }}
                            </p>
                        </div>
                    @endif
                    <div class="text-gray-500 dark:text-gray-400">
                        <p class="font-medium uppercase text-gray-600 dark:text-gray-300">Resolution</p>
                        <p>
                            {{ $assignment->resolved_at ? 'Resolved at ' . $assignment->resolved_at->format('d F Y, H:i') : 'Unresolved' }}
                        </p>
                    </div>
                    @if ($assignment->isResolved())
                        <div class="text-gray-500 dark:text-gray-400">
                            <p class="font-medium uppercase text-gray-600 dark:text-gray-300">Score</p>
                            <div class="mt-1 w-full rounded-full bg-gray-200 dark:bg-gray-700">
                                <div class="rounded-full bg-blue-600 p-0.5 text-center text-xs font-medium leading-none text-blue-100"
                                    style="width: {{ $assignment->score() <= 100 ? $assignment->score() : 100 }}%">
                                    {{ $assignment->score() }}%
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Assignment Description and Resolution -->
        <div class="col-span-full md:col-span-9">
            <div class="grid gap-4">
                <!-- Assignment Description Area -->
                <div
                    class="border-1 h-auto rounded-lg border border-gray-200 text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                    <div class="h-fit space-y-8 p-4">
                        <!-- Assignment Description -->
                        <div class="space-y-2">
                            <h6 class="mr-3 text-sm font-bold dark:text-white">Detail and descriptions</h6>
                            <div class="text-sm text-gray-600 dark:text-gray-400">
                                {{ Str::of($assignment->description)->toHtmlString }}
                            </div>
                        </div>

                        <!-- Assignment Attachments -->
                        @if (count($assignment->attachments) > 0)
                            <div class="space-y-2">
                                <h6 class="mr-3 text-sm font-bold dark:text-white">Attachments</h6>
                                <ul class="divide-y divide-gray-100 rounded-md border border-gray-200 dark:divide-gray-700 dark:border-gray-700"
                                    role="list">
                                    @foreach ($assignment->attachments as $attachment)
                                        <li class="flex items-center justify-between py-4 pl-4 pr-5 text-sm leading-6"
                                            title="{{ $attachment->name . '.' . $attachment->extension }}">
                                            <div class="flex w-0 flex-1 items-center">
                                                <svg class="h-5 w-5 flex-shrink-0 text-gray-400"
                                                    aria-hidden="true"
                                                    viewBox="0 0 20 20"
                                                    fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M15.621 4.379a3 3 0 00-4.242 0l-7 7a3 3 0 004.241 4.243h.001l.497-.5a.75.75 0 011.064 1.057l-.498.501-.002.002a4.5 4.5 0 01-6.364-6.364l7-7a4.5 4.5 0 016.368 6.36l-3.455 3.553A2.625 2.625 0 119.52 9.52l3.45-3.451a.75.75 0 111.061 1.06l-3.45 3.451a1.125 1.125 0 001.587 1.595l3.454-3.553a3 3 0 000-4.242z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                <div class="ml-4 flex min-w-0 flex-1 gap-2">
                                                    <span
                                                        class="truncate font-medium">{{ $attachment->name . '.' . $attachment->extension }}</span>
                                                    <span
                                                        class="flex-shrink-0 text-gray-400">{{ FileSize::bytesToHuman($attachment->size) }}</span>
                                                </div>
                                            </div>
                                            <div class="ml-4 flex-shrink-0">
                                                <a class="font-medium text-blue-600 hover:text-blue-500"
                                                    href="{{ Storage::url($attachment->path) }}"
                                                    download="{{ $attachment->name }}">Download</a>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>


                <!-- Assignment Resolution Area -->
                @if ($assignment->isResolved())
                    <div
                        class="border-1 h-auto rounded-lg border border-gray-200 text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                        <div class="h-fit space-y-8 p-4">

                            <!-- Assignment Resolution -->
                            <div class="space-y-2">
                                <h6 class="mr-3 text-sm font-bold dark:text-white">Resolution</h6>
                                <div class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ Str::of($assignment->resolution)->toHtmlString }}
                                </div>
                            </div>

                            <!-- Assignment Resolution Files -->
                            @if (count($assignment->files) > 0)
                                <div class="space-y-2">
                                    <h6 class="mr-3 text-sm font-bold dark:text-white">Resolution Files</h6>
                                    <ul class="divide-y divide-gray-100 rounded-md border border-gray-200 dark:divide-gray-700 dark:border-gray-700"
                                        role="list">
                                        @foreach ($assignment->files as $file)
                                            <li class="flex items-center justify-between py-4 pl-4 pr-5 text-sm leading-6"
                                                title="{{ $file->name . '.' . $file->extension }}">
                                                <div class="flex w-0 flex-1 items-center">
                                                    <svg class="h-5 w-5 flex-shrink-0 text-gray-400"
                                                        aria-hidden="true"
                                                        viewBox="0 0 20 20"
                                                        fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M15.621 4.379a3 3 0 00-4.242 0l-7 7a3 3 0 004.241 4.243h.001l.497-.5a.75.75 0 011.064 1.057l-.498.501-.002.002a4.5 4.5 0 01-6.364-6.364l7-7a4.5 4.5 0 016.368 6.36l-3.455 3.553A2.625 2.625 0 119.52 9.52l3.45-3.451a.75.75 0 111.061 1.06l-3.45 3.451a1.125 1.125 0 001.587 1.595l3.454-3.553a3 3 0 000-4.242z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    <div class="ml-4 flex min-w-0 flex-1 gap-2">
                                                        <span
                                                            class="truncate font-medium">{{ $file->name . '.' . $file->extension }}</span>
                                                        <span
                                                            class="flex-shrink-0 text-gray-400">{{ FileSize::bytesToHuman($file->size) }}</span>
                                                    </div>
                                                </div>
                                                <div class="ml-4 flex-shrink-0">
                                                    <a class="font-medium text-blue-600 hover:text-blue-500"
                                                        href="{{ Storage::url($file->path) }}"
                                                        download="{{ $file->name }}">Download</a>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <!-- End of Assignment Resolution Files -->
                        </div>
                    </div>
                @endif

                <!-- Related Assignment Area -->
                @if ($assignment->hasChilds())
                    <div class="space-y-3">
                        <h6 class="mr-3 text-sm font-bold dark:text-white">Reassignments :</h6>

                        @foreach ($assignment->childs as $child)
                            <div
                                class="border-1 h-auto rounded-lg border border-gray-200 text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                                <div class="h-fit space-y-1 p-4 text-sm text-gray-500 dark:text-gray-400">
                                    <a class="font-semibold text-gray-800 hover:text-blue-600 hover:underline dark:text-white"
                                        href="{{ route('taskscore.assignment.show', $child->id) }}">
                                        {{ $child->subject }}
                                    </a>
                                    <p>
                                        Created at : {{ $child->created_at->format('d F Y H:i') }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
                <!-- End of Related Assignment Area -->
            </div>
        </div>
        <!-- End of Assignment Description and Resolution -->
    </div>
@endsection
