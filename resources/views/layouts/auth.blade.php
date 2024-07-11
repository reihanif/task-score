<!DOCTYPE html>
<html class=""
      lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible"
          content="ie=edge">
    <title>{{ config('app.name') }}</title>
    <link type="image/x-icon"
          href="{{ asset('assets/img/logo-pertamina.png') }}"
          rel="icon">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="dark:bg-gray-900">
    @if (Session::has('error'))
        <x-toasts id="alert"
                  state="error">
            {{ Session::get('error') }}
        </x-toasts>
    @endif

    @yield('content')

    @yield('script')
</body>

</html>
