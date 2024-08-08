@extends('layouts.app')

@section('title', 'Create new user')

@section('content')
    <x-breadcrumbs :menus="collect([['name' => 'Users', 'route' => route('users.index')], ['name' => 'Create', 'route' => null]])" />

    <div
        class="border-1 relative mt-1 overflow-x-auto rounded-lg border border-gray-200 p-4 dark:border-gray-700 dark:bg-gray-800">
        <div>
            <h5 class="mr-3 font-semibold dark:text-white">Create User</h5>
            <p class="text-gray-500 dark:text-gray-400">Create a new user with specific role and level</p>
        </div>

        <div class="mt-2 grid gap-2 lg:grid-cols-3 xl:grid-cols-2">
            <form class="space-y-4 lg:col-span-2 xl:col-span-1"
                x-on:submit="loading = ! loading"
                action="{{ route('users.store') }}"
                method="post">
                @csrf
                <div class="grid grid-cols-2 gap-2">
                    <p class="col-span-2 mb-0 block text-sm font-medium text-gray-900 dark:text-white">
                        Type <span class="text-red-600 dark:text-red-500">*</span>
                    </p>
                    <div>
                        <input class="peer hidden"
                            id="type-radio-1"
                            name="provider"
                            type="radio"
                            value="local"
                            onclick="local()"
                            checked>
                        <label
                            class="inline-flex w-full cursor-pointer items-center justify-between rounded-lg border border-gray-200 bg-white p-5 text-gray-900 hover:bg-gray-100 hover:text-gray-900 peer-checked:border-blue-600 peer-checked:text-blue-600 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-500 dark:hover:text-gray-300 dark:peer-checked:text-blue-500"
                            for="type-radio-1">
                            <div class="block">
                                <div class="w-full text-sm font-semibold">Local</div>
                            </div>
                        </label>
                    </div>
                    <div>
                        <input class="peer hidden"
                            id="type-radio-2"
                            name="provider"
                            type="radio"
                            value="ldap"
                            onclick="ldap()">
                        <label
                            class="inline-flex w-full cursor-pointer items-center justify-between rounded-lg border border-gray-200 bg-white p-5 text-gray-900 hover:bg-gray-100 hover:text-gray-900 peer-checked:border-blue-600 peer-checked:text-blue-600 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-500 dark:hover:text-gray-300 dark:peer-checked:text-blue-500"
                            for="type-radio-2">
                            <div class="block">
                                <div class="w-full text-sm font-semibold">LDAP</div>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6 sm:col-span-3">
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
                            id="label-email"
                            for="email">
                            Email
                            <span class="hidden text-red-600 dark:text-red-500">*</span>
                        </label>
                        <div>
                            <input
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 focus:border-blue-600 focus:ring-blue-600 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500 sm:text-sm"
                                id="email"
                                name="email"
                                type="email"
                                placeholder="User email"
                                autocomplete="off"
                                oninput="usernameValue(this)"
                                required>
                        </div>
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <div class="block"
                            id="form-username">
                            <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
                                id="label-username"
                                for="username">
                                Username
                                <span class="text-red-600 dark:text-red-500">*</span>
                            </label>
                            <div>
                                <input
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 focus:border-blue-600 focus:ring-blue-600 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500 sm:text-sm"
                                    id="username"
                                    name="username"
                                    type="text"
                                    placeholder="username">
                            </div>
                        </div>

                        <div id="form-username-placeholder" class="hidden">
                            <!-- Input for interface -->
                            <x-forms.input id="username-placeholder"
                                type="text"
                                state="initial"
                                label="Username"
                                helper="automatically generated from email"
                                placeholder="username"
                                disabled
                                readonly />
                        </div>
                    </div>
                </div>

                <div class="block"
                    id="password-element">
                    <x-forms.input id="password"
                        name="password"
                        type="password"
                        state="initial"
                        label="Password"
                        placeholder="••••••••"
                        required/>
                </div>

                <div>
                    <x-forms.input id="name"
                        name="name"
                        type="text"
                        state="initial"
                        label="Name"
                        placeholder="User full name"
                        required/>
                </div>

                <div>
                    <x-forms.select id="position" state="initial" label="Position" name="position">
                        <option value="">Select a position</option>
                        @foreach ($positions as $position)
                            <option value="{{ $position->id }}">{{ $position->name }}</option>
                        @endforeach
                    </x-forms.select>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        please select a position
                    </p>
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <p class="col-span-2 mb-0 block text-sm font-medium text-gray-900 dark:text-white">
                        Role
                    </p>
                    <div>
                        <input class="peer hidden"
                            id="role-radio-1"
                            name="role"
                            type="radio"
                            value="user"
                            checked />
                        <label
                            class="inline-flex w-full cursor-pointer items-center justify-between rounded-lg border border-gray-200 bg-white p-5 text-gray-900 hover:bg-gray-100 hover:text-gray-900 peer-checked:border-blue-600 peer-checked:text-blue-600 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-500 dark:hover:text-gray-300 dark:peer-checked:text-blue-500"
                            for="role-radio-1">
                            <div class="block">
                                <div class="w-full text-sm font-semibold">User</div>
                            </div>
                        </label>
                    </div>
                    <div>
                        <input class="peer hidden"
                            id="role-radio-2"
                            name="role"
                            type="radio"
                            value="admin" />
                        <label
                            class="inline-flex w-full cursor-pointer items-center justify-between rounded-lg border border-gray-200 bg-white p-5 text-gray-900 hover:bg-gray-100 hover:text-gray-900 peer-checked:border-blue-600 peer-checked:text-blue-600 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-500 dark:hover:text-gray-300 dark:peer-checked:text-blue-500"
                            for="role-radio-2">
                            <div class="block">
                                <div class="w-full text-sm font-semibold">Admin</div>
                            </div>
                        </label>
                    </div>
                </div>

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
        function ldap() {
            document.getElementById('password-element').classList.add("hidden");
            document.getElementById('password').removeAttribute('required');
            document.getElementById('password').value = null;
            document.getElementById('form-username-placeholder').classList.remove("hidden");
            document.getElementById('form-username').classList.add("hidden");
            document.getElementById('username').removeAttribute('required');
            document.getElementById('email').setAttribute('required', true);
            document.getElementById('label-email').getElementsByTagName("span")[0].classList.remove("hidden");
            document.getElementById('label-username').getElementsByTagName("span")[0].classList.add("hidden");
        }

        function local() {
            document.getElementById('password-element').classList.remove('hidden');
            document.getElementById('password').setAttribute('required', true);
            document.getElementById('form-username-placeholder').classList.add("hidden");
            document.getElementById('form-username').classList.remove("hidden");
            document.getElementById('username').setAttribute('required', true);
            document.getElementById('email').removeAttribute('required');
            document.getElementById('label-email').getElementsByTagName("span")[0].classList.add("hidden");
            document.getElementById('label-username').getElementsByTagName("span")[0].classList.remove("hidden");
        }

        function usernameValue(element) {
            var email = element.value;
            if (email.includes('@')) {
                var username = email.split('@')[0];
            } else {
                var username = email;
            }
            document.getElementById('username').value = username;
            document.getElementById('username-placeholder').value = username;
        }
    </script>
@endsection
