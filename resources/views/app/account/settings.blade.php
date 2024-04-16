@extends('layouts.app')

@section('title', 'Account Settings')

@section('content')
    <div class="col-span-full flex-row items-center justify-between space-y-3 sm:flex sm:space-x-4 sm:space-y-0">
        <div>
            <h5 class="mr-3 font-semibold dark:text-white">Account Settings</h5>
            <x-breadcrumbs class="mt-2"
                :menus="collect([['name' => 'Account Settings', 'route' => null]])" />
        </div>
    </div>

    <x-tabs :tabs="collect([
        [
            'state' => 'default',
            'name' => 'Account Details',
            'route' => '#',
        ],
        [
            'state' => 'active',
            'name' => 'Account Settings',
            'route' => route('account.settings', $user->id),
        ],
        [
            'state' => 'default',
            'name' => 'Manage Permissions',
            'route' => route('account.manage-permissions', $user->id),
        ],
    ])" />

    <div
        class="border-1 relative overflow-x-hidden rounded-lg border border-gray-200 p-4 dark:border-gray-700 dark:bg-gray-800">
        <div>
            <div class="px-4 sm:px-0">
                <h3 class="text-base font-semibold leading-7 text-gray-900 dark:text-white">Account Information</h3>
                <p class="max-w-2xl text-sm leading-6 text-gray-500 dark:text-gray-400">Account details and informations.</p>
            </div>
            <div class="mt-6 border-t border-gray-100 dark:border-gray-700">
                <dl class="divide-y divide-gray-100 dark:divide-gray-700">
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">Username</dt>
                        <div class="flex justify-between sm:col-span-2">
                            <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-400 sm:mt-0">
                                {{ $user->username }}
                            </dd>
                            <a class="mt-1 text-sm font-medium text-blue-600 underline dark:text-blue-500 sm:mt-0"
                                href="#">Change</a>
                        </div>
                    </div>
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">Full Name</dt>
                        <div class="flex justify-between sm:col-span-2">
                            <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-400 sm:mt-0">
                                {{ $user->name ?? '-' }}
                            </dd>
                            <a class="mt-1 text-sm font-medium text-blue-600 underline dark:text-blue-500 sm:mt-0"
                                href="#">Change</a>
                        </div>
                    </div>
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">Email address</dt>
                        <div class="flex justify-between sm:col-span-2">
                            <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-400 sm:mt-0">
                                {{ $user->email ?? '-' }}
                            </dd>
                            <a class="mt-1 text-sm font-medium text-blue-600 underline dark:text-blue-500 sm:mt-0"
                            href="#">Change</a>
                        </div>
                    </div>
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">Account Position</dt>
                        <div class="flex justify-between sm:col-span-2">
                            <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-400 sm:mt-0">
                                {{ $user->position->name ?? '-' }}
                            </dd>
                            <a class="mt-1 text-sm font-medium text-blue-600 underline dark:text-blue-500 sm:mt-0"
                                href="#">Change</a>
                        </div>
                    </div>
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">Account created at</dt>
                        <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-400 sm:col-span-2 sm:mt-0">
                            {{ $user->created_at->format('d F Y, H:i:s') }}
                        </dd>
                    </div>
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">
                            Last login at
                        </dt>
                        <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-400 sm:col-span-2 sm:mt-0">
                            {{ $user->last_login_at->format('d F Y, H:i:s') }}
                        </dd>
                    </div>
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">
                            Last login IP address
                        </dt>
                        <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-400 sm:col-span-2 sm:mt-0">
                            {{ $user->last_login_ip }}
                        </dd>
                    </div>
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">
                            Account Type
                        </dt>
                        <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-400 sm:col-span-2 sm:mt-0">
                            {{ $user->provider !== 'ldap' ? ucwords($user->provider) : strtoupper($user->provider) }}
                        </dd>
                    </div>
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">
                            Account role

                        </dt>
                        <div class="flex justify-between sm:col-span-2">
                            <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-400 sm:col-span-2 sm:mt-0">
                                {{ ucwords($user->role) }}
                            </dd>
                            <a class="mt-1 text-sm font-medium text-blue-600 underline dark:text-blue-500 sm:mt-0"
                                href="#">Change</a>
                        </div>
                    </div>
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">Attachments</dt>
                        <dd class="mt-2 text-sm text-gray-900 dark:text-gray-400 sm:col-span-2 sm:mt-0">
                            <ul class="divide-y divide-gray-100 rounded-md border border-gray-200 dark:divide-gray-700 dark:border-gray-700"
                                role="list">
                                <li class="flex items-center justify-between py-4 pl-4 pr-5 text-sm leading-6">
                                    <div class="flex w-0 flex-1 items-center">
                                        <svg class="h-5 w-5 flex-shrink-0 text-gray-400"
                                            aria-hidden="true"
                                            viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M15.621 4.379a3 3 0 00-4.242 0l-7 7a3 3 0 004.241 4.243h.001l.497-.5a.75.75 0 011.064 1.057l-.498.501-.002.002a4.5 4.5 0 01-6.364-6.364l7-7a4.5 4.5 0 016.368 6.36l-3.455 3.553A2.625 2.625 0 119.52 9.52l3.45-3.451a.75.75 0 111.061 1.06l-3.45 3.451a1.125 1.125 0 001.587 1.595l3.454-3.553a3 3 0 000-4.242z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <div class="ml-4 flex min-w-0 flex-1 gap-2">
                                            <span class="truncate font-medium">resume_back_end_developer.pdf</span>
                                            <span class="flex-shrink-0 text-gray-400">2.4mb</span>
                                        </div>
                                    </div>
                                    <div class="ml-4 flex-shrink-0">
                                        <a class="font-medium text-indigo-600 hover:text-indigo-500"
                                            href="#">Download</a>
                                    </div>
                                </li>
                                <li class="flex items-center justify-between py-4 pl-4 pr-5 text-sm leading-6">
                                    <div class="flex w-0 flex-1 items-center">
                                        <svg class="h-5 w-5 flex-shrink-0 text-gray-400"
                                            aria-hidden="true"
                                            viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M15.621 4.379a3 3 0 00-4.242 0l-7 7a3 3 0 004.241 4.243h.001l.497-.5a.75.75 0 011.064 1.057l-.498.501-.002.002a4.5 4.5 0 01-6.364-6.364l7-7a4.5 4.5 0 016.368 6.36l-3.455 3.553A2.625 2.625 0 119.52 9.52l3.45-3.451a.75.75 0 111.061 1.06l-3.45 3.451a1.125 1.125 0 001.587 1.595l3.454-3.553a3 3 0 000-4.242z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <div class="ml-4 flex min-w-0 flex-1 gap-2">
                                            <span class="truncate font-medium">coverletter_back_end_developer.pdf</span>
                                            <span class="flex-shrink-0 text-gray-400">4.5mb</span>
                                        </div>
                                    </div>
                                    <div class="ml-4 flex-shrink-0">
                                        <a class="font-medium text-indigo-600 hover:text-indigo-500"
                                            href="#">Download</a>
                                    </div>
                                </li>
                            </ul>
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

    </div>
@endsection

@section('script')
@endsection
