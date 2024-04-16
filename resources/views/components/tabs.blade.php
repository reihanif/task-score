<div {{ $attributes }}>
    <div class="border-b border-gray-200 text-center text-sm font-medium text-gray-500 dark:border-gray-700 dark:text-gray-400">
        <ul class="-mb-px flex flex-wrap">
            @foreach ($tabs as $tab)
                @if ($tab['state'] == 'default')
                    <li class="me-2">
                        <a class="inline-block rounded-t-lg border-b-2 border-transparent p-4 hover:border-gray-300 hover:text-gray-600 dark:hover:text-gray-300"
                            href="{{ $tab['route'] }}">
                            {{ $tab['name'] }}
                        </a>
                    </li>
                @elseif ($tab['state'] == 'active')
                    <li class="me-2">
                        <a class="active inline-block rounded-t-lg border-b-2 border-blue-600 p-4 text-blue-600 dark:border-blue-500 dark:text-blue-500"
                            href="{{ $tab['route'] }}"
                            aria-current="page">
                            {{ $tab['name'] }}
                        </a>
                    </li>
                @elseif ($tab['state'] == 'disabled')
                    <li>
                        <a class="inline-block cursor-not-allowed rounded-t-lg p-4 text-gray-400 dark:text-gray-500">
                            {{ $tab['name'] }}
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</div>
