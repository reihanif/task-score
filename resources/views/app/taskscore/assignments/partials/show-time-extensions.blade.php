@forelse ($time_extensions as $time_extension)
    <div class="flex items-start gap-2.5">
        <img class="h-8 w-8 rounded-full"
             src="https://ui-avatars.com/api/?name={{ urlencode($task->assignee->name) }}&background=0D8ABC&color=fff&bold=true"
             alt="Jese image">
        <div class="leading-1.5 flex w-full max-w-[90%] flex-col">
            <div class="flex items-center space-x-2 rtl:space-x-reverse">
                <span class="text-sm font-semibold text-gray-900 dark:text-white">
                    {{ $task->assignee->name }}
                </span>
                <span
                      class="text-sm font-normal text-gray-500 dark:text-gray-400">{{ $time_extension->created_at->format('d F Y, H:i') }}</span>
            </div>
            <div class="break-words py-2 text-sm font-normal text-gray-600 dark:text-gray-400">
                {{ Str::of($time_extension->body)->toHtmlString }}
            </div>
            @if ($time_extension->isWaitingApproval())
                <span class="text-sm font-normal text-yellow-500 dark:text-yellow-400">
                    Waiting approval
                </span>

                @taskmaster
                    <!-- Buttons -->
                    <div class="flex justify-end gap-2">
                        <button class="inline-flex rounded-lg border border-gray-200 bg-white px-3 py-2 text-center text-xs font-medium text-gray-500 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-blue-500 dark:focus:ring-gray-700"
                                data-modal-toggle="approve-time-extension-modal-{{ $time_extension->id }}"
                                data-modal-target="approve-time-extension-modal-{{ $time_extension->id }}"
                                type="button">
                            Approve
                        </button>
                        <button class="inline-flex rounded-lg border border-gray-200 bg-white px-3 py-2 text-center text-xs font-medium text-gray-500 hover:bg-gray-100 hover:text-red-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-red-500 dark:focus:ring-gray-700"
                                data-modal-toggle="reject-time-extension-modal-{{ $time_extension->id }}"
                                data-modal-target="reject-time-extension-modal-{{ $time_extension->id }}"
                                type="button">
                            Reject
                        </button>
                    </div>

                    @include('app.taskscore.assignments.modals.approve-time-extension')
                    @include('app.taskscore.assignments.modals.reject-time-extension')
                @endtaskmaster
            @elseif ($time_extension->isApproved())
                <span class="text-sm font-normal text-blue-500 dark:text-blue-400">
                    Approved at {{ $time_extension->approved_at->format('d F Y, H:i') }}
                </span>
            @elseif ($time_extension->isRejected())
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
