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

    @if (Auth::User()->role == 'superadmin')
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
    @endif

    @if ($errors->any())
        {{ implode('', $errors->all('<div>:message</div>')) }}
    @endif

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
                            <a class="mt-1 cursor-pointer text-sm font-medium text-blue-600 underline dark:text-blue-500 sm:mt-0"
                                data-modal-target="modal-username"
                                data-modal-show="modal-username"
                                type="button">
                                Change
                            </a>
                            <x-modals.account-settings id="modal-username"
                                data-title="Change {{ $user->username }} username"
                                data-user-id="{{ $user->id }}">
                                <x-forms.input id="input-username"
                                    name="username"
                                    type="text"
                                    value="{{ $user->username }}"
                                    state="initial"
                                    label="Username"
                                    placeholder="Username"
                                    required />
                            </x-modals.account-settings>
                        </div>
                    </div>
                    @if ($user->provider == 'local')
                        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">Password</dt>
                            <div class="flex justify-between sm:col-span-2">
                                <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-400 sm:mt-0">
                                    <a class="mt-1 cursor-pointer text-sm font-medium text-blue-600 underline dark:text-blue-500 sm:mt-0"
                                        data-modal-target="modal-password"
                                        data-modal-show="modal-password"
                                        type="button">
                                        Change Password
                                    </a>
                                    <x-modals.account-settings id="modal-password"
                                        data-title="Change {{ $user->username }} password"
                                        data-user-id="{{ $user->id }}"
                                        body="empty">
                                        <!-- Modal body -->
                                        <form class="p-4 md:p-5"
                                            x-on:submit="loading = ! loading"
                                            x-data="{
                                                password: '',
                                                password_confirmation: '',
                                                isValid: false
                                            }"
                                            action="{{ route('account.change-password', $user->id) }}"
                                            method="post">
                                            @method('put')
                                            @csrf
                                            <div class="mb-5">
                                                <div class="space-y-4">
                                                    <x-forms.input id="input-old-password"
                                                        name="old_password"
                                                        type="password"
                                                        state="initial"
                                                        label="Old Password"
                                                        placeholder="Old password"
                                                        required />
                                                    <div class="space-y-1.5">
                                                        <x-forms.input id="input-password"
                                                            name="password"
                                                            type="password"
                                                            x-model="password"
                                                            state="initial"
                                                            label="New Password"
                                                            placeholder="New password"
                                                            required />
                                                        <div>
                                                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                                                Password requirements :
                                                            </p>
                                                            <ul
                                                                class="max-w-md list-inside list-disc space-y-0 text-sm text-gray-500 dark:text-gray-400">
                                                                <li
                                                                    x-bind:class="{
                                                                        'text-green-500 dark:text-green-400': password
                                                                            .length > 0 && password.length >= 8,
                                                                        'text-red-500 dark:text-red-400': password
                                                                            .length > 0 && password.length < 8
                                                                    }">
                                                                    At least 8 characters
                                                                </li>
                                                                <li
                                                                    x-bind:class="{
                                                                        'text-green-500 dark:text-green-400': password
                                                                            .length > 0 && password.match(/[a-z]+/),
                                                                        'text-red-500 dark:text-red-400': password
                                                                            .length > 0 && !password.match(/[a-z]+/)
                                                                    }">
                                                                    At least one lowercase character
                                                                </li>
                                                                <li
                                                                    x-bind:class="{
                                                                        'text-green-500 dark:text-green-400': password
                                                                            .length > 0 && password.match(/[A-Z]+/),
                                                                        'text-red-500 dark:text-red-400': password
                                                                            .length > 0 && !password.match(/[A-Z]+/)
                                                                    }">
                                                                    At least one uppercase character
                                                                </li>
                                                                <li
                                                                    x-bind:class="{
                                                                        'text-green-500 dark:text-green-400': password
                                                                            .length > 0 && password.match(/[0-9]+/),
                                                                        'text-red-500 dark:text-red-400': password
                                                                            .length > 0 && !password.match(/[0-9]+/)
                                                                    }">
                                                                    At least one number
                                                                </li>
                                                                <li
                                                                    x-bind:class="{
                                                                        'text-green-500 dark:text-green-400': password
                                                                            .length > 0 && password.match(
                                                                                /[^a-zA-Z0-9]+/),
                                                                        'text-red-500 dark:text-red-400': password
                                                                            .length > 0 && !password.match(
                                                                                /[^a-zA-Z0-9]+/)
                                                                    }">
                                                                    Inclusion of at least one special character, e.g., ! @ #
                                                                    ?
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <label
                                                            class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
                                                            for="input-password-confirmation">
                                                            Confirm Password
                                                            <span class="text-red-600 dark:text-red-500">*</span>
                                                        </label>
                                                        <div>
                                                            <input
                                                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 focus:border-blue-600 focus:ring-blue-600 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500 sm:text-sm"
                                                                id="input-password-confirmation"
                                                                name="password_confirmation"
                                                                type="password"
                                                                x-on:keyup="checkPassword"
                                                                x-bind:class="{
                                                                    'border-green-500 dark:border-green-400 focus:border-green-600 focus:ring-green-600 dark:focus:border-green-500 dark:focus:ring-green-500': password ==
                                                                        password_confirmation &&
                                                                        password_confirmation.length > 0,
                                                                    'border-red-500 dark:border-red-400 focus:border-red-600 focus:ring-red-600 dark:focus:border-red-500 dark:focus:ring-red-500': password !==
                                                                        password_confirmation &&
                                                                        password_confirmation.length > 0
                                                                }"
                                                                x-model="password_confirmation"
                                                                placeholder="Re-type new password"
                                                                required>
                                                            <p class="mt-1 text-sm text-red-500 dark:text-red-400"
                                                                x-show="password !== password_confirmation && password_confirmation.length > 0">
                                                                Password doesn't match
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex place-content-end">
                                                <button
                                                    class="inline-flex items-center rounded-lg bg-blue-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                                    type="submit"
                                                    x-show="isValid">
                                                    Save
                                                </button>

                                                <button
                                                    class="cursor-default rounded-lg bg-blue-400 px-5 py-2.5 text-center text-sm font-medium text-white dark:bg-blue-500"
                                                    type="button"
                                                    x-show="!isValid"
                                                    disabled>
                                                    Save
                                                </button>
                                            </div>
                                        </form>
                                    </x-modals.account-settings>
                                </dd>
                            </div>
                        </div>
                    @endif
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">Full name</dt>
                        <div class="flex justify-between sm:col-span-2">
                            <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-400 sm:mt-0">
                                {{ $user->name ?? '-' }}
                            </dd>
                            <a class="mt-1 cursor-pointer text-sm font-medium text-blue-600 underline dark:text-blue-500 sm:mt-0"
                                data-modal-target="modal-name"
                                data-modal-show="modal-name"
                                type="button">
                                Change
                            </a>
                            <x-modals.account-settings id="modal-name"
                                data-title="Change {{ $user->username }} name"
                                data-user-id="{{ $user->id }}">
                                <x-forms.input id="input-name"
                                    name="name"
                                    type="text"
                                    value="{{ $user->name }}"
                                    state="initial"
                                    label="Name"
                                    placeholder="User full name"
                                    required />
                            </x-modals.account-settings>
                        </div>
                    </div>
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">Email address</dt>
                        <div class="flex justify-between sm:col-span-2">
                            <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-400 sm:mt-0">
                                {{ $user->email ?? '-' }}
                            </dd>
                            <a class="mt-1 cursor-pointer text-sm font-medium text-blue-600 underline dark:text-blue-500 sm:mt-0"
                                data-modal-target="modal-email"
                                data-modal-show="modal-email"
                                type="button">
                                Change
                            </a>
                            <x-modals.account-settings id="modal-email"
                                data-title="Change {{ $user->username }} email"
                                data-user-id="{{ $user->id }}">
                                <x-forms.input id="input-email"
                                    name="email"
                                    type="email"
                                    value="{{ $user->email }}"
                                    state="initial"
                                    label="Email"
                                    placeholder="User email"
                                    required />
                            </x-modals.account-settings>
                        </div>
                    </div>
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">Account position</dt>
                        <div class="flex justify-between sm:col-span-2">
                            <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-400 sm:mt-0">
                                {{ $user->position->name ?? '-' }}
                            </dd>
                            @if (Auth::User()->role == 'superadmin')
                                <a class="mt-1 cursor-pointer text-sm font-medium text-blue-600 underline dark:text-blue-500 sm:mt-0"
                                    data-modal-target="modal-position"
                                    data-modal-show="modal-position"
                                    type="button">
                                    Change
                                </a>
                                <x-modals.account-settings id="modal-position"
                                    data-title="Change {{ $user->username }} position"
                                    data-user-id="{{ $user->id }}">
                                    <x-forms.select id="input-position"
                                        name="position_id"
                                        state="initial"
                                        label="Position"
                                        helper="please select a position">
                                        @if ($user->position)
                                            <option value="{{ $user->position->id }}">
                                                {{ ucwords($user->position->name) }}
                                            </option>
                                            @foreach ($positions as $key => $position)
                                                @if ($position->id !== $user->position->id)
                                                    <option value="{{ $position->id }}">{{ $position->name }}</option>
                                                @endif
                                            @endforeach
                                        @else
                                            <option value="">Select user position</option>
                                            @foreach ($positions as $key => $position)
                                                <option value="{{ $position->id }}">{{ $position->name }}</option>
                                            @endforeach
                                        @endif
                                    </x-forms.select>
                                </x-modals.account-settings>
                            @endif
                        </div>
                    </div>
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">
                            Account role

                        </dt>
                        <div class="flex justify-between sm:col-span-2">
                            <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-400 sm:col-span-2 sm:mt-0">
                                {{ ucwords($user->role) }}
                            </dd>
                            @if (Auth::User()->role == 'superadmin')
                                <a class="mt-1 cursor-pointer text-sm font-medium text-blue-600 underline dark:text-blue-500 sm:mt-0"
                                    data-modal-target="modal-role"
                                    data-modal-show="modal-role"
                                    type="button">
                                    Change
                                </a>
                                <x-modals.account-settings id="modal-role"
                                    data-title="Change {{ $user->username }} role"
                                    data-user-id="{{ $user->id }}">
                                    <x-forms.select id="input-role"
                                        name="role"
                                        state="initial"
                                        label="Role"
                                        helper="please select a role"
                                        required>
                                        @if ($user->role)
                                            <option value="{{ $user->role }}">{{ ucwords($user->role) }}</option>
                                        @else
                                            <option value="">Select a role</option>
                                        @endif
                                        @if ('user' !== $user->role)
                                            <option value="user">User</option>
                                        @endif
                                        @if ('admin' !== $user->role)
                                            <option value="admin">Admin</option>
                                        @endif
                                        @if ('superadmin' !== $user->role)
                                            <option value="superadmin">Superadmin</option>
                                        @endif
                                    </x-forms.select>
                                </x-modals.account-settings>
                            @endif
                        </div>
                    </div>
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">
                            Account type
                        </dt>
                        <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-400 sm:col-span-2 sm:mt-0">
                            {{ $user->provider !== 'ldap' ? ucwords($user->provider) : strtoupper($user->provider) }}
                        </dd>
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
    <script>
        function checkPassword() {
            console.log('check');
            this.isValid = this.password.length > 0 &&
                this.password.length >= 8 &&
                this.password == this.password_confirmation &&
                this.password.match(/[A-Z]+/) &&
                this.password.match(/[a-z]+/) &&
                this.password.match(/[0-9]+/) &&
                this.password.match(/[^a-zA-Z0-9]+/);
        }
    </script>
@endsection
