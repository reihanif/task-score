@extends('layouts.app')

@section('title', $assignment->subject)

@section('content')
    <div class="grid grid-cols-12 gap-3">
        <div class="col-span-full flex-row items-center justify-between space-y-3 sm:flex sm:space-x-4 sm:space-y-0">
            <div class="space-y-3">
                @if (Auth::user()->isTaskmaster())
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
                @elseif (Auth::user()->isAssignee())
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
                @if (Auth::User()->isTaskmaster())
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
                        @if ($assignment->isResolved())
                            <button
                                class="inline-flex rounded-lg border border-gray-200 bg-white px-3 py-2 text-center text-xs font-medium text-gray-500 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700"
                                type="button">
                                <svg class="me-1 h-3.5 w-3.5"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="currentColor"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="M5.921 11.9 1.353 8.62a.72.72 0 0 1 0-1.238L5.921 4.1A.716.716 0 0 1 7 4.719V6c1.5 0 6 0 7 8-2.5-4.5-7-4-7-4v1.281c0 .56-.606.898-1.079.62z" />
                                </svg>
                                Response
                            </button>
                        @endif
                    </div>
                @endif
                @if (!$assignment->isResolved() && Auth::User()->isAssignee())
                    <div>
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
                        <!-- Modal -->
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
                                        Save
                                    </button>
                                </div>
                            </form>
                        </x-modal>
                    </div>
                @endif
            </div>
        </div>

        <div class="col-span-full md:order-2 md:col-span-3">
            <div class="grid">
                <div
                    class="border-1 relative space-y-4 rounded-lg border border-gray-200 p-4 text-sm dark:border-gray-700 dark:bg-gray-800">
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
                    <div class="text-gray-500 dark:text-gray-400">
                        <p class="font-medium uppercase text-gray-600 dark:text-gray-300">Deadline</p>
                        <p>
                            {{ $assignment->due->format('d F Y H:i') . ' ' . '(' . $assignment->due->diffForHumans() . ')' }}
                        </p>
                    </div>
                    <div class="text-gray-500 dark:text-gray-400">
                        <p class="font-medium uppercase text-gray-600 dark:text-gray-300">Resolution</p>
                        <p>
                            {{ $assignment->resolved_at ? 'Resolved at ' . $assignment->resolved_at->format('d F Y, H:i') : 'Unresolved' }}
                        </p>
                    </div>
                    <div class="text-gray-500 dark:text-gray-400">
                        <p class="font-medium uppercase text-gray-600 dark:text-gray-300">Score</p>
                        @if ($assignment->isResolved())
                            @php
                                $interval = $assignment->created_at->diff($assignment->resolved_at);
                                $due_interval = $assignment->created_at->diff($assignment->due);

                                $resolved =
                                    $interval->days * 86400 + $interval->h * 3600 + $interval->i * 60 + $interval->s;

                                $due =
                                    $due_interval->days * 86400 +
                                    $due_interval->h * 3600 +
                                    $due_interval->i * 60 +
                                    $due_interval->s;
                                $score = ($due / $resolved) * 100;
                            @endphp
                            <div class="mt-1 w-full rounded-full bg-gray-200 dark:bg-gray-700">
                                <div class="rounded-full bg-blue-600 p-0.5 text-center text-xs font-medium leading-none text-blue-100"
                                    style="width: {{ $assignment->score() <= 100 ? $assignment->score() : 100 }}%">
                                    {{ $assignment->score() }}%
                                </div>
                            </div>
                        @else
                            <p>-</p>
                        @endif
                    </div>
                    <div class="text-gray-500 dark:text-gray-400">
                        <p class="font-medium uppercase text-gray-600 dark:text-gray-300">Status</p>
                        <p>
                            @if ($assignment->status == 'open')
                                <span
                                    class="me-2 rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800 dark:bg-blue-900 dark:text-blue-300">
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
                    @if ($assignment->status == 'closed')
                        <div class="text-gray-500 dark:text-gray-400">
                            <p class="text-sm font-medium uppercase text-gray-600 dark:text-gray-300">Closed at</p>
                            <p>
                                {{ $assignment->closed_at->format('d F Y H:i') }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="relative col-span-full grid gap-4 md:col-span-9">
            <div
                class="border-1 relative h-fit rounded-lg border border-gray-200 text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                <div class="h-fit space-y-8 p-4">
                    <div class="space-y-2">
                        <h6 class="mr-3 text-sm font-bold dark:text-white">Detail and descriptions</h6>
                        <div class="text-sm text-gray-600 dark:text-gray-400">
                            {{ Str::of($assignment->description)->toHtmlString }}
                        </div>
                    </div>

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
            @if ($assignment->resolution)
                <div
                    class="border-1 relative h-fit rounded-lg border border-gray-200 text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                    <div class="h-fit space-y-8 p-4">

                        <div class="space-y-2">
                            <h6 class="mr-3 text-sm font-bold dark:text-white">Resolution</h6>
                            <div class="text-sm text-gray-600 dark:text-gray-400">
                                {{ Str::of($assignment->resolution)->toHtmlString }}
                            </div>
                        </div>

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
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
