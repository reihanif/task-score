@extends('layouts.errors')

@section('title', '500 Internal Server Error')

@section('content')
    <section class="bg-white dark:bg-gray-900">
        <div class="mx-auto max-w-screen-xl px-4 py-8 lg:px-6 lg:py-16">
            <div class="mx-auto max-w-screen-sm text-center">
                <h1 class="mb-4 text-7xl font-extrabold tracking-tight text-blue-600 dark:text-blue-500 lg:text-9xl">
                    500</h1>
                <p class="mb-4 text-3xl font-bold tracking-tight text-gray-900 dark:text-white md:text-4xl">Internal Server
                    Error.</p>
                <p class="mb-4 text-lg font-light text-gray-500 dark:text-gray-400">We are already working to solve the
                    problem. </p>
            </div>
        </div>
    </section>
@endsection
