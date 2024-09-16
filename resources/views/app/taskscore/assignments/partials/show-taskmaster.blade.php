@foreach ($assignment->tasks as $task)
    <div class="h-auto rounded-lg border border-gray-200 p-4 text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
         x-data="{ expanded: {{ auth()->user()->isTaskAssignee($task->id) ||auth()->user()->isTaskmaster($assignment->id) }} }">
        <div class="space-y-3">
            <dl>
                <dt>
                    <button class="mb-2 flex w-full justify-between text-left font-semibold text-blue-600 dark:text-blue-400"
                            x-on:click="expanded = ! expanded">
                        <div>
                            {{ $task->uuid }}
                        </div>
                        <!-- Chevron Icons -->
                        <svg class="h-6 w-6 transition"
                             aria-hidden="true"
                             :class="expanded ? 'rotate-180' : ''"
                             fill="currentColor"
                             viewBox="0 0 20 20"
                             xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                  clip-rule="evenodd">
                            </path>
                        </svg>
                        <!-- End of Chevron Icons -->
                    </button>
                    <dl>
                        <dt class="mb-2 text-sm font-semibold leading-none text-gray-900 dark:text-white">Assignee
                        </dt>
                        <dd class="inline-flex items-center space-x-2 text-sm text-gray-600 dark:text-gray-400">
                            <img class="h-8 w-8 rounded-full"
                                 src="https://ui-avatars.com/api/?name={{ urlencode($task->assignee->name) }}&background=0D8ABC&color=fff&bold=true"
                                 alt="{{ $task->assignee->name }} avatar" />
                            <span>
                                <div class="font-semibold text-gray-500 dark:text-gray-300">
                                    {{ $task->assignee->name }}
                                </div>
                                <div>
                                    {{ $task->assignee->position?->name }}
                                </div>
                            </span>
                        </dd>
                    </dl>
                </dt>
            </dl>
            <div x-show="expanded"
            x-collapse>
                @include('app.taskscore.assignments.partials.show-task', ['task' => $task])
            </div>
        </div>
    </div>
@endforeach
