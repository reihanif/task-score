@extends('layouts.app')

@section('title', 'Organizations Hierarchy')

@section('content')
    <div class="col-span-full flex-row items-center justify-between space-y-3 sm:flex sm:space-x-4 sm:space-y-0">
        <div>
            <h5 class="mr-3 font-semibold dark:text-white">Organizations Hierarchy</h5>
        </div>
    </div>
    <div class="tree flex justify-center text-xs text-gray-900 dark:text-white">
        @include('app.positions.subhierarchy', ['positions' => $positions])
    </div>
@endsection

@section('script')
@endsection
