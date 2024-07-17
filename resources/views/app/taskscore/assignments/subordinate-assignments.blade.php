@extends('layouts.app')

@section('title', 'Create Assignment')

@section('content')
    <div class="col-span-full flex-row items-center justify-between space-y-3 sm:flex sm:space-x-4 sm:space-y-0">
        <div>
            <h5 class="mr-3 font-semibold dark:text-white">Subordinate</h5>
            <x-breadcrumbs class="mt-2"
                           :menus="collect([
                               [
                                   'name' => 'Subordinate',
                                   'route' => null,
                               ],
                           ])" />
        </div>
    </div>

    <div class="col-span-full grid grid-cols-12 gap-4">
        <div class="col-span-full sm:order-2 sm:col-span-3">
            <div
                 class="border-1 relative grid space-y-4 overflow-x-hidden rounded-lg border border-gray-200 p-4 dark:border-gray-700 dark:bg-gray-800">
                <div class="flex-row items-center justify-between space-y-3 sm:flex sm:space-x-4 sm:space-y-0">
                    <div>
                        <h5 class="mr-3 font-semibold dark:text-white">My Subordinates</h5>
                        <p class="text-gray-500 dark:text-gray-400">Your subordinates list</p>
                    </div>
                </div>
                <ul class="max-w-md divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($assignees as $assignee)
                        <li class="py-3 first:pt-0 last:pb-0 sm:py-4">
                            <div class="flex items-center space-x-4 rtl:space-x-reverse">
                                <div class="flex-shrink-0">
                                    <img class="h-8 w-8 rounded-full"
                                         src="https://ui-avatars.com/api/?name={{ urlencode($assignee->name) }}&background=0D8ABC&color=fff&bold=true"
                                         title="{{ $assignee->name }}"
                                         alt="{{ $assignee->name }} image">
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="truncate text-sm font-medium text-gray-900 dark:text-white"
                                       title="{{ $assignee->name }}">
                                        {{ $assignee->name }}
                                    </p>
                                    <p class="truncate text-sm text-gray-500 dark:text-gray-400"
                                       title="{{ $assignee->position?->name }}">
                                        {{ $assignee->position?->name }}
                                    </p>
                                </div>
                                {{-- <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                    Score
                                </div> --}}
                            </div>
                        </li>
                    @empty
                        <li class="py-3 first:pt-0 last:pb-0 sm:py-4">
                            <div class="flex items-center space-x-4 rtl:space-x-reverse">
                                <div class="min-w-0 flex-1">
                                    <p class="truncate text-sm text-gray-900 dark:text-white">
                                        You don't have subordinate
                                    </p>
                                </div>
                            </div>
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>

        <div
             class="border-1 relative col-span-full overflow-x-hidden rounded-lg border border-gray-200 p-4 dark:border-gray-700 dark:bg-gray-800 sm:col-span-9">
            <div class="mb-4 flex-row items-center justify-between space-y-3 sm:flex sm:space-x-4 sm:space-y-0">
                <div>
                    <h5 class="mr-3 font-semibold dark:text-white">Subordinate Assignments</h5>
                    <p class="text-gray-500 dark:text-gray-400">Manage all your subordinate assignments or add a new one</p>
                </div>
            </div>
            <div class="grid gap-4 bg-white dark:bg-gray-800 md:grid-cols-2 md:flex-row md:space-y-0">
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
                                   placeholder="Search for assignment">
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
                            data-modal-target="create-assignment-modal"
                            data-modal-show="create-assignment-modal"
                            type="button">
                        <x-icons.plus class="-ml-1 mr-1 h-6 w-6">
                        </x-icons.plus>
                        Add Assignment
                    </button>
                </div>
            </div>
            <!-- Create Modal -->
            @include('app.taskscore.assignments.modals.create')

            <!-- Table -->
            <div>
                <table class="table-clickable w-full text-left text-xs text-gray-500 rtl:text-right dark:text-gray-400 sm:text-sm"
                       id="table">
                    <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <x-table-head class="whitespace-nowrap px-3 py-3"
                                          scope="col">
                                No
                            </x-table-head>
                            <x-table-head class="min-w-60 px-3 py-3"
                                          scope="col">
                                Subject
                            </x-table-head>
                            <x-table-head class="whitespace-nowrap px-3 py-3"
                                          scope="col">
                                Assignee
                            </x-table-head>
                            <x-table-head class="whitespace-nowrap px-3 py-3"
                                          scope="col">
                                Type
                            </x-table-head>
                            <x-table-head class="whitespace-nowrap px-3 py-3"
                                          scope="col">
                                Status
                            </x-table-head>
                            <x-table-head class="whitespace-nowrap px-3 py-3"
                                          scope="col">
                                Created at
                            </x-table-head>
                            @if (Auth::User()->role == 'superadmin')
                                <x-table-head class="px-3 py-3"
                                              data-dt-order="disable"
                                              scope="col" />
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($assignments as $key => $assignment)
                            <tr class="cursor-pointer border-b bg-white hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-600"
                                data-href="{{ route('taskscore.assignment.show', $assignment->id) }}">
                                <th class="whitespace-nowrap px-3 py-4 font-medium text-gray-900 dark:text-white"
                                    scope="row">
                                    {{ $loop->iteration }}
                                </th>
                                <th class="px-3 py-4 font-medium text-gray-900 dark:text-white"
                                    scope="row">
                                    {{ $assignment->subject }}
                                </th>
                                <td class="whitespace-nowrap px-3 py-4">
                                    @foreach ($assignment->tasks->unique('assignee_id') as $task)
                                        @if ($loop->count > 1)
                                            <li>
                                                {{ $task->assignee->name }}
                                            </li>
                                        @else
                                            {{ $task->assignee->name }}
                                        @endif
                                    @endforeach
                                </td>
                                <td class="whitespace-nowrap px-3 py-4">
                                    {{ $assignment->type }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-4">
                                    @if ($assignment->isOpen())
                                        <span
                                              class="me-2 rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                                            Open
                                        </span>
                                    @else
                                        <span
                                              class="me-2 rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800 dark:bg-red-900 dark:text-red-300">
                                            Closed
                                        </span>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-3 py-4"
                                    data-search="{{ $assignment->created_at->format('Ymd') }}"
                                    data-sort="{{ $assignment->created_at->format('YmdHis') }}">
                                    {{ $assignment->created_at->format('d F Y, H:i') }}
                                </td>
                                @if (Auth::User()->role == 'superadmin')
                                    <td class="float-end py-4 pe-2 ps-6">
                                        <div class="flex items-center">
                                            <button class="table-row-button inline-flex items-center self-center rounded-lg p-2 text-center text-sm font-medium text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-700"
                                                    id="dropdownMenuIconButton{{ $key }}"
                                                    data-dropdown-toggle="dropdownDots{{ $key }}"
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
                                                 id="dropdownDots{{ $key }}">
                                                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                                    aria-labelledby="dropdownMenuIconButton{{ $key }}">
                                                    <li>
                                                        <a class="block px-4 py-2 text-red-600 hover:bg-gray-100 dark:text-red-500 dark:hover:bg-gray-600 dark:hover:text-red-400"
                                                           data-modal-target="delete-assignment-modal-{{ $assignment->id }}"
                                                           data-modal-show="delete-assignment-modal-{{ $assignment->id }}"
                                                           type="button">Delete</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <x-modals.delete-assignment id="{{ $assignment->id }}"
                                                                        name="{{ $assignment->subject }}" />
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Filter Dropdown -->
    <div class="z-10 hidden w-96 rounded-lg bg-white p-3 shadow dark:bg-gray-700"
         id="filter-dropdown">
        <div class="grid grid-cols-2 gap-2">
            <div class="col-span-2">
                <h6 class="mb-1.5 text-sm font-medium text-gray-900 dark:text-white">Assignee</h6>
                <select class="ts-sm"
                        id="filter-assignee">
                    <option value=""
                            selected>All Assignee</option>
                    @foreach ($assignees as $assignee)
                        <option value="{{ $assignee->name }}">{{ $assignee->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <h6 class="mb-1.5 text-sm font-medium text-gray-900 dark:text-white">Type</h6>
                <select class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                        id="filter-type"
                        normal-select>
                    <option value=""
                            selected>All Type</option>
                    @foreach ($types as $type)
                        <option value="{{ $type }}">{{ $type }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <h6 class="mb-1.5 text-sm font-medium text-gray-900 dark:text-white">Status</h6>
                <select class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                        id="filter-status"
                        normal-select>
                    <option value=""
                            selected>All Status</option>
                    <option value="Open">Open</option>
                    <option value="Closed">Closed</option>
                </select>
            </div>
            <div>
                <h6 class="mb-1.5 text-sm font-medium text-gray-900 dark:text-white">Created from</h6>
                <input class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                       id="filter-mindate"
                       type="date"
                       onclick="showPicker()" />
            </div>
            <div>
                <h6 class="mb-1.5 text-sm font-medium text-gray-900 dark:text-white">to</h6>
                <input class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                       id="filter-maxdate"
                       type="date"
                       onclick="showPicker()" />

            </div>
        </div>
    </div>
    <!-- End of Filter Dropdown -->
@endsection

@section('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let table = new DataTable(
                "#table", {
                    responsive: true,
                    layout: {
                        topStart: {},
                        topEnd: {},
                        bottomStart: {
                            pageLength: {
                                text: "Rows per page_MENU_",
                            },
                            info: {
                                text: '<span class="font-semibold dark:text-white"> _START_ - _END_ </span> of <span class="font-semibold dark:text-white">_TOTAL_</span>',
                            },
                        },
                    },
                    oLanguage: {
                        sEmptyTable: '<object class="mx-auto w-full sm:h-64 sm:w-64 sm:p-0" data="' +
                            window.assetUrl +
                            'assets/illustrations/no-data-animate.svg"></object>' +
                            '<div class="mb-8">No data found</div>',
                    },
                    language: {
                        zeroRecords: '<object class="mx-auto w-full sm:h-64 sm:w-64 sm:p-0" data="' +
                            window.assetUrl +
                            'assets/illustrations/no-data-animate.svg"></object>' +
                            '<div class="mb-8">No matching records found</div>',
                        zeroRecords: '<object class="mx-auto w-full sm:h-64 sm:w-64 sm:p-0" data="' +
                            window.assetUrl +
                            'assets/illustrations/no-data-animate.svg"></object>' +
                            '<div class="mb-8">No matching records found</div>',
                        infoEmpty: '<span class="font-semibold dark:text-white"> 0 - 0 </span> of <span class="font-semibold dark:text-white">0</span>',
                    },
                }
            );
            document
                .getElementById("filter-search")
                .addEventListener("keyup", function() {
                    table.columns(1).search(this.value).draw();
                });
            document
                .getElementById("filter-type")
                .addEventListener("change", function() {
                    table.columns(3).search(this.value, false, false, false).draw();
                });
            document
                .getElementById("filter-status")
                .addEventListener("change", function() {
                    table
                        .columns(4)
                        .search(this.value, false, false, false)
                        .draw();
                });
            document
                .getElementById("filter-assignee")
                .addEventListener("change", function() {
                    table
                        .columns(2)
                        .search(this.value, false, false, false)
                        .draw();
                });

            const mindate = document.querySelector("#filter-mindate");
            const maxdate = document.querySelector("#filter-maxdate");

            table.search.fixed(
                "range",
                function(searchStr, data, index) {
                    // Split the input date string by '/'
                    const [minYear, minMonth, minDay] = mindate.value.split("-");
                    const [maxYear, maxMonth, maxDay] = maxdate.value.split("-");

                    // Construct the new date string in the format "YYYYMMDD"
                    const minDateStr = `${minYear}${minMonth}${minDay}`;
                    const maxDateStr = `${maxYear}${maxMonth}${maxDay}`;


                    var min = parseInt(minDateStr, 10);
                    var max = parseInt(maxDateStr, 10);
                    var date = parseFloat(data[5]["@data-search"]); // use data for the date column

                    if (
                        (isNaN(min) && isNaN(max)) ||
                        (isNaN(min) && date <= max) ||
                        (min <= date && isNaN(max)) ||
                        (min <= date && date <= max)
                    ) {
                        return true;
                    }

                    return false;
                }
            );

            // Changes to the inputs will trigger a redraw to update the table
            mindate.addEventListener("change", function() {
                table.draw();
            });
            maxdate.addEventListener("change", function() {
                table.draw();
            });
        });
    </script>
@endsection
