@extends('layouts.app')

@section('title', $assignment->subject)

@section('content')
    <div class="grid grid-cols-12 gap-4">
        <div class="col-span-full">
            <div class="flex-row items-center justify-between space-y-3 sm:flex sm:space-x-4 sm:space-y-0">
                <div class="w-full space-y-3">
                    <!-- Breadcrumbs if User is taskmaster of the assignment -->
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


                    <!-- Show button if user is a creator of the assignment -->
                    @creator
                        <div class="grid grid-cols-12 gap-4">
                            <div class="col-span-9 inline-flex w-full space-x-1.5">
                                <div class="inline-flex space-x-2 md:grow">
                                    <!-- Edit Button -->
                                    <div>
                                        <button
                                            class="inline-flex rounded-lg border border-gray-200 bg-white px-3 py-2 text-center text-xs font-medium text-gray-500 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700"
                                            data-modal-target="edit-assignment-modal"
                                            data-modal-toggle="edit-assignment-modal"
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

                                    @include('app.taskscore.assignments.modals.edit-assignments')

                                </div>


                                <div class="inline-flex space-x-1.5">
                                    <!-- Button Space -->
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
                                                data-modal-toggle="delete-assignment-modal-{{ $assignment->id }}"
                                                type="button">Delete</a>
                                        </li>
                                    </ul>
                                </div>
                                <!-- Delete Modal -->
                                <x-modals.delete-assignment id="{{ $assignment->id }}"
                                    name="{{ $assignment->subject }}" />
                            </div>
                        </div>
                    @endcreator
                </div>
            </div>
        </div>

        <!-- Assignment Details -->
        <div class="col-span-full md:order-2 md:col-span-3">
            <div class="grid">
                <div
                    class="relative space-y-3 rounded-lg border border-gray-200 p-4 text-sm dark:border-gray-700 dark:bg-gray-800">
                    <div class="text-gray-500 dark:text-gray-400">
                        <p class="font-medium text-gray-600 dark:text-gray-300">Taskmaster</p>
                        {{ $assignment->taskmaster->name }}
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
                        <p class="font-medium text-gray-600 dark:text-gray-300">Recurring</p>
                        @if ($assignment->is_recurring)
                            <div class="mt-1.5 rounded-lg bg-gray-50 p-3 dark:bg-gray-700">
                                <div class="space-y-1 border-gray-200 dark:border-gray-600">
                                    <dl class="flex items-center justify-between">
                                        <dt class="inline-flex items-center rounded-md bg-blue-100 px-2.5 py-1 text-xs font-medium text-blue-800 dark:bg-blue-700 dark:text-blue-50">
                                            {{ $assignment->recurrence?->pattern }}
                                        </dt>
                                    </dl>
                                </div>
                                @creator
                                    <div class="flex gap-3 mt-2 border-t pt-2">
                                        <dl class="flex flex-col items-center justify-center rounded-lg">
                                            <button type="button" data-modal-target="unset-recurring-modal-{{ $assignment->id }}" data-modal-toggle="unset-recurring-modal-{{ $assignment->id }}" class="text-xs font-medium text-red-600 dark:text-red-500 hover:underline">
                                                Remove Recurrence
                                            </button>
                                        </dl>
                                    </div>

                                    @include('app.taskscore.assignments.modals.unset-recurring')
                                @endcreator
                            </div>
                        @else
                            @creator
                                <button type="button" data-modal-target="set-recurring-modal-{{ $assignment->id }}" data-modal-toggle="set-recurring-modal-{{ $assignment->id }}" class="text-xs font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                    Set as recurring
                                </button>

                                @include('app.taskscore.assignments.modals.set-recurring')
                            @else
                                <p>-</p>
                            @endcreator
                        @endif
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
                    <div class="text-gray-500 dark:text-gray-400">
                        <p class="font-medium text-gray-600 dark:text-gray-300">Created by</p>
                        <p>
                            <x-popover.user-profile id="creator-{{ $assignment->creator_id }}"
                                :user="$assignment->creator" />
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-span-full space-y-4 md:col-span-9">
            <!-- Assignment Description -->
            <div class="h-auto gap-8 rounded-lg border border-gray-200 p-4 text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                <div class="space-y-2">
                    <h6 class="text-md mr-3 font-semibold dark:text-white">Descriptions</h6>
                    <!-- Assignment Description Area -->
                    <div>
                        <div class="h-fit space-y-4">
                            <!-- Assignment Description -->
                            <div class="space-y-2">
                                <div class="break-words text-sm text-gray-600 dark:text-gray-400">
                                    {{ Str::of($assignment->description)->toHtmlString }}
                                </div>
                            </div>

                            <div>
                                <!-- Assignment Attachments -->
                                @if (count($assignment->attachments) > 0)
                                    <div class="space-y-2">
                                        @foreach ($assignment->attachments as $attachment)
                                            <!-- Files -->
                                            <div class="flex items-start gap-1">
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
                                                            href="{{ substr(config('app.asset_url'), 0, -1) . Storage::url($attachment->path) }}"
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
                                                    </div>
                                                </div>
                                                @if (auth()->user()->isCreator($assignment->id))
                                                    <button id="dropdownMenuIconButton" data-dropdown-toggle="dropdown-file-{{ $attachment->id }}" data-dropdown-placement="bottom-start" class="inline-flex self-center items-center p-1.5 text-sm font-medium text-center text-gray-900 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-600" type="button">
                                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 4 15">
                                                        <path d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"/>
                                                        </svg>
                                                    </button>
                                                    <div id="dropdown-file-{{ $attachment->id }}" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-40 dark:bg-gray-700 dark:divide-gray-600">
                                                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200">
                                                        <li>
                                                            <a data-modal-target="remove-attachment-modal-{{ $attachment->id }}" data-modal-toggle="remove-attachment-modal-{{ $attachment->id }}" class="cursor-pointer block px-4 py-2 text-red-600 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-red-500">Delete</a>
                                                        </li>
                                                        </ul>
                                                    </div>
                                                    @include('app.taskscore.assignments.modals.remove-attachment')
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                @creator
                                    <button type="button" data-modal-target="upload-attachment-modal" data-modal-toggle="upload-attachment-modal" class="text-xs font-medium text-blue-600 dark:text-blue-500 hover:underline">Add attachment</button>
                                    @include('app.taskscore.assignments.modals.upload-attachments')
                                @endcreator
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Assignment tasks as taskmaster and creator that is not assignee -->
            @taskmaster('auth()->user()->isCreator(Route::current()->parameters()['assignment']) && !auth()->user()->isAssignee(Route::current()->parameters()['assignment'])')
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
    </div>
@endsection
@section('script')
<script>
    function score(task) {
        const resolvedAt = new Date();
        const due = new Date(task.due);

        const secondsBeforeDue = (due - resolvedAt) / 1000;

        let score;

        if (secondsBeforeDue > 10800) {
            score = 110;
        }
        else if (secondsBeforeDue > 0 && secondsBeforeDue <= 10800) {
            score = 110 - (secondsBeforeDue * 10 / 10800);
        }
        else {
            const secondsAfterDue = Math.abs(secondsBeforeDue);
            if (secondsAfterDue >= 259200) {
                score = 60;
            } else {
                score = 100 - ((secondsAfterDue * 40) / 259200);
            }
        }

        return Math.max(0, score).toFixed(2);
    }

    function updateProgressBar(task) {
        const scoreValue = parseFloat(score(task));
        const scoreBar = document.getElementById(`score-bar-${task.id}`);

        if (scoreBar) {
            const scorePercentage = scoreValue <= 100 ? scoreValue : 100;
            scoreBar.style.width = `${scorePercentage}%`;
            scoreBar.innerText = `${scoreValue}%`;

            if (scoreValue !== 0) {
                scoreBar.classList.add('bg-gray-400', 'dark:bg-gray-500', 'text-blue-100');
                scoreBar.classList.remove('text-gray-500', 'dark:text-gray-400');
            } else {
                scoreBar.classList.add('text-gray-500', 'dark:text-gray-400');
                scoreBar.classList.remove('bg-gray-400', 'dark:bg-gray-500', 'text-blue-100');
            }
        }
    }

    function difficultyOption() {
        return {
            category: '',
            difficulty: '',
            disableBasic: false,
            disableIntermediate: false,
            init() {
                this.$watch('category', (value) => {
                    if (value === 'SP3') {
                        this.difficulty = 'advanced';
                        this.disableBasic = true;
                        this.disableIntermediate = true;
                    } else {
                        this.disableBasic = false;
                        this.disableIntermediate = false;
                    }
                })
            }
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const tasks = @json($assignment->tasks); // Ensure tasks are being passed as an array of objects

        if (Array.isArray(tasks) && tasks.length > 0) {
            // Initial score update
            tasks.forEach(task => {
                updateProgressBar(task);
            });

            // Update scores every second
            setInterval(() => {
                tasks.forEach(task => {
                    updateProgressBar(task);
                });
            }, 1000);
        }
    });
</script>
@endsection
