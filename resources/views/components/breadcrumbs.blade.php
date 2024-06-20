<div {{ $attributes }}>
    <nav class="flex"
        aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-2">
            <li class="inline-flex items-center" title="Dashboard">
                <a class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white"
                    href="{{ route('homepage') }}">
                    <svg class="h-3 w-3"
                        aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor"
                        viewBox="0 0 20 20">
                        <path
                            d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                    </svg>
                    @if (count($menus) < 3)
                        <span class="ms-2.5 hidden sm:block">Dashboard</span>
                    @endif
                </a>
            </li>
            @foreach ($menus as $key => $menu)
                <!-- Check if this is not the last item -->
                @if (!$loop->last)
                    <li>
                        <div class="flex items-center">
                            <svg class="mx-1 h-3 w-3 text-gray-400 rtl:rotate-180"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 6 10">
                                <path stroke="currentColor"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="m1 9 4-4-4-4" />
                            </svg>
                            <a class="max-w-48 ms-1 truncate text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white md:ms-2"
                                href="{{ $menu['route'] }}"
                                title="{{ $menu['name'] }}">
                                {{ $menu['name'] }}
                            </a>
                        </div>
                    </li>
                @else
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="mx-1 h-3 w-3 text-gray-400 rtl:rotate-180"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 6 10">
                                <path stroke="currentColor"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="m1 9 4-4-4-4" />
                            </svg>
                            <span title="{{ $menu['name'] }}"
                                class="max-w-40 sm:max-w-96 ms-1 truncate text-sm font-medium text-gray-500 dark:text-gray-400 md:ms-2">{{ $menu['name'] }}</span>
                        </div>
                    </li>
                @endif
            @endforeach
        </ol>
    </nav>
</div>
