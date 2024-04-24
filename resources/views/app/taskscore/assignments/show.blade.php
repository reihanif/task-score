@extends('layouts.app')

@section('title', $assignment->subject)

@section('content')
    <div class="grid grid-cols-12 gap-4">
        <div class="col-span-full flex-row items-center justify-between space-y-3 sm:flex sm:space-x-4 sm:space-y-0">
            <div>
                <h5 class="mr-3 font-semibold dark:text-white">{{ $assignment->subject }}</h5>
                @if (Auth::user()->id == $assignment->taskmaster->id)
                    <x-breadcrumbs class="mt-2"
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
                @elseif (Auth::user()->id == $assignment->assignee->id)
                    <x-breadcrumbs class="mt-2"
                        :menus="collect([
                            [
                                'name' => 'My Assignment',
                                'route' => route('taskscore.assignment.index'),
                            ],
                            [
                                'name' => $assignment->subject,
                                'route' => null,
                            ],
                        ])" />
                @endif
            </div>
        </div>

        <div class="col-span-full md:order-2 md:col-span-3">
            <div class="grid">
                <div
                    class="border-1 relative space-y-4 rounded-lg border border-gray-200 p-4 dark:border-gray-700 dark:bg-gray-800">
                    <div class="flex-row items-center justify-between space-y-3 sm:flex sm:space-x-4 sm:space-y-0">
                        <div>
                            <h5 class="mr-3 font-semibold dark:text-white">Details</h5>
                        </div>
                        <button
                            class="hidden items-center self-center rounded-lg p-2 text-center text-sm font-medium text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-700 sm:block"
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
                        <div class="z-10 hidden w-40 divide-y divide-gray-100 rounded-lg bg-white shadow dark:divide-gray-600 dark:bg-gray-700"
                            id="dropdownDots">
                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                aria-labelledby="dropdownMenuIconButton">
                                <li>
                                    <a class="block cursor-pointer px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                        data-modal-target="#"
                                        data-modal-show="#"
                                        type="button">Edit</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="text-gray-500 dark:text-gray-400">
                        <p class="mb-1 font-medium text-gray-600 dark:text-white">Taskmaster</p>
                        <x-popover.user-profile id="taskmaster-{{ $assignment->taskmaster->id }}"
                            :user="$assignment->taskmaster" />

                    </div>
                    <div class="text-gray-500 dark:text-gray-400">
                        <p class="mb-1 font-medium text-gray-600 dark:text-white">Assignee</p>
                        <x-popover.user-profile id="assignee-{{ $assignment->assignee->id }}"
                            :user="$assignment->assignee" />
                    </div>
                    <div class="text-gray-500 dark:text-gray-400">
                        <p class="mb-1 font-medium text-gray-600 dark:text-white">Category</p>
                        <p>
                            {{ $assignment->type }}
                        </p>
                    </div>
                    <div class="text-gray-500 dark:text-gray-400">
                        <p class="mb-1 font-medium text-gray-600 dark:text-white">Created at</p>
                        <p>
                            {{ $assignment->created_at->format('d F Y H:i') }}
                        </p>
                    </div>
                    <div class="text-gray-500 dark:text-gray-400">
                        <p class="mb-1 font-medium text-gray-600 dark:text-white">Deadline</p>
                        <p>
                            {{ $assignment->due->format('d F Y H:i') }}
                        </p>
                    </div>
                    <div class="text-gray-500 dark:text-gray-400">
                        <p class="mb-1 font-medium text-gray-600 dark:text-white">Status</p>
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
                            <p class="mb-1 font-medium text-gray-600 dark:text-white">Closed at</p>
                            <p>{{ $assignment->closed_at->format('d F Y H:i') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="relative col-span-full grid md:col-span-9">
            <div class="overflow-x-hidden">
                <div
                    class="border-1 relative rounded-lg border border-gray-200 p-4 text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                    {{ Str::of($assignment->description)->toHtmlString }}
                </div>
                @if (count($assignment->attachments) > 0)
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">
                            Attachments
                            <span class="float-right">:</span>
                        </dt>
                        <dd class="mt-2 text-sm text-gray-900 dark:text-gray-400 sm:col-span-2 sm:mt-0">
                            <ul class="divide-y divide-gray-100 rounded-md border border-gray-200 dark:divide-gray-700 dark:border-gray-700"
                                role="list">
                                @foreach ($assignment->attachments as $attachment)
                                    <li class="flex items-center justify-between py-4 pl-4 pr-5 text-sm leading-6">
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
                                                    class="truncate font-medium">{{ $attachment->name . '.' . $attachment->type }}</span>
                                                <span class="flex-shrink-0 text-gray-400">{{ FileSize::bytesToHuman($attachment->size) }}</span>
                                            </div>
                                        </div>
                                        <div class="ml-4 flex-shrink-0">
                                            <a class="font-medium text-indigo-600 hover:text-indigo-500"
                                                href="{{ Storage::url($attachment->path) }}"
                                                download>Download</a>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </dd>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
