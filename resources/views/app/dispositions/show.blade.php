@extends('layouts.app')

@section('title', $disposition->subject)

@section('content')
    <div class="grid grid-cols-12 gap-4">
        <div class="col-span-full">
            <h1 class="font-semibold text-xl mb-2 border-gray-200 text-gray-800 dark:border-gray-700  dark:text-white">Disposition Details</h1>
            <div class="flex-row items-center justify-between space-y-3 sm:flex sm:space-x-4 sm:space-y-0">
                <div class="w-full space-y-3">
                <x-breadcrumbs class="mb-2"
                    :menus="collect([
                        [
                            'name' => 'Disposition',
                            'route' => route('dispositions.index'),
                        ],
                        [
                            'name' => $disposition->subject,
                            'route' => null,
                        ],
                    ])" />

                    
                </div>
            </div>
        </div>

        <!-- Disposition Details -->
        <div class="col-span-full md:order-2 md:col-span-3">
            <div class="grid">
                <div
                    class="relative space-y-3 rounded-lg border border-gray-200 p-4 text-sm dark:border-gray-700 dark:bg-gray-800">
                    <div class="text-gray-500 dark:text-gray-400">
                        <p class="font-medium text-gray-600 dark:text-gray-300">Status</p>
                        <p>{{ $disposition->status }}</p>
                    </div>
                    <div class="text-gray-500 dark:text-gray-400">
                        <p class="font-medium text-gray-600 dark:text-gray-300">Priority</p>
                        <p> {{ $disposition->priority }}</p>
                    </div>
                    
                    <div class="text-gray-500 dark:text-gray-400">
                        <p class="font-medium text-gray-600 dark:text-gray-300">Task</p>
                        @foreach ($disposition->tasks as $key => $task) 
                            <p>{{ $task->task}} - {{ $task->assignee->name }}</p>
                        @endforeach
                    </div>
                    
                    <div class="text-gray-500 dark:text-gray-400">
                        <p class="font-medium text-gray-600 dark:text-gray-300">Created at</p>
                        <p>
                            {{ $disposition->created_at->format('d F Y H:i') }}
                        </p>
                    </div>
                    
                    <div class="text-gray-500 dark:text-gray-400">
                        <p class="font-medium text-gray-600 dark:text-gray-300">Resolution</p>
                        <p>
                            resolved at
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-span-full space-y-4 md:col-span-9">

            <!-- Disposition Description -->
            <div class="h-auto gap-8 rounded-lg border border-gray-200 p-4 text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                <div class="space-y-4">
                    <div>
                        <h6 class="text-md mr-3 font-semibold dark:text-white">Subject</h6>
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $disposition->subject }}</p>
                    </div>
                    
                    <div>
                        <h6 class="text-md mr-3 font-semibold dark:text-white">Descriptions</h6>
                        <div class="space-y-2">
                            <div class="break-words text-sm text-gray-600 dark:text-gray-400">
                                {{ Str::of($disposition->description)->toHtmlString }}
                            </div>
                        </div>
                    </div>
                    
                    <!-- Disposition Description Area -->
                    <div>
                        <div class="h-fit space-y-4">
                            <!-- Disposition Description -->
                            
                            <div>
                                <h6 class="text-md mr-3 mb-1 font-semibold dark:text-white">Attachment</h6>
                            <!-- Disposition Attachments -->
                            @if (count($disposition->attachments) > 0)
                                <div class="space-y-2">
                                    @foreach ($disposition->attachments as $attachment)
                                        <!-- Files -->
                                        <div class="max-w-96 flex items-center rounded-lg border border-gray-200 p-1 dark:border-gray-600"
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
                                    @endforeach
                                </div>
                            @endif
                            </div>
                            
                        </div>
                    </div>
                    <div class="mt-2 mb-4 space-x-2">
                        <button class="inline-flex rounded-lg border border-gray-200 bg-white px-3 py-2 text-center text-xs font-medium text-gray-500 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700"> 
                            <x-icons.edit-dispo class="h-4 w-4 mr-1"/> Edit
                        </button>
                        <button class="inline-flex rounded-lg border border-gray-200 bg-alert-danger px-3 py-2 text-center text-xs font-medium text-white hover:bg-alert-danger-hover focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:bg-alert-danger-dark dark:hover:bg-alert-danger-hover-dark dark:border-gray-600  dark:focus:ring-gray-700"
                        x-on:click="reqDeleteId = '{{ $disposition->id }}'"
                        data-modal-target="request-delete-dispo-modal"
                        data-modal-show="request-delete-dispo-modal"
                        data-href="#">
                            <x-icons.delete  class="h-4 w-4 mr-1"/>
                            Request Delete
                        </button>
                    </div>
                </div>
            </div>
            @include('app.dispositions.modals.request-delete')
        </div>
    </div>
@endsection
