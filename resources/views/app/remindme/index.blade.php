@extends('layouts.app')

@section('title', 'Notification')

@section('content')
    <div class="border-1 relative col-span-2 overflow-x-hidden rounded-lg border border-gray-200 p-4 dark:border-gray-700 dark:bg-gray-800">
        <div class="flex-row items-center justify-between space-y-3 sm:flex sm:space-x-4 sm:space-y-0">
            <div>
                <h5 class="mb-2 font-semibold dark:text-white">Remindme</h5>
                <a href="{{ route('remindme') }}" class="inline-flex rounded-lg border border-gray-200 bg-white px-3 py-2 text-center text-xs font-medium text-gray-500 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700"
                target="_blank">
                    Open in new tab
                </a>
                <a href="{{ route('remindme') }}" class="inline-flex rounded-lg border border-gray-200 bg-white px-3 py-2 text-center text-xs font-medium text-gray-500 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700"
                target="iframe">
                    Open here
                </a>
            </div>
        </div>
    </div>

    <div class="col-span-2 overflow-hidden rounded-lg border border-gray-200 dark:border-gray-700 dark:bg-gray-800">
        <iframe class="w-full" name="iframe" id="iframe"></iframe>
    </div>
@endsection
