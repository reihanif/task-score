@extends('layouts.app')

@section('title', 'My Assignment')

@section('content')
    <div class="col-span-2 flex-row items-center justify-between space-y-3 sm:flex sm:space-x-4 sm:space-y-0">
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
    </div>

    <div class="col-span-2 space-y-4"
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
                ],
                [
                    'name' => 'Resolved',
                    'route' => 'resolved',
                ],
            ])" />

        <div x-show="tab == 'unresolved'">
            @include('app.taskscore.assignments.unresolved', $unresolved_assignments)
        </div>

        <div x-show="tab == 'pending'">
            @include('app.taskscore.assignments.pending', $pending_assignments)
        </div>


        <div x-show="tab == 'resolved'">
            @include('app.taskscore.assignments.resolved', $resolved_assignments)
        </div>
    </div>

@endsection

@section('script')
@endsection
