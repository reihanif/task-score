@if ($task->submissions->count() > 0)
    <div class="ms-4">
        <ol class="relative space-y-4 border-s border-gray-200 dark:border-gray-700">
            @foreach ($task->submissions as $submission)
                <li class="ms-6">
                    <span
                          class="absolute -start-3 flex h-6 w-6 items-center justify-center rounded-full bg-blue-100 ring-8 ring-white dark:bg-blue-900 dark:ring-gray-800">
                        <img class="min-w-8 h-8 w-8 rounded-full"
                             src="https://ui-avatars.com/api/?name={{ urlencode($task->assignee->name) }}&background=0D8ABC&color=fff&bold=true">
                    </span>
                    <div class="gap-1">
                        <div
                             class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-600 dark:bg-gray-700">
                            <div class="mb-3 items-center justify-between gap-3 sm:flex">
                                <div>
                                    <time class="min-w-28 align-top text-xs font-normal text-gray-400">
                                        {{ $submission->created_at->format('d F Y, H:i') }}
                                    </time>
                                    <div class="text-sm font-normal text-gray-500 dark:text-gray-300">
                                        {{ $task->assignee->name }} submitted assignment
                                        <span class="font-semibold text-gray-900 hover:underline dark:text-white">
                                            {{ $task->uuid . ' ' }}{{ $assignment->subject }}
                                        </span>
                                    </div>
                                </div>
                                @assignee
                                    @if ($submission->isWaitingApproval() && $loop->last)
                                        <div class="flex-none self-start">
                                            <button class="inline-flex items-center self-center rounded-lg bg-white p-2 text-center text-sm font-medium text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-50 dark:bg-gray-900 dark:text-white dark:hover:bg-gray-800 dark:focus:ring-gray-600"
                                                    id="dropdownMenuIconButton"
                                                    data-dropdown-toggle="dropdown-{{ $submission->id }}"
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
                                            <div class="z-10 hidden w-40 divide-y divide-gray-100 rounded-lg bg-white shadow dark:divide-gray-600 dark:bg-gray-700"
                                                id="dropdown-{{ $submission->id }}">
                                                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                                    aria-labelledby="dropdownMenuIconButton">
                                                    <li>
                                                        <a class="block cursor-pointer px-4 py-2 text-red-600 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                                        data-modal-target="rollback-submission-modal-{{ $submission->id }}"
                                                        data-modal-toggle="rollback-submission-modal-{{ $submission->id }}">
                                                            Rollback
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        @include('app.taskscore.assignments.modals.rollback-submission')
                                    @endif
                                @endassignee
                            </div>
                            <div
                                 class="break-words rounded-lg border border-gray-200 bg-gray-50 p-3 text-xs text-gray-500 dark:border-gray-500 dark:bg-gray-600 dark:text-gray-300">
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
                                    @endforeach
                                </div>
                            @endif

                            @if ($submission->isWaitingApproval())
                                <span class="mt-2 text-xs font-normal text-yellow-500 dark:text-yellow-400">
                                    Waiting approval
                                </span>

                                @taskmaster
                                    <!-- Buttons -->
                                    <div class="flex justify-end gap-2">
                                        <button class="inline-flex rounded-lg border border-gray-200 bg-white px-3 py-2 text-center text-xs font-medium text-gray-500 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700"
                                                data-modal-toggle="approve-submission-modal-{{ $submission->id }}"
                                                data-modal-target="approve-submission-modal-{{ $submission->id }}"
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
                                        <button class="inline-flex rounded-lg border border-gray-200 bg-white px-3 py-2 text-center text-xs font-medium text-gray-500 hover:bg-gray-100 hover:text-red-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700"
                                                data-modal-toggle="reject-submission-modal-{{ $submission->id }}"
                                                data-modal-target="reject-submission-modal-{{ $submission->id }}"
                                                type="button">
                                            Reject
                                        </button>
                                    </div>
                                    <!-- Approval Modal -->
                                    @include('app.taskscore.assignments.modals.approve-task', $submission)

                                    <!-- Rejection Modal -->
                                    <x-modal id="reject-submission-modal-{{ $submission->id }}"
                                             data-title="Reject submission">
                                        <!-- Modal body -->
                                        <form class="p-4 md:p-5"
                                              x-on:submit="loading = ! loading"
                                              action="{{ route('taskscore.assignment.reject-submission', $submission->id) }}"
                                              method="post"
                                              enctype="multipart/form-data">
                                            @csrf
                                            @method('put')
                                            <div class="mb-5">
                                                <div class="space-y-4">
                                                    <div class="col-span-2">
                                                        <x-forms.text-editor name="detail"
                                                                             label="Rejection detail"
                                                                             placeholder="Rejection description and detail"
                                                                             required>
                                                        </x-forms.text-editor>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex place-content-end">
                                                <button class="inline-flex items-center rounded-lg bg-red-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800"
                                                        type="submit">
                                                    Reject
                                                </button>
                                            </div>
                                        </form>
                                    </x-modal>
                                @endtaskmaster
                            @endif
                        </div>
                    </div>
                </li>
                @if ($submission->isApproved())
                    <li class="ms-6">
                        <span
                              class="absolute -start-3 flex h-6 w-6 items-center justify-center rounded-full bg-blue-100 ring-8 ring-white dark:bg-blue-900 dark:ring-gray-800">
                            <img class="min-w-8 h-8 w-8 rounded-full"
                                 src="https://ui-avatars.com/api/?name={{ urlencode($submission->approver->name) }}&background=0D8ABC&color=fff&bold=true">
                        </span>
                        <div
                             class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                            <div class="items-center justify-between gap-3 sm:flex">
                                <time
                                      class="min-w-28 mb-1 self-start text-xs font-normal text-gray-400 sm:order-last sm:mb-0">
                                    {{ $submission->approved_at->format('d F Y, H:i') }}
                                </time>
                                <div class="text-sm font-normal text-gray-500 dark:text-gray-300">
                                    Assignment
                                    <span class="font-semibold text-blue-600 hover:underline dark:text-blue-500">
                                        approved</span>
                                    by {{ $submission->approver->name }}
                                </div>
                            </div>
                            @if ($submission->approval_detail)
                                <div
                                     class="mt-3 break-words rounded-lg border border-gray-200 bg-gray-50 p-3 text-xs text-gray-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-400">
                                    {{ Str::of($submission->approval_detail)->toHtmlString }}
                                </div>
                            @endif
                        </div>
                    </li>
                @elseif ($submission->isRejected())
                    <li class="ms-6">
                        <span
                              class="absolute -start-3 flex h-6 w-6 items-center justify-center rounded-full bg-blue-100 ring-8 ring-white dark:bg-blue-900 dark:ring-gray-800">
                            <img class="min-w-8 h-8 w-8 rounded-full"
                                 src="https://ui-avatars.com/api/?name={{ urlencode($submission->approver->name) }}&background=0D8ABC&color=fff&bold=true">
                        </span>
                        <div
                             class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-600 dark:bg-gray-700">
                            <div class="mb-3">
                                <time class="min-w-28 align-top text-xs font-normal text-gray-400">
                                    {{ $submission->approved_at->format('d F Y, H:i') }}
                                </time>
                                <div class="lex text-sm font-normal text-gray-500 dark:text-gray-300">
                                    Assignment
                                    <span class="font-semibold text-red-700 hover:underline dark:text-red-400">
                                        rejected</span>
                                    by {{ $submission->approver->name }}
                                </div>
                            </div>
                            <div
                                 class="break-words rounded-lg border border-red-300 bg-red-50 p-3 text-xs text-red-800 dark:border-red-400 dark:bg-gray-600 dark:text-red-300">
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
