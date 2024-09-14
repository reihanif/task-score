@extends('layouts.app')

@section('title', 'My Assignment')

@section('content')
    <div class="col-span-full flex-row items-center justify-between space-y-3 sm:flex sm:space-x-4 sm:space-y-0">
        <div>
            <h5 class="mr-3 font-semibold dark:text-white">My Assignment</h5>
            <x-breadcrumbs class="mt-2"
                           :menus="collect([
                               [
                                   'name' => 'My Assignment',
                                   'route' => null,
                               ],
                           ])" />
        </div>
        <!-- Modal toggle -->
        <button class="flex items-center justify-center rounded-lg bg-blue-700 px-4 py-2 text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                data-modal-target="create-my-assignment-modal"
                data-modal-toggle="create-my-assignment-modal"
                type="button">
            <x-icons.plus class="-ml-1 mr-1 h-6 w-6">
            </x-icons.plus>
            Add Assignment
        </button>
        <!-- Create Modal -->
        @include('app.taskscore.assignments.modals.create-my-assignment')
    </div>

    <div class="col-span-full space-y-4 overflow-x-hidden"
         x-data="{ tab: 'unresolved' }">
        <x-tabs tabs-type="button"
                :tabs="collect([
                    [
                        'name' => 'Unresolved',
                        'route' => 'unresolved',
                        'badge' => $unresolved_assignments->count(),
                    ],
                    [
                        'name' => 'Pending',
                        'route' => 'pending',
                        'badge' => $pending_assignments->count(),
                        'badge-color' => 'yellow',
                    ],
                    [
                        'name' => 'Resolved',
                        'route' => 'resolved',
                    ],
                ])" />

        <div x-show="tab == 'unresolved'">
            @include('app.taskscore.assignments.partials.unresolved', $unresolved_assignments)
        </div>

        <div x-show="tab == 'pending'">
            @include('app.taskscore.assignments.partials.pending', $pending_assignments)
        </div>


        <div x-show="tab == 'resolved'">
            @include('app.taskscore.assignments.partials.resolved', $resolved_assignments)
        </div>
    </div>

@endsection

@section('script')
@endsection
