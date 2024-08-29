@extends('layouts.app')

@section('title', 'Disposition')

@section('content')
    <div class="col-span-full flex-row items-center justify-between space-y-3 sm:flex sm:space-x-4 sm:space-y-0">
        <div>
            <h5 class="mr-3 font-semibold dark:text-white">Disposition</h5>
            <x-breadcrumbs class="mt-2"
                        :menus="collect([
                            [
                                'name' => 'Disposition',
                                'route' => null,
                            ],
                        ])" />
        </div>
    </div>

    <div 
        class="col-span-full grid grid-cols-12 gap-4" 
        x-data="{ reqDeleteId: null }">
        <div
             class="border-1 relative col-span-full overflow-x-hidden rounded-lg border border-gray-200 p-4 dark:border-gray-700 dark:bg-gray-800">
            <div class="mb-4 flex-row items-center justify-between space-y-3 sm:flex sm:space-x-4 sm:space-y-0">
                <div>
                    <h5 class="mr-3 font-semibold dark:text-white">Dispositions List</h5>
                    <p class="text-gray-500 dark:text-gray-400">Manage all your dispositions or add a new one</p>
                </div>
            </div>
            <div class="grid gap-4 bg-white dark:bg-gray-800 md:grid-cols-2 md:flex-row md:space-y-0 mb-2 sm:mb-4">
                <div class="inline-flex gap-2">
                    <div class="grow"
                         id="search">
                        <label class="sr-only"
                               for="filter-search">Search</label>
                        <div class="relative">
                            <div
                                 class="rtl:inset-r-0 pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3">
                                <x-icons.search class="h-4 w-4 text-gray-500 dark:text-gray-400"></x-icons.search>
                            </div>
                            <input class="block w-full rounded-lg border border-gray-300 bg-gray-50 ps-10 pt-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                   id="filter-search"
                                   type="text"
                                   placeholder="Search for disposition">
                        </div>
                    </div>
                    <div>
                        <button class="hover:text-primary-700 flex w-full items-center justify-center rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700 md:w-auto"
                                id="filter-dropdown-button"
                                data-dropdown-toggle="filter-dropdown"
                                type="button">
                            <svg class="mr-2 h-4 w-4 text-gray-400"
                                 aria-hidden="true"
                                 xmlns="http://www.w3.org/2000/svg"
                                 viewbox="0 0 20 20"
                                 fill="currentColor">
                                <path fill-rule="evenodd"
                                      d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z"
                                      clip-rule="evenodd" />
                            </svg>
                            Filter
                            <svg class="-mr-1 ml-1.5 h-5 w-5"
                                 aria-hidden="true"
                                 fill="currentColor"
                                 viewbox="0 0 20 20"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path clip-rule="evenodd"
                                      fill-rule="evenodd"
                                      d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="order-first grid justify-items-end md:order-last">
                    <!-- Modal toggle -->
                    <button class="flex items-center justify-center rounded-lg bg-blue-700 px-4 py-2 text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                            data-modal-target="create-disposition-modal"
                            data-modal-show="create-disposition-modal"
                            type="button">
                        <x-icons.plus class="-ml-1 mr-1 h-6 w-6">
                        </x-icons.plus>
                        Add Disposition
                    </button>
                </div>
            </div>

            @include('app.dispositions.modals.create')
            

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="table-clickable w-full text-left text-xs text-gray-500 rtl:text-right dark:text-gray-400 sm:text-sm"
                       id="table">
                    <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <x-table-head class="whitespace-nowrap px-3 py-3"
                                          scope="col">
                                No
                            </x-table-head>
                            <x-table-head class="whitespace-nowrap px-3 py-3"
                                          scope="col">
                                No Agenda
                            </x-table-head>
                            <x-table-head class="min-w-60 px-3 py-3"
                                          scope="col">
                                Subject
                            </x-table-head>
                            <x-table-head class="whitespace-nowrap px-3 py-3"
                                          scope="col">
                                Status
                            </x-table-head>
                            <x-table-head class="whitespace-nowrap px-3 py-3"
                                          scope="col">
                                Priority
                            </x-table-head>
                            <x-table-head class="min-w-60 px-3 py-3"
                                          scope="col">
                                Task
                            </x-table-head>
                            <x-table-head class="min-w-60 px-3 py-3"
                                          scope="col">
                                Description
                            </x-table-head>
                            <x-table-head class="min-w-44 px-3 py-3"
                                          scope="col">
                                Created At
                            </x-table-head>
                            <x-table-head class="min-w-44 px-3 py-3"
                                          scope="col">
                                Due
                            </x-table-head>
                            <x-table-head class="whitespace-nowrap px-3 py-3"
                                          scope="col">
                                Action
                            </x-table-head>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dispositions as $key => $disposition)
                            <tr class="cursor-pointer border-b bg-white hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-600"
                                data-href="{{ route('dispositions.show', $disposition->id) }}">
                                <th class="whitespace-nowrap px-3 py-4 font-medium text-gray-900 dark:text-white"
                                    scope="row">
                                    {{ $loop->iteration }}
                                </th>
                                <td class="whitespace-nowrap px-3 py-4">
                                    {{ $disposition->no_agenda }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-4">
                                    {{ $disposition->subject }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-4">
                                    {{ $disposition->status }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-4">
                                    {{ $disposition->priority }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-4">
                                    <ul class="list-disc space-y-3">
                                        @foreach ($disposition->tasks as $task)
                                            <li>
                                                <span class="font-bold inline">{{ $task->task }} - </span>
                                                {{  $task->assignee->name }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td class="whitespace-nowrap px-3 py-4">
                                    {!! $disposition->description !!}
                                </td>
                               
                                <td class="whitespace-nowrap px-3 py-4"
                                    data-search="{{ $disposition->created_at->format('Ymd') }}"
                                    data-order="{{ $disposition->created_at->format('YmdHis') }}">
                                    {{ $disposition->created_at->format('d F Y, H:i') }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-4">
                                    {{ $disposition->due_date->format('d F Y, H:i') }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-4">
                                    <button 
                                        class="text-alert-danger hover:underline font-bold"
                                        x-on:click="reqDeleteId = '{{ $disposition->id }}'"
                                        data-modal-target="request-delete-dispo-modal"
                                        data-modal-show="request-delete-dispo-modal"
                                        data-href="#"
                                        >
                                         Request Delete
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    
                </table>
            </div> 

            <!-- Request Delete Modal -->
            @include('app.dispositions.modals.request-delete')
        </div>
    </div>


@endsection