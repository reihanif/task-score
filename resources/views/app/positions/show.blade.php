@extends('layouts.app')

@section('title', $position->name)

@section('content')
    <div class="grid grid-cols-12 gap-4">
        <div class="col-span-full flex-row items-center justify-between space-y-3 sm:flex sm:space-x-4 sm:space-y-0">
            <div>
                <h5 class="mr-3 font-semibold dark:text-white">{{ $position->name }}</h5>
                <x-breadcrumbs class="mt-2"
                    :menus="collect([
                        ['name' => 'Positions', 'route' => route('positions.index')],
                        ['name' => $position->name, 'route' => null],
                    ])" />
            </div>
        </div>

        <div class="col-span-full md:order-2 md:col-span-4">
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
                                        data-modal-target="edit-positions-modal-{{ $position->id }}"
                                        data-modal-show="edit-positions-modal-{{ $position->id }}"
                                        type="button">Edit</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="text-gray-500 dark:text-gray-400">
                        <p class="mb-1 font-medium text-gray-600 dark:text-white">Users</p>
                        @if (!$position->users->isEmpty())
                            @if (count($position->users) !== 1)
                                @foreach ($position->users as $user)
                                    <li>
                                        {{ $user->name }}
                                    </li>
                                @endforeach
                            @else
                                @foreach ($position->users as $user)
                                    <x-popover.user-profile id="users-{{ $user->id }}" href="{{ route('account.settings', $user->id) }}" :user="$user" />
                                @endforeach
                            @endif
                        @else
                            <p>No users</p>
                        @endif
                    </div>
                    <div class="text-gray-500 dark:text-gray-400">
                        <p class="mb-1 font-medium text-gray-600 dark:text-white">Direct Superiors</p>
                        @if ($position->superior)
                            <p>{{ $position->superior->name }}</p>
                        @else
                            <p>No superiors</p>
                        @endif
                    </div>
                    <div class="text-gray-500 dark:text-gray-400">
                        <p class="mb-1 font-medium text-gray-600 dark:text-white">Direct Subordinates :</p>
                        @if ($position->subordinates->isEmpty())
                            <p>
                                No subordinates
                            </p>
                        @else
                            <ul class="max-w-md list-inside list-disc space-y-1 text-gray-500 dark:text-gray-400">
                                @foreach ($position->subordinates as $subordinate)
                                    <li>{{ $subordinate->name }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="relative col-span-full grid md:col-span-8">
            <div class="overflow-x-hidden">
                <div class="border-1 relative rounded-lg border border-gray-200 p-4 dark:border-gray-700 dark:bg-gray-800">
                    <div class="flex-row items-center justify-between space-y-3 sm:flex sm:space-x-4 sm:space-y-0">
                        <div>
                            <h5 class="mr-3 font-semibold dark:text-white">{{ $position->name }} Related Departments</h5>
                            <p class="text-gray-500 dark:text-gray-400">Manage all departments of the
                                {{ $position->name }} authority</p>
                        </div>
                    </div>
                    <x-modals.edit-position id="{{ $position->id }}"
                        name="{{ $position->name }}"
                        :position="$position"
                        :positions="$positions" />

                    <div
                        class="flex-column flex flex-wrap items-end justify-between space-y-4 bg-white py-4 dark:bg-gray-800 md:flex-row md:space-y-0">
                        <div id="search">
                            <label class="sr-only"
                                for="table-search-users">Search</label>
                            <div class="relative">
                                <div
                                    class="rtl:inset-r-0 pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3">
                                    <x-icons.search class="h-4 w-4 text-gray-500 dark:text-gray-400"></x-icons.search>
                                </div>
                                <input
                                    class="block w-auto rounded-lg border border-gray-300 bg-gray-50 ps-10 pt-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                    id="table-search-users"
                                    type="text"
                                    placeholder="Search for position">
                            </div>
                        </div>
                        <x-modals.position-authorization
                            class="flex items-center justify-center rounded-lg bg-blue-700 px-4 py-2 text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                            :position="$position"
                            :departments="$departments" />
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-gray-500 rtl:text-right dark:text-gray-400">
                            <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th class="px-6 py-3"
                                        scope="col">
                                        No
                                    </th>
                                    <th class="px-6 py-3"
                                        scope="col">
                                        Name
                                    </th>
                                    <th class="px-6 py-3"
                                        scope="col">
                                        Added by
                                    </th>
                                    <th class="px-6 py-3"
                                        scope="col">
                                        Added at
                                    </th>
                                    <th scope="col">
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($position->departments as $department)
                                    <tr
                                        class="border-b bg-white hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-600">
                                        <th class="whitespace-nowrap px-6 py-4 font-medium text-gray-900 dark:text-white"
                                            scope="row">
                                            {{ $loop->iteration }}
                                        </th>
                                        <th class="whitespace-nowrap px-6 py-4 font-medium text-gray-900 dark:text-white"
                                            scope="row">
                                            {{ $department->name }}
                                        </th>
                                        <td class="whitespace-nowrap px-6 py-4">
                                            {{-- {{ $department->pivot->added_by->username }} --}}
                                            <x-popover.user-profile id="adder-{{ $loop->iteration }}" type="username" href="{{ route('account.settings', $department->pivot->added_by->id) }}" :user="$department->pivot->added_by" />
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4">
                                            {{ $department->pivot->added_at->diffForHumans() }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                <x-modals.unauthorize-position
                                                    class="ms-3 font-medium text-red-600 hover:underline dark:text-red-500"
                                                    :position="$position"
                                                    :department="$department">Remove</x-unauthorize-position>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center text-lg"
                                            colspan="5">
                                            <object class="mx-auto w-full p-10 sm:h-72 sm:w-72 sm:p-0"
                                                data="{{ asset('assets/illustrations/no-data-animate.svg') }}"></object>
                                            <div class="mb-10">No related departments</div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
