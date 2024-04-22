@extends('layouts.app')

@section('title', 'Create Assignment')

@section('content')
    <div class="col-span-full flex-row items-center justify-between space-y-3 sm:flex sm:space-x-4 sm:space-y-0">
        <div>
            <h5 class="mr-3 font-semibold dark:text-white">Assignment</h5>
            <x-breadcrumbs class="mt-2"
                :menus="collect([
                    [
                        'name' => 'Assignment',
                        'route' => null,
                    ],
                ])" />
        </div>
    </div>

    <div
        class="border-1 relative col-span-2 overflow-x-hidden rounded-lg border border-gray-200 p-4 dark:border-gray-700 dark:bg-gray-800">
        <div class="flex-row items-center justify-between space-y-3 sm:flex sm:space-x-4 sm:space-y-0">
            <div>
                <h5 class="mr-3 font-semibold dark:text-white">Subordinate Assignments</h5>
                <p class="text-gray-500 dark:text-gray-400">Manage all your existing subordinate assignment or add a new one
                </p>
            </div>
        </div>

        <div
            class="flex-column flex flex-wrap items-end justify-between space-y-4 bg-white py-4 dark:bg-gray-800 md:flex-row md:space-y-0">
            <div id="search">
                <label class="sr-only"
                    for="table-search-users">Search</label>
                <div class="relative">
                    <div class="rtl:inset-r-0 pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3">
                        <x-icons.search class="h-4 w-4 text-gray-500 dark:text-gray-400"></x-icons.search>
                    </div>
                    <input
                        class="block w-auto rounded-lg border border-gray-300 bg-gray-50 ps-10 pt-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                        id="table-search-users"
                        type="text"
                        placeholder="Search for assignment">
                </div>
            </div>
            <!-- Modal toggle -->
            <button
                class="flex items-center justify-center rounded-lg bg-blue-700 px-4 py-2 text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                data-modal-target="create-assignment-modal"
                data-modal-show="create-assignment-modal"
                type="button">
                <x-icons.plus class="-ml-1 mr-1 h-6 w-6">
                </x-icons.plus>
                Add Assignment
            </button>
            <!-- Modal -->
            <x-modals.create-assignment id="create-assignment-modal"
                data-title="Create new assignment">
                <!-- Modal body -->
                <form class="p-4 md:p-5"
                    x-on:submit="loading = ! loading"
                    action="#"
                    method="post">
                    @method('put')
                    @csrf
                    <div class="mb-5">
                        <div class="space-y-4">
                            <div class="space-y-4 sm:grid sm:grid-cols-2 sm:space-x-4 sm:space-y-0">
                                <x-forms.select id="input-assignee"
                                    name="assignee"
                                    label="Assignee"
                                    state="initial"
                                    required>
                                    <option value="">Select assignee</option>
                                </x-forms.select>
                                <x-forms.select id="input-category"
                                    name="category"
                                    label="Category"
                                    state="initial"
                                    required>
                                    <option value="">Select assignment category</option>
                                    <option value="Pembuatan Memorandum">Pembuatan Memorandum</option>
                                    <option value="Pembuatan Surat">Pembuatan Surat</option>
                                    <option value="Membuat bahan presentasi">Membuat bahan presentasi</option>
                                    <option value="Menghadiri rapat">Menghadiri rapat</option>
                                    <option value="Melakukan perjalanan dinas">Melakukan perjalanan dinas</option>
                                    <option value="Pembuatan SP3">Pembuatan SP3</option>
                                    <option value="Pembuatan Berita Acara">Pembuatan Berita Acara</option>
                                    <option value="Pembuatan Sales Order">Pembuatan Sales Order</option>
                                </x-forms.select>
                            </div>
                            <div class="col-span-2">
                                <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
                                    for="message">Description
                                </label>
                                <textarea
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                    id="message"
                                    rows="4"
                                    placeholder="Assignment description and details"></textarea>
                            </div>
                            <div class="col-span-2">
                                <x-forms.text-editor placeholder="Assignment description and details"></x-forms.text-editor>
                                <x-forms.text-editor placeholder="Testing"></x-forms.text-editor>
                            </div>
                            <div class="col-span-2">
                                <label class="mb-2 inline-flex gap-1 text-sm font-medium text-gray-900 dark:text-white"
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
                                    type="file">
                            </div>
                            <p class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                                Assignment deadline
                            </p>
                            <ul
                                class="w-full items-center rounded-lg border border-gray-200 bg-white text-sm font-medium text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:flex">
                                <li class="w-full border-b border-gray-200 dark:border-gray-600 sm:border-b-0 sm:border-r">
                                    <div class="flex items-center ps-3">
                                        <input
                                            class="h-4 w-4 border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-500 dark:bg-gray-600 dark:ring-offset-gray-700 dark:focus:ring-blue-600 dark:focus:ring-offset-gray-700"
                                            id="horizontal-list-radio-license"
                                            name="list-radio"
                                            type="radio"
                                            value="">
                                        <label class="ms-2 w-full py-3 text-sm font-medium text-gray-900 dark:text-gray-300"
                                            for="horizontal-list-radio-license">Exact Time</label>
                                    </div>
                                </li>
                                <li class="w-full dark:border-gray-600">
                                    <div class="flex items-center ps-3">
                                        <input
                                            class="h-4 w-4 border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-500 dark:bg-gray-600 dark:ring-offset-gray-700 dark:focus:ring-blue-600 dark:focus:ring-offset-gray-700"
                                            id="horizontal-list-radio-passport"
                                            name="list-radio"
                                            type="radio"
                                            value="">
                                        <label class="ms-2 w-full py-3 text-sm font-medium text-gray-900 dark:text-gray-300"
                                            for="horizontal-list-radio-passport">Time Interval</label>
                                    </div>
                                </li>
                            </ul>

                            <div class="sm:grid sm:grid-cols-2 sm:space-x-4">
                                <div class="space-y-4 sm:grid sm:grid-cols-2 sm:space-x-4 sm:space-y-0">
                                    <x-forms.input id="input-date"
                                        name="date"
                                        type="text"
                                        value="today()"
                                        datepicker
                                        datepicker-format="dd/mm/yy"
                                        datepicker-min-date="20/04/2024"
                                        datepicker-max-date="20/07/2024"
                                        readonly
                                        placeholder="Select due date"
                                        autocomplete="off"
                                        state="initial"
                                        label="Date"
                                        required />

                                    <x-forms.input class="cursor-pointer"
                                        id="input-time"
                                        name="time"
                                        type="time"
                                        onfocus="showPicker()"
                                        state="initial"
                                        label="Time"
                                        required />
                                </div>
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
            </x-modals.create-assignment>
        </div>
        <div class="overflow-x-auto">
            <table class="table-clickable w-full text-left text-sm text-gray-500 rtl:text-right dark:text-gray-400">
                <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="whitespace-nowrap px-6 py-3"
                            scope="col">
                            No
                        </th>
                        <th class="whitespace-nowrap px-6 py-3"
                            scope="col">
                            Nama
                        </th>
                        <th class="whitespace-nowrap px-6 py-3"
                            scope="col">
                            Created at
                        </th>
                        <th class="whitespace-nowrap px-6 py-3"
                            scope="col">
                            Last Updated
                        </th>
                        @if (Auth::User()->role == 'superadmin')
                            <th class="px-6 py-3"
                                scope="col">
                            </th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    {{-- @foreach ($assignments as $key => $assignment)
                        <tr class="cursor-pointer border-b bg-white hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-600"
                            data-href="{{ route('assignments.show', $assignment->id) }}">
                            <th class="whitespace-nowrap px-6 py-4 font-medium text-gray-900 dark:text-white"
                                scope="row">
                                {{ ($assignments->currentpage() - 1) * $assignments->perpage() + $key + 1 }}
                            </th>
                            <th class="whitespace-nowrap px-6 py-4 font-medium text-gray-900 dark:text-white"
                                scope="row">
                                {{ $assignment->name }}
                            </th>
                            <td class="whitespace-nowrap px-6 py-4">
                                {{ $assignment->created_at->format('d F Y, H:i') }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                {{ $assignment->updated_at->diffForHumans() }}
                            </td>
                            @if (Auth::User()->role == 'superadmin')
                                <td class="float-end py-4 pe-2 ps-6">
                                    <div class="flex items-center">
                                        <button
                                            class="table-row-button inline-flex items-center self-center rounded-lg p-2 text-center text-sm font-medium text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-700"
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
                                                    <a class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                                        data-modal-target="edit-assignments-modal-{{ $assignment->id }}"
                                                        data-modal-show="edit-assignments-modal-{{ $assignment->id }}"
                                                        type="button">Edit</a>
                                                </li>
                                                <li>
                                                    <a class="block px-4 py-2 text-red-600 hover:bg-gray-100 dark:text-red-500 dark:hover:bg-gray-600 dark:hover:text-red-400"
                                                        data-modal-target="delete-assignments-modal-{{ $assignment->id }}"
                                                        data-modal-show="delete-assignments-modal-{{ $assignment->id }}"
                                                        type="button">Delete</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <x-modals.edit-assignment :assignment="$assignment"
                                            :positions="$positions" />
                                        <x-modals.delete-assignment id="{{ $assignment->id }}"
                                            name="{{ $assignment->name }}" />
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @endforeach --}}
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{-- {{ $assignments->links() }} --}}
        </div>
    </div>
@endsection

@section('script')
@endsection
