<div class="space-y-3">
    @if ($task->description)
        <dl>
            <dt class="mb-2 text-sm font-semibold leading-none text-gray-900 dark:text-white">Detail
                Assignment</dt>
            <dd class="text-sm text-gray-600 dark:text-gray-400">
                {{ Str::of($task->description)->toHtmlString }}
            </dd>
        </dl>
    @endif
    <div class="grid space-y-2 md:grid-cols-3">
        <dl class="space-y-2 md:col-span-2">
            <dt class="text-sm font-semibold leading-none text-gray-900 dark:text-white">Due</dt>
            <dd class="text-sm text-gray-600 dark:text-gray-400">
                {{ $task->due->format('d F Y, H:i') . ' ' . '(' . $task->due->diffForHumans() . ')' }}
            </dd>
        </dl>
        @if ($task->isResolved())
            <dl class="space-y-2">
                <dt class="text-sm font-semibold leading-none text-gray-900 dark:text-white">Final Score</dt>
                <dd class="text-sm text-gray-600 dark:text-gray-400">
                    <div class="mt-1 w-full overflow-hidden rounded-full bg-gray-200 dark:bg-gray-700">
                        <div class="{{ $task->score() !== 0 ? 'text-blue-100' : 'text-gray-500 dark:text-gray-400' }} rounded-full bg-blue-600 p-0.5 text-center text-xs font-medium leading-none"
                             style="width: {{ $task->score() <= 100 ? $task->score() : 100 }}%">
                            {{ $task->score() }}%
                        </div>
                    </div>
                </dd>
            </dl>
        @elseif ($task->isSubmitted())
            <dl class="space-y-2">
                <dt class="text-sm font-semibold leading-none text-gray-900 dark:text-white">Possible Score</dt>
                <dd class="text-sm text-gray-600 dark:text-gray-400">
                    <div class="mt-1 w-full overflow-hidden rounded-full bg-gray-200 dark:bg-gray-700">
                        <div class="{{ $task->possibleScore() !== 0 ? 'text-blue-100' : 'text-gray-500 dark:text-gray-400' }} rounded-full bg-gray-400 p-0.5 text-center text-xs font-medium leading-none dark:bg-gray-500"
                             style="width: {{ $task->possibleScore() <= 100 ? $task->possibleScore() : 100 }}%">
                            {{ $task->possibleScore() }}%
                        </div>
                    </div>
                </dd>
            </dl>
        @else
            <dl class="space-y-2">
                <dt class="text-sm font-semibold leading-none text-gray-900 dark:text-white">Possible Score</dt>
                <dd class="text-sm text-gray-600 dark:text-gray-400">
                    <div class="mt-1 w-full overflow-hidden rounded-full bg-gray-200 dark:bg-gray-700">
                        <div class="rounded-full p-0.5 text-center text-xs font-medium leading-none"
                             id="score-bar-{{ $task->id }}"
                             style="width: 0%">
                            0%
                        </div>
                    </div>
                </dd>
            </dl>
        @endif

        @taskmaster
            <!-- Edit Due Button -->
            <div>
                <button class="inline-flex rounded-lg border border-gray-200 bg-white px-3 py-2 text-center text-xs font-medium text-gray-500 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700"
                        data-modal-toggle="edit-task-due-modal-{{ $task->id }}"
                        data-modal-target="edit-task-due-modal-{{ $task->id }}"
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
                    Edit due
                </button>
                @include('app.taskscore.assignments.modals.edit-task-due')
            </div>
        @endtaskmaster
    </div>

    @assignee
        <div class="flex items-center justify-end space-x-2">
            @if (auth()->user()->isTaskAssignee($task->id) && !$task->isResolved())
                @if (!$task->isSubmitted())
                    <button class="inline-flex rounded-lg border border-gray-200 bg-white px-3 py-2 text-center text-xs font-medium text-gray-500 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700"
                            data-modal-target="resolve-assignment-modal-{{ $task->id }}"
                            data-modal-toggle="resolve-assignment-modal-{{ $task->id }}"
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
                    @include('app.taskscore.assignments.modals.resolve', $task)
                @endif

                @if (!$task->hasTimeExtensionRequest())
                    <button class="inline-flex rounded-lg border border-gray-200 bg-white px-3 py-2 text-center text-xs font-medium text-gray-500 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700"
                            data-modal-target="time-extension-modal-{{ $task->id }}"
                            data-modal-toggle="time-extension-modal-{{ $task->id }}"
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
                    @include('app.taskscore.assignments.modals.time-extension', $task)
                @endif
            @endif
        </div>
    @endassignee

    <div class="space-y-3"
         x-data="{ tab: 'submission' }">
        @if ($task->hasTimeExtensionRequest())
            <x-tabs tabs-type="button"
                    :tabs="collect([
                        [
                            'name' => 'Submissions',
                            'route' => 'submission',
                        ],
                        [
                            'name' => 'Time Extension',
                            'route' => 'extension',
                            'badge' => (string) $task->total_time_extension,
                        ],
                    ])" />
        @else
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
        @endif

        <div class="space-y-6 pt-4"
             x-show="tab == 'submission'">
            @include('app.taskscore.assignments.partials.show-submissions', ['task' => $task])
        </div>

        <div class="space-y-4 pt-4"
             x-show="tab == 'extension'">
            @include('app.taskscore.assignments.partials.show-time-extensions', [
                'time_extensions' => $task->time_extensions,
            ])
        </div>
    </div>

</div>
