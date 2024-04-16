@extends('layouts.app')

@section('title', 'Edit ' . $user->name)

@section('content')
    <x-breadcrumbs :menus="collect([['name' => 'Users', 'route' => route('users.index')], ['name' => 'Edit', 'route' => null]])" />

    <div
        class="border-1 relative mt-1 overflow-x-auto rounded-lg border border-gray-200 p-4 dark:border-gray-700 dark:bg-gray-800">
        <div>
            <h5 class="mr-3 font-semibold dark:text-white">Edit User</h5>
            <p class="text-gray-500 dark:text-gray-400">Edit and manage a user data</p>
        </div>

        @if ($errors->any())
            <div>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mt-2 grid gap-2 lg:grid-cols-3 xl:grid-cols-2">
            <form class="space-y-4 lg:col-span-2 xl:col-span-1"
                x-on:submit="loading = ! loading"
                action="{{ route('users.update', $user->id) }}"
                method="post">
                @method('put')
                @csrf
                <div class="grid grid-cols-2 gap-2">
                    <p class="col-span-2 mb-0 block text-sm font-medium text-gray-900 dark:text-white">
                        Type
                    </p>
                    <div>
                        <input class="peer hidden"
                            id="type-radio-1"
                            name="type"
                            type="radio"
                            value="ldap"
                            @if (is_null($user->password)) checked @endif
                            disabled>
                        <label
                            class="inline-flex w-full cursor-default items-center justify-between rounded-lg border border-gray-200 bg-white p-5 text-gray-900 peer-checked:border-blue-600 peer-checked:text-blue-600 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:peer-checked:text-blue-500"
                            for="type-radio-1">
                            <div class="block">
                                <div class="w-full text-sm font-semibold">LDAP</div>
                            </div>
                        </label>
                    </div>
                    <div>
                        <input class="peer hidden"
                            id="type-radio-2"
                            name="type"
                            type="radio"
                            value="local"
                            @if (!is_null($user->password)) checked @endif
                            disabled>
                        <label
                            class="inline-flex w-full cursor-default items-center justify-between rounded-lg border border-gray-200 bg-white p-5 text-gray-900 peer-checked:border-blue-600 peer-checked:text-blue-600 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:peer-checked:text-blue-500"
                            for="type-radio-2">
                            <div class="block">
                                <div class="w-full text-sm font-semibold">Local</div>
                            </div>
                        </label>
                    </div>
                </div>

                <div>
                    <x-forms.input id="name"
                        name="name"
                        type="text"
                        value="{{ $user->name }}"
                        state="initial"
                        label="Name"
                        helper=""
                        placeholder="User full name"
                        required/>
                </div>

                <div class="grid grid-cols-6 gap-6">

                    <div class="col-span-6 sm:col-span-3">
                        @if (Auth::User()->role == 'superadmin')
                            <x-forms.input id="email"
                                name="email"
                                type="email"
                                value="{{ $user->email }}"
                                state="initial"
                                label="Email"
                                helper=""
                                placeholder="User email"
                                autocomplete="off"
                                oninput="usernameValue(this)"/>
                        @else
                            <!-- Input for request -->
                            <x-forms.input class="hidden"
                                id="username"
                                name="username"
                                value="{{ $user->username }}"/>
                            <!-- Input for interface -->
                            <x-forms.input id="email"
                                type="email"
                                value="{{ $user->email }}"
                                state="initial"
                                label="Email"
                                helper=""
                                placeholder="User email"
                                autocomplete="off"
                                disabled
                                readonly/>
                        @endif
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <!-- Input for request -->
                        <x-forms.input class="hidden"
                            id="username"
                            name="username"
                            value="{{ $user->username }}"/>

                        <!-- Input for interface -->
                        <x-forms.input id="username-placeholder"
                            type="text"
                            value="{{ $user->username }}"
                            state="initial"
                            label="Username"
                            placeholder="username"
                            disabled
                            readonly/>
                    </div>
                </div>

                <div>
                    <x-forms.select id="position"
                        name="position"
                        state="initial"
                        label="Position"
                        helper="please select a position">
                        @if ($user->position)
                            <option value="{{ $user->position->id }}">{{ ucwords($user->position->name) }}</option>
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
                </div>

                @if (Auth::User()->role == 'superadmin')
                    <div>
                        <x-forms.select id="role"
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
                    </div>
                @endif

                <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
                    <a class="mt-6 rounded-lg border border-gray-200 bg-white px-5 py-2.5 text-center text-sm font-medium text-gray-900 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700 md:col-start-3"
                        href="{{ route('users.index') }}">
                        Cancel
                    </a>
                    <button
                        class="col mt-6 rounded-lg bg-blue-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                        type="submit">
                        Submit
                    </button>
                </div>
            </form>
            <div class="col">
            </div>

        </div>
    </div>
@endsection

@section('script')
    <script>
        window.onload = function() {
            const inputEmail = document.getElementById('email');
            inputEmail.onpaste = e => e.preventDefault();
        };
    </script>
@endsection
