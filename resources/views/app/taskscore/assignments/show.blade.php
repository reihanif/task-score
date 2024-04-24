@extends('layouts.app')

@section('title', $assignment->subject)

@section('content')
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
@endsection
