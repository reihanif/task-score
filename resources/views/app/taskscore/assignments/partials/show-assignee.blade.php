<div
    class="grid h-auto gap-8 rounded-lg border border-gray-200 p-4 text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
    <div class="space-y-3">
        <dl>
            <dt class="mb-2 text-sm font-semibold leading-none text-gray-900 dark:text-white">Detail
                Assignment</dt>
            <dd class="text-sm text-gray-600 dark:text-gray-400">
                {{ Str::of($assignee_task->description)->toHtmlString }}
            </dd>
        </dl>
        <div class="grid space-y-2 md:grid-cols-3">
            <dl class="space-y-2 md:col-span-2">
                <dt class="text-sm font-semibold leading-none text-gray-900 dark:text-white">Due</dt>
                <dd class="text-sm text-gray-600 dark:text-gray-400">
                    {{ $assignee_task->due->format('d F Y, H:i') . ' ' . '(' . $assignee_task->due->diffForHumans() . ')' }}
                </dd>
            </dl>
            <dl class="space-y-2">
                <dt class="text-sm font-semibold leading-none text-gray-900 dark:text-white">Score</dt>
                <dd class="text-sm text-gray-600 dark:text-gray-400">
                    <div class="mt-1 w-full overflow-hidden rounded-full bg-gray-200 dark:bg-gray-700">
                        <div class="{{ $assignee_task->score() !== 0 ? 'text-blue-100' : 'text-gray-500 dark:text-gray-400' }} rounded-full bg-blue-600 p-0.5 text-center text-xs font-medium leading-none"
                            style="width: {{ $assignee_task->score() <= 100 ? $assignee_task->score() : 100 }}%">
                            {{ $assignee_task->score() }}%
                        </div>
                    </div>
                </dd>
            </dl>
        </div>
        <div class="flex items-center justify-end space-x-2">
            @if (auth()->user()->isTaskAssignee($assignee_task->id) && !$assignee_task->isResolved())
                @if ($assignee_task->isSubmitted())
                    <button
                        class="inline-flex rounded-lg border border-gray-200 bg-white px-3 py-2 text-center text-xs font-medium text-gray-500 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700"
                        data-modal-target="resolve-assignment-modal-{{ $assignee_task->id }}"
                        data-modal-show="resolve-assignment-modal-{{ $assignee_task->id }}"
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
                    @include('app.taskscore.assignments.modals.resolve', $assignee_task)
                @endif

                @if (!$assignee_task->hasTimeExtensionRequest())
                    <button
                        class="inline-flex rounded-lg border border-gray-200 bg-white px-3 py-2 text-center text-xs font-medium text-gray-500 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700"
                        data-modal-target="time-extension-modal-{{ $assignee_task->id }}"
                        data-modal-show="time-extension-modal-{{ $assignee_task->id }}"
                        type="button">
                        <svg class="me-1 h-3.5 w-3.5"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            fill="currentColor"
                            viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z"
                                clip-rule="evenodd" />
                        </svg>
                        Time Extension
                    </button>
                    <!-- Extension Modal -->
                    @include('app.taskscore.assignments.modals.time-extension', $assignee_task)
                @endif
            @endif
        </div>

        <div class="space-y-3"
            x-data="{ tab: 'submission' }">
            <x-tabs tabs-type="button"
                :tabs="collect([
                    [
                        'name' => 'Submissions',
                        'route' => 'submission',
                    ],
                    [
                        'name' => 'Time Extension',
                        'route' => 'extension',
                    ],
                ])" />

            <div class="space-y-6 pt-4"
                x-show="tab == 'submission'">
                @if ($assignee_task->submissions->count() > 0)
                    <div class="ms-4">
                        <ol class="relative space-y-4 border-s border-gray-200 dark:border-gray-700">
                            @foreach ($assignee_task->submissions as $submission)
                                <li class="ms-6">
                                    <span
                                        class="absolute -start-3 flex h-6 w-6 items-center justify-center rounded-full bg-blue-100 ring-8 ring-white dark:bg-blue-900 dark:ring-gray-800">
                                        <img class="min-w-8 h-8 w-8 rounded-full"
                                            src="https://ui-avatars.com/api/?name={{ urlencode($assignee_task->assignee->name) }}&background=0D8ABC&color=fff&bold=true">
                                    </span>
                                    <div
                                        class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-600 dark:bg-gray-700">
                                        <div class="mb-3 items-center justify-between gap-3 sm:flex">
                                            <time
                                                class="min-w-28 mb-1 self-start text-xs font-normal text-gray-400 sm:order-last sm:mb-0">
                                                {{ $submission->created_at->format('d F Y, H:i') }}
                                            </time>
                                            <div class="lex text-sm font-normal text-gray-500 dark:text-gray-300">
                                                {{ $assignee_task->assignee->name }} submitted assignment
                                                <span class="font-semibold text-gray-900 hover:underline dark:text-white"
                                                    >
                                                    {{ $assignee_task->uuid . ' ' }}{{ $assignment->subject }}
                                                </span>
                                            </div>
                                        </div>
                                        <div
                                            class="rounded-lg border border-gray-200 bg-gray-50 p-3 text-xs text-gray-500 dark:border-gray-500 dark:bg-gray-600 dark:text-gray-300">
                                            {{ Str::of($submission->detail)->toHtmlString }}
                                        </div>
                                        <!-- Files -->
                                        @if ($submission->attachments->isNotEmpty())
                                            <div class="mt-2 space-y-2">
                                                @foreach ($submission->attachments as $attachment)
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
                                                            <p
                                                                class="text-xs font-semibold text-gray-900 dark:text-white sm:truncate">
                                                                {{ $attachment->name . '.' . $attachment->extension }}
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
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif

                                        @if ($submission->isWaitingApproval())
                                            <span class="mt-2 text-xs font-normal text-yellow-500 dark:text-yellow-400">
                                                Waiting approval
                                            </span>
                                        @endif
                                    </div>
                                </li>
                                @if ($submission->isApproved())
                                    <li class="ms-6">
                                        <span
                                            class="absolute -start-3 flex h-6 w-6 items-center justify-center rounded-full bg-blue-100 ring-8 ring-white dark:bg-blue-900 dark:ring-gray-800">
                                            <img class="min-w-8 h-8 w-8 rounded-full"
                                                src="https://ui-avatars.com/api/?name={{ urlencode($assignment->taskmaster->name) }}&background=0D8ABC&color=fff&bold=true">
                                        </span>
                                        <div
                                            class="items-center justify-between gap-3 rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-600 dark:bg-gray-700 sm:flex">
                                            <time
                                                class="min-w-28 mb-1 self-start text-xs font-normal text-gray-400 sm:order-last sm:mb-0">
                                                {{ $submission->approved_at->format('d F Y, H:i') }}
                                            </time>
                                            <div class="lex text-sm font-normal text-gray-500 dark:text-gray-300">
                                                Assignment
                                                <span class="font-semibold text-blue-600 hover:underline dark:text-blue-500">
                                                    approved</span>
                                                by {{ $assignment->taskmaster->name }}
                                            </div>
                                        </div>
                                    </li>
                                @elseif ($submission->isNotApproved())
                                    <li class="ms-6">
                                        <span
                                            class="absolute -start-3 flex h-6 w-6 items-center justify-center rounded-full bg-blue-100 ring-8 ring-white dark:bg-blue-900 dark:ring-gray-800">
                                            <img class="min-w-8 h-8 w-8 rounded-full"
                                                src="https://ui-avatars.com/api/?name={{ urlencode($assignment->taskmaster->name) }}&background=0D8ABC&color=fff&bold=true">
                                        </span>
                                        <div
                                            class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-600 dark:bg-gray-700">
                                            <div class="mb-3 items-center justify-between gap-3 sm:flex">
                                                <time
                                                    class="min-w-28 mb-1 self-start text-xs font-normal text-gray-400 sm:order-last sm:mb-0">
                                                    {{ $submission->approved_at->format('d F Y, H:i') }}
                                                </time>
                                                <div class="lex text-sm font-normal text-gray-500 dark:text-gray-300">
                                                    Assignment
                                                    <span class="font-semibold text-red-700 hover:underline dark:text-red-400">
                                                        rejected</span>
                                                    by {{ $assignment->taskmaster->name }}
                                                </div>
                                            </div>
                                            <div
                                                class="rounded-lg border border-red-300 bg-red-50 p-3 text-xs text-red-800 dark:border-red-400 dark:bg-gray-600 dark:text-red-300">
                                                {{ Str::of($submission->approval_detail)->toHtmlString }}
                                            </div>
                                        </div>
                                    </li>
                                @endif
                            @endforeach
                        </ol>
                    </div>
                @else
                    <div class="flex h-8 w-full items-center justify-center text-center text-sm">
                        No submission
                    </div>
                @endif
            </div>

            <div class="pt-4 space-y-4"
                x-show="tab == 'extension'">

                @forelse ($assignee_task->time_extensions as $time_extension)
                    <div class="flex items-start gap-2.5">
                        <img class="h-8 w-8 rounded-full"
                            src="https://ui-avatars.com/api/?name={{ urlencode($assignee_task->assignee->name) }}&background=0D8ABC&color=fff&bold=true"
                            alt="Jese image">
                        <div class="leading-1.5 flex w-full max-w-full flex-col">
                            <div class="flex items-center space-x-2 rtl:space-x-reverse">
                                <span class="text-sm font-semibold text-gray-900 dark:text-white">
                                    {{ $assignee_task->assignee->name }}
                                </span>
                                <span class="text-sm font-normal text-gray-500 dark:text-gray-400">{{ $time_extension->created_at->format('d F Y, H:i') }}</span>
                            </div>
                            <div class="py-2 text-sm font-normal text-gray-600 dark:text-gray-400">
                                {{ Str::of($time_extension->body)->toHtmlString }}
                            </div>
                            @if ($time_extension->isWaitingApproval())
                                <span class="text-sm font-normal text-yellow-500 dark:text-yellow-400">
                                    Waiting approval
                                </span>

                                @include('app.taskscore.assignments.modals.approve-time-extension')
                                @include('app.taskscore.assignments.modals.reject-time-extension')
                            @elseif ($time_extension->isApproved())
                                <span class="text-sm font-normal text-blue-500 dark:text-blue-400">
                                    Approved at {{ $time_extension->approved_at->format('d F Y, H:i') }}
                                </span>
                            @elseif ($time_extension->isNotApproved())
                                <span class="text-sm font-normal text-red-500 dark:text-red-400">
                                    Rejected at {{ $time_extension->approved_at->format('d F Y, H:i') }}
                                </span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="flex h-8 w-full items-center justify-center text-center text-sm">
                        No time extension request
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</div>
