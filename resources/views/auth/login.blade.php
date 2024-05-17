@extends('layouts.auth')

@section('content')
    <section class="h-dvh">
        <div class="mx-auto flex h-screen flex-col items-center justify-center px-6 py-8 lg:py-0">
            <div
                class="w-full rounded-lg bg-white shadow dark:border dark:border-gray-700 dark:bg-gray-800 sm:max-w-md md:mt-0 xl:p-0">
                <div class="space-y-4 p-6 sm:p-8 md:space-y-6">
                    <a class="flex items-center"
                        href="#">
                        <img class="block h-12 dark:hidden"
                            src="{{ asset('assets/img/logo-horizontal.png') }}"
                            alt="logo">
                        <img class="hidden h-12 dark:block"
                            src="{{ asset('assets/img/logo-horizontal-dark.png') }}"
                            alt="logo">
                    </a>
                    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 dark:text-white md:text-2xl">
                        Sign in to your account
                    </h1>
                    <form class="space-y-6 md:space-y-10"
                        x-data="{ loading: false }"
                        x-on:submit="loading = ! loading"
                        action="{{ route('auth.login') }}"
                        method="post">
                        @csrf
                        <div class="space-y-4 md:space-y-4">
                            <div>
                                <x-forms.input id="username"
                                    name="username"
                                    type="text"
                                    value="{{ old('username') }}"
                                    state="initial"
                                    label="Username"
                                    placeholder="Type your username"
                                    aria-autocomplete="username"
                                    autocomplete="on"
                                    required/>
                            </div>
                            <div>
                                <x-forms.input id="password"
                                    name="password"
                                    type="password"
                                    state="initial"
                                    label="Password"
                                    placeholder="••••••••••••"
                                    aria-autocomplete="password"
                                    autocomplete="on"
                                    required/>
                            </div>
                        </div>
                        <button
                            class="w-full rounded-full bg-blue-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                            type="submit"
                            x-show="! loading">
                            Sign in
                        </button>
                        <button
                            class="inline-flex w-full cursor-wait items-center justify-center rounded-full bg-blue-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                            type="button"
                            x-show="loading"
                            disabled>
                            <svg class="me-3 inline h-4 w-4 animate-spin text-white"
                                role="status"
                                aria-hidden="true"
                                viewBox="0 0 100 101"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                    fill="#E5E7EB" />
                                <path
                                    d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                    fill="currentColor" />
                            </svg>
                            Loading...
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
