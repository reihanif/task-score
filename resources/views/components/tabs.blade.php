@if ($attributes->get('tabs-type') == 'button')
    <div {{ $attributes }}>
        <div
            class="border-b border-gray-200 text-center text-sm font-medium text-gray-500 dark:border-gray-700 dark:text-gray-400">
            <ul class="-mb-px flex flex-wrap">
                @foreach ($tabs as $tab)
                    <li class="me-2">
                        @if (array_key_exists('badge', $tab))
                            <a class="active inline-block rounded-t-lg border-blue-600 p-4 py-3 text-blue-600 hover:border-b-2 hover:text-gray-600 dark:border-blue-500 dark:text-blue-500"
                                href="#"
                                :class="{
                                    'cursor-default border-b-2 border-blue-600 text-blue-600 dark:border-blue-500 dark:text-blue-500': tab ==
                                        '{{ $tab['route'] }}'
                                }"
                                @click.prevent="tab = '{{ $tab['route'] }}'">
                                {{ $tab['name'] }}
                                <span
                                    class="ms-1 inline-flex h-3 items-center justify-center rounded-full bg-blue-100 px-2 py-3 text-sm font-medium text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                                    {{ $tab['badge'] }}
                                </span>
                            </a>
                        @else
                            <a class="active inline-block rounded-t-lg border-blue-600 p-3.5 text-blue-600 hover:border-b-2 hover:text-gray-600 dark:border-blue-500 dark:text-blue-500"
                                href="#"
                                :class="{
                                    'cursor-default border-b-2 border-blue-600 text-blue-600 dark:border-blue-500 dark:text-blue-500': tab ==
                                        '{{ $tab['route'] }}'
                                }"
                                @click.prevent="tab = '{{ $tab['route'] }}'">
                                {{ $tab['name'] }}
                            </a>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@else
    <div {{ $attributes }}>
        <div
            class="border-b border-gray-200 text-center text-sm font-medium text-gray-500 dark:border-gray-700 dark:text-gray-400">
            <ul class="-mb-px flex flex-wrap">
                @foreach ($tabs as $tab)
                    @if ($tab['state'] == 'default')
                        <li class="me-2">
                            <a class="inline-block rounded-t-lg border-b-2 border-transparent p-4 hover:border-gray-300 hover:text-gray-600 dark:hover:text-gray-300"
                                href="{{ $tab['route'] }}"
                                x-on:click="loading = ! loading">
                                {{ $tab['name'] }}
                            </a>
                        </li>
                    @elseif ($tab['state'] == 'active')
                        <li class="me-2">
                            <a class="active inline-block rounded-t-lg border-b-2 border-blue-600 p-4 text-blue-600 dark:border-blue-500 dark:text-blue-500"
                                href="{{ $tab['route'] }}"
                                aria-current="page"
                                x-on:click="loading = ! loading">
                                {{ $tab['name'] }}
                            </a>
                        </li>
                    @elseif ($tab['state'] == 'disabled')
                        <li>
                            <a class="inline-block cursor-not-allowed rounded-t-lg p-4 text-gray-400 dark:text-gray-500"
                                x-on:click="loading = ! loading">
                                {{ $tab['name'] }}
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
@endif
