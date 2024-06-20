@extends('layouts.app')

@section('title', $assignment->subject)

@section('content')
    <div class="grid grid-cols-12 gap-4">
        <div class="col-span-full">
            <div class="flex-row items-center justify-between space-y-3 sm:flex sm:space-x-4 sm:space-y-0">
                <div class="w-full space-y-3">
                    <!-- Breadcrumbs if User is Taskmaster of the assignment -->
                    @taskmaster
                        <x-breadcrumbs class="mb-2"
                            :menus="collect([
                                [
                                    'name' => 'Subordinate Assignments',
                                    'route' => route('taskscore.assignment.subordinate-assignments'),
                                ],
                                [
                                    'name' => $assignment->subject,
                                    'route' => null,
                                ],
                            ])" />
                    @endtaskmaster
                    <!-- Breadcrumbs if User is Assignee of the assignment -->
                    @assignee
                        <x-breadcrumbs class="mb-2"
                            :menus="collect([
                                [
                                    'name' => 'My Assignment',
                                    'route' => route('taskscore.assignment.my-assignments'),
                                ],
                                [
                                    'name' => $assignment->subject,
                                    'route' => null,
                                ],
                            ])" />
                    @endassignee

                    <h6 class="text-lg font-semibold dark:text-white">
                        {{ $assignee_task?->uuid . ' ' }}{{ $assignment->subject }}
                    </h6>

                    <!-- Show button if user is a taskmaster -->
                    @taskmaster
                        <div class="grid grid-cols-12 gap-4">
                            <div class="col-span-9 inline-flex w-full space-x-1.5">
                                <div class="inline-flex md:grow">
                                    <!-- Edit Button -->
                                    <div>
                                        <button
                                            class="inline-flex rounded-lg border border-gray-200 bg-white px-3 py-2 text-center text-xs font-medium text-gray-500 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700"
                                            data-modal-target="edit-assignment-modal"
                                            data-modal-show="edit-assignment-modal"
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
                                    <!-- Edit Modal -->
                                    <x-modal id="edit-assignment-modal"
                                        data-title="Edit assignment">
                                        <!-- Modal body -->
                                        <form class="p-4 md:p-5"
                                            x-on:submit="loading = ! loading"
                                            action="{{ route('taskscore.assignment.update', $assignment->id) }}"
                                            method="post"
                                            enctype="multipart/form-data">
                                            @method('put')
                                            @csrf
                                            <div class="mb-5">
                                                <div class="space-y-4">
                                                    <div class="col-span-2">
                                                        <x-forms.input id="input-subject"
                                                            name="subject"
                                                            type="text"
                                                            value="{{ $assignment->subject }}"
                                                            autocomplete="off"
                                                            label="Subject"
                                                            placeholder="Assignment subject"
                                                            state="initial"
                                                            required></x-forms.input>
                                                    </div>
                                                    <div class="col-span-2">
                                                        <x-forms.text-editor name="description"
                                                            value="{{ $assignment->description }}"
                                                            label="Description"
                                                            placeholder="Assignment description and details"
                                                            required>
                                                        </x-forms.text-editor>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex place-content-end">
                                                <button
                                                    class="inline-flex items-center rounded-lg bg-blue-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                                    type="submit">
                                                    Save
                                                </button>
                                            </div>
                                        </form>
                                    </x-modal>
                                </div>


                                <div class="inline-flex space-x-1.5">
                                    @if ($assignment->isOpen())
                                        <!-- Close Button -->
                                        <div>
                                            <button
                                                class="inline-flex rounded-lg border border-gray-200 bg-white px-3 py-2 text-center text-xs font-medium text-gray-500 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700"
                                                data-modal-show="close-assignment-modal-{{ $assignment->id }}"
                                                data-modal-target="close-assignment-modal-{{ $assignment->id }}"
                                                type="button">
                                                <svg class="me-1 h-3.5 w-3.5"
                                                    aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    width="24"
                                                    height="24"
                                                    fill="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path fill-rule="evenodd"
                                                        d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm7.707-3.707a1 1 0 0 0-1.414 1.414L10.586 12l-2.293 2.293a1 1 0 1 0 1.414 1.414L12 13.414l2.293 2.293a1 1 0 0 0 1.414-1.414L13.414 12l2.293-2.293a1 1 0 0 0-1.414-1.414L12 10.586 9.707 8.293Z"
                                                        clip-rule="evenodd" />
                                                </svg>

                                                Close
                                            </button>
                                            <x-modals.close-assignment id="{{ $assignment->id }}"
                                                name="{{ $assignment->subject }}" />
                                        </div>
                                    @endif

                                    @if ($assignment->isClosed())
                                        <!-- Reopen Button -->
                                        <div>
                                            <button
                                                class="inline-flex rounded-lg border border-gray-200 bg-white px-3 py-2 text-center text-xs font-medium text-gray-500 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700"
                                                data-modal-show="reopen-assignment-modal-{{ $assignment->id }}"
                                                data-modal-target="reopen-assignment-modal-{{ $assignment->id }}"
                                                type="button">
                                                Reopen
                                            </button>
                                        </div>
                                        <!-- Reopen assignment modal -->
                                        <div class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden md:inset-0"
                                            id="reopen-assignment-modal-{{ $assignment->id }}"
                                            tabindex="-1">
                                            <form x-on:submit="loading = ! loading"
                                                action="{{ route('taskscore.assignment.open', $assignment->id) }}"
                                                method="post">
                                                @csrf
                                                @method('put')
                                                <div class="relative max-h-full w-full max-w-md p-4">
                                                    <div class="relative rounded-lg bg-white shadow dark:bg-gray-700">
                                                        <button
                                                            class="absolute end-2.5 top-3 ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white"
                                                            data-modal-hide="reopen-assignment-modal-{{ $assignment->id }}"
                                                            type="button">
                                                            <x-icons.close class="h-3 w-3"></x-icons.close>
                                                            <span class="sr-only">Close modal</span>
                                                        </button>
                                                        <div class="p-4 text-center md:p-5">
                                                            <svg class="mx-auto mb-4 h-12 w-12 text-gray-400 dark:text-gray-200"
                                                                aria-hidden="true"
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                fill="none"
                                                                viewBox="0 0 20 20">
                                                                <path stroke="currentColor"
                                                                    stroke-linecap="round"
                                                                    stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                            </svg>
                                                            <h3
                                                                class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                                                                Are you sure you want to
                                                                set {{ $assignment->name }} status to open?</h3>

                                                            <button
                                                                class="inline-flex items-center rounded-lg bg-blue-600 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-red-300 dark:focus:ring-blue-800"
                                                                type="submit">
                                                                Reopen
                                                            </button>
                                                            <button
                                                                class="ms-3 rounded-lg border border-gray-200 bg-white px-5 py-2.5 text-sm font-medium text-gray-900 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700"
                                                                data-modal-hide="reopen-assignment-modal-{{ $assignment->id }}"
                                                                type="button">Cancel</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    @endif

                                    <!-- Reassign Button -->
                                    {{-- <div>
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
                                    </div> -->
                                    @include('app.taskscore.assignments.modals.reassign', $assignees) --}}
                                </div>
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
                    @endtaskmaster
                </div>
            </div>
        </div>

        <!-- Assignment Details -->
        <div class="col-span-full md:order-2 md:col-span-3">
            <div class="grid">
                <div
                    class="relative space-y-3 rounded-lg border border-gray-200 p-4 text-sm dark:border-gray-700 dark:bg-gray-800">
                    <div class="text-gray-500 dark:text-gray-400">
                        <p class="font-medium text-gray-600 dark:text-gray-300">Status</p>
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
                        <p class="font-medium text-gray-600 dark:text-gray-300">Taskmaster</p>
                        <x-popover.user-profile id="taskmaster-{{ $assignment->taskmaster->id }}"
                            :user="$assignment->taskmaster" />

                    </div>
                    <div class="text-gray-500 dark:text-gray-400">
                        <p class="font-medium text-gray-600 dark:text-gray-300">Assignee</p>
                        @foreach ($assignment->tasks->unique('assignee_id') as $task)
                            @if ($loop->count > 1)
                                <li>
                                    <x-popover.user-profile id="assignee-{{ $task->assignee_id }}"
                                        :user="$task->assignee" />
                                </li>
                            @else
                                <x-popover.user-profile id="assignee-{{ $task->assignee_id }}"
                                    :user="$task->assignee" />
                            @endif
                        @endforeach
                    </div>
                    <div class="text-gray-500 dark:text-gray-400">
                        <p class="font-medium text-gray-600 dark:text-gray-300">Category</p>
                        <p>
                            {{ $assignment->type }}
                        </p>
                    </div>
                    <div class="text-gray-500 dark:text-gray-400">
                        <p class="font-medium text-gray-600 dark:text-gray-300">Created at</p>
                        <p>
                            {{ $assignment->created_at->format('d F Y H:i') }}
                        </p>
                    </div>
                    @if ($assignment->created_at->format('d F Y H:i') !== $assignment->updated_at->format('d F Y H:i'))
                        <div class="text-gray-500 dark:text-gray-400">
                            <p class="font-medium text-gray-600 dark:text-gray-300">Last Update at</p>
                            <p>
                                {{ $assignment->updated_at->format('d F Y H:i') }}
                            </p>
                        </div>
                    @endif
                    @if ($assignment->status == 'closed')
                        <div class="text-gray-500 dark:text-gray-400">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-300">Closed at</p>
                            <p>
                                {{ $assignment->closed_at->format('d F Y H:i') }}
                            </p>
                        </div>
                    @endif
                    <div class="text-gray-500 dark:text-gray-400">
                        <p class="font-medium text-gray-600 dark:text-gray-300">Resolution</p>
                        <p>
                            {{ $assignment->resolved_at ? 'Resolved at ' . $assignment->resolved_at->format('d F Y, H:i') : 'Unresolved' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-span-full space-y-4 md:col-span-9">
            <!-- Assignment Description -->
            <div
                class="grid h-auto gap-8 rounded-lg border border-gray-200 p-4 text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                <div class="space-y-2">
                    <h6 class="text-md mr-3 font-semibold dark:text-white">Descriptions</h6>
                    <!-- Assignment Description Area -->
                    <div>
                        <div class="h-fit space-y-4">
                            <!-- Assignment Description -->
                            <div class="space-y-2">
                                <div class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ Str::of($assignment->description)->toHtmlString }}
                                </div>
                            </div>

                            <!-- Assignment Attachments -->
                            @if (count($assignment->attachments) > 0)
                                <div class="space-y-2">
                                    @foreach ($assignment->attachments as $attachment)
                                        <!-- Files -->
                                        <div class="max-w-96 flex w-full items-center rounded-lg border border-gray-200 p-1 dark:border-gray-600"
                                            title="{{ $attachment->name . '.' . $attachment->extension }}">
                                            <div
                                                class="min-w-8 max-w-8 min-h-8 mr-2 flex h-8 max-h-8 w-8 items-center justify-center rounded-lg bg-blue-100 dark:bg-blue-900">
                                                <svg class="h-4 w-4 text-blue-600 dark:text-blue-300 lg:h-4 lg:w-4"
                                                    aria-hidden="true"
                                                    fill="currentColor"
                                                    viewBox="0 0 24 24"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path clip-rule="evenodd"
                                                        fill-rule="evenodd"
                                                        d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0016.5 9h-1.875a1.875 1.875 0 01-1.875-1.875V5.25A3.75 3.75 0 009 1.5H5.625zM7.5 15a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5A.75.75 0 017.5 15zm.75 2.25a.75.75 0 000 1.5H12a.75.75 0 000-1.5H8.25z">
                                                    </path>
                                                    <path
                                                        d="M12.971 1.816A5.23 5.23 0 0114.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 013.434 1.279 9.768 9.768 0 00-6.963-6.963z">
                                                    </path>
                                                </svg>
                                            </div>
                                            <div class="mr-4 sm:truncate">
                                                <p class="text-xs font-semibold text-gray-900 dark:text-white sm:truncate">
                                                    <span>
                                                        {{ $attachment->name . '.' . $attachment->extension }}
                                                    </span>
                                                </p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                                    <span class="uppercase">
                                                        {{ $attachment->extension }},
                                                    </span>
                                                    <span>
                                                        {{ FileSize::bytesToHuman($attachment->size) }}
                                                    </span>
                                                </p>
                                            </div>
                                            <div class="ml-auto flex items-center">
                                                <a class="rounded p-2 hover:bg-gray-100"
                                                    href="{{ Storage::url($attachment->path) }}"
                                                    download="{{ $attachment->name }}">
                                                    <svg class="h-5 w-5 text-gray-500 dark:text-gray-400"
                                                        aria-hidden="true"
                                                        fill="currentColor"
                                                        viewBox="0 0 24 24"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path clip-rule="evenodd"
                                                            fill-rule="evenodd"
                                                            d="M12 2.25a.75.75 0 01.75.75v11.69l3.22-3.22a.75.75 0 111.06 1.06l-4.5 4.5a.75.75 0 01-1.06 0l-4.5-4.5a.75.75 0 111.06-1.06l3.22 3.22V3a.75.75 0 01.75-.75zm-9 13.5a.75.75 0 01.75.75v2.25a1.5 1.5 0 001.5 1.5h13.5a1.5 1.5 0 001.5-1.5V16.5a.75.75 0 011.5 0v2.25a3 3 0 01-3 3H5.25a3 3 0 01-3-3V16.5a.75.75 0 01.75-.75z">
                                                        </path>
                                                    </svg>
                                                    <span class="sr-only">Download</span>
                                                </a>
                                                <!-- <button class="rounded p-2 hover:bg-gray-100"
                                                    type="button">
                                                    <svg class="h-5 w-5 text-gray-500 dark:text-gray-400"
                                                        aria-hidden="true"
                                                        fill="currentColor"
                                                        viewBox="0 0 20 20"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z">
                                                        </path>
                                                    </svg>
                                                    <span class="sr-only">Actions</span>
                                                </button> -->
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Assignment tasks as taskmaster -->
            @taskmaster
                @include('app.taskscore.assignments.partials.show-taskmaster', $assignment)
            @endtaskmaster

            <!-- Assignment tasks as assignee -->
            @assignee
                @include('app.taskscore.assignments.partials.show-assignee', [
                    'assignment' => $assignment,
                    'assignee_task' => $assignee_task,
                ])
            @endassignee
        </div>
    @endsection
