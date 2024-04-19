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
@endsection

@section('script')
@endsection