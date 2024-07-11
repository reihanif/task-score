@extends('layouts.app')

@section('title', 'Tasklist')

@section('content')
    <div class="col-span-full flex-row items-center justify-between space-y-3 sm:flex sm:space-x-4 sm:space-y-0">
        <div>
            <h5 class="mr-3 font-semibold dark:text-white">Tasklist</h5>
            <x-breadcrumbs class="mt-2"
                :menus="collect([
                    [
                        'name' => 'Tasklist',
                        'route' => null,
                    ],
                ])" />
        </div>
    </div>

    <div class="col-span-2 space-y-4"
        x-data="{ tab: 'submission' }">
        <x-tabs tabs-type="button"
        :tabs="collect([
            [
                'name' => 'Submission',
                'route' => 'submission',
                'badge' => '2',
            ],
            [
                'name' => 'Time Extension',
                'route' => 'time-extension',
                'badge' => '2',
            ],
        ])" />

        @include('app.taskscore.assignments.subordinate-submissions')

        @include('app.taskscore.assignments.subordinate-time-extensions')
    </div>
@endsection

@section('script')

@endsection
