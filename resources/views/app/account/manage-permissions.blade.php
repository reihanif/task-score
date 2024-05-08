@extends('layouts.app')

@section('title', 'Manage Permissions')

@section('content')
    <div class="col-span-full flex-row items-center justify-between space-y-3 sm:flex sm:space-x-4 sm:space-y-0">
        <div>
            <h5 class="mr-3 font-semibold dark:text-white">Manage Account Permissions</h5>
            <x-breadcrumbs class="mt-2"
                :menus="collect([
                    [
                        'name' => 'Users',
                        'route' => route('users.index'),
                    ],
                    [
                        'name' => 'Manage Permissions',
                        'route' => null,
                    ],
                ])" />
        </div>
    </div>

    <x-tabs :tabs="collect([
        [
            'state' => 'default',
            'name' => 'Account Settings',
            'route' => route('account.settings', $user->id),
        ],
        [
            'state' => 'active',
            'name' => 'Manage Permissions',
            'route' => route('account.manage-permissions', $user->id),
        ],
    ])" />

    <div
        class="border-1 relative overflow-x-hidden rounded-lg border border-gray-200 p-4 dark:border-gray-700 dark:bg-gray-800">
        <div>
            <div class="px-4 sm:px-0">
                <h3 class="text-base font-semibold leading-7 text-gray-900 dark:text-white">Account Permissions</h3>
                <p class="max-w-2xl text-sm leading-6 text-gray-500 dark:text-gray-400">Manage account permissions for
                    certain features.</p>
            </div>
            <form class="mt-6 border-t border-gray-100 dark:border-gray-700"
                x-on:submit="loading = ! loading"
                method="post"
                action="{{ route('account.update-permissions', $user->id) }}">
                @csrf
                @method('put')
                <dl class="divide-y divide-gray-100 dark:divide-gray-700">
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">Manage Users</dt>
                        <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-400 sm:mt-0">
                            <label class="inline-flex cursor-pointer items-center">
                                @if (!$user->permission->manage_user)
                                    <input class="peer sr-only"
                                        name="manage_user"
                                        type="checkbox">
                                @else
                                    <input class="peer sr-only"
                                        name="manage_user"
                                        type="checkbox"
                                        checked>
                                @endif
                                <div
                                    class="peer relative h-6 w-11 rounded-full bg-gray-200 after:absolute after:start-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:border after:border-gray-300 after:bg-white after:transition-all after:content-[''] peer-checked:bg-blue-600 peer-checked:after:translate-x-full peer-checked:after:border-white peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rtl:peer-checked:after:-translate-x-full dark:border-gray-600 dark:bg-gray-700 dark:peer-focus:ring-blue-800">
                                </div>
                            </label>
                        </dd>
                    </div>
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">Manage Departments</dt>
                        <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-400 sm:mt-0">
                            <label class="inline-flex cursor-pointer items-center">
                                @if (!$user->permission->manage_department)
                                    <input class="peer sr-only"
                                        name="manage_department"
                                        type="checkbox">
                                @else
                                    <input class="peer sr-only"
                                        name="manage_department"
                                        type="checkbox"
                                        checked>
                                @endif
                                <div
                                    class="peer relative h-6 w-11 rounded-full bg-gray-200 after:absolute after:start-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:border after:border-gray-300 after:bg-white after:transition-all after:content-[''] peer-checked:bg-blue-600 peer-checked:after:translate-x-full peer-checked:after:border-white peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rtl:peer-checked:after:-translate-x-full dark:border-gray-600 dark:bg-gray-700 dark:peer-focus:ring-blue-800">
                                </div>
                            </label>
                        </dd>
                    </div>
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">Manage Positions</dt>
                        <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-400 sm:col-span-2 sm:mt-0">
                            <label class="inline-flex cursor-pointer items-center">
                                @if (!$user->permission->manage_position)
                                    <input class="peer sr-only"
                                        name="manage_position"
                                        type="checkbox">
                                @else
                                    <input class="peer sr-only"
                                        name="manage_position"
                                        type="checkbox"
                                        checked>
                                @endif
                                <div
                                    class="peer relative h-6 w-11 rounded-full bg-gray-200 after:absolute after:start-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:border after:border-gray-300 after:bg-white after:transition-all after:content-[''] peer-checked:bg-blue-600 peer-checked:after:translate-x-full peer-checked:after:border-white peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rtl:peer-checked:after:-translate-x-full dark:border-gray-600 dark:bg-gray-700 dark:peer-focus:ring-blue-800">
                                </div>
                            </label>
                        </dd>
                    </div>
                    <div class="px-4 pb-0 pt-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white"></dt>
                        <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-400 sm:col-span-2 sm:mt-0">
                            <button
                                class="mb-2 me-2 rounded-lg bg-blue-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                type="submit">Save settings</button>
                        </dd>
                    </div>
                </dl>
            </form>
        </div>

    </div>
@endsection

@section('script')
@endsection
