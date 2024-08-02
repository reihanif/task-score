<div
    class="border-1 relative overflow-x-hidden rounded-lg border border-gray-200 p-4 dark:border-gray-700 dark:bg-gray-800">
    <div class="flex-row items-center justify-between space-y-3 sm:flex sm:space-x-4 sm:space-y-0">
        <div>
            <h5 class="mr-3 font-semibold dark:text-white">Resolved Assignment</h5>
            <p class="text-gray-500 dark:text-gray-400">View all your resolved assignments
            </p>
        </div>
    </div>

    <div
        class="flex-column flex flex-wrap items-end justify-between space-y-4 bg-white pt-4 dark:bg-gray-800 md:flex-row md:space-y-0">
        <div id="search">
            <label class="sr-only"
                for="table-search-resolved-assignments">Search</label>
            <div class="relative">
                <div class="rtl:inset-r-0 pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3">
                    <x-icons.search class="h-4 w-4 text-gray-500 dark:text-gray-400"></x-icons.search>
                </div>
                <input
                    class="block w-auto rounded-lg border border-gray-300 bg-gray-50 ps-10 pt-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                    id="table-search-resolved-assignments"
                    type="text"
                    placeholder="Search for assignment">
            </div>
        </div>
    </div>
    <div>
        <table class="table-clickable w-full text-left text-sm text-gray-500 rtl:text-right dark:text-gray-400"
            id="resolved-assignments-table">
            <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <x-table-head class="whitespace-nowrap px-3 py-3"
                        scope="col">
                        No
                    </x-table-head>
                    <x-table-head class="px-3 py-3"
                        scope="col">
                        Subject
                    </x-table-head>
                    <x-table-head class="whitespace-nowrap px-3 py-3"
                        scope="col">
                        Taskmaster
                    </x-table-head>
                    <x-table-head class="whitespace-nowrap px-3 py-3"
                        scope="col">
                        Created at
                    </x-table-head>
                    <x-table-head class="whitespace-nowrap px-3 py-3"
                        scope="col">
                        Due
                    </x-table-head>
                    <x-table-head class="whitespace-nowrap px-3 py-3"
                        scope="col">
                        Resolved at
                    </x-table-head>
                    <x-table-head class="whitespace-nowrap px-3 py-3"
                        scope="col">
                        Score
                    </x-table-head>
                </tr>
            </thead>
            <tbody>
                @foreach ($resolved_assignments as $key => $item)
                    <tr class="cursor-pointer border-b bg-white hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-600"
                        data-href="{{ route('taskscore.assignment.show', ['assignment' => $item->assignment->id, 'task' => $item->id]) }}">
                        <th class="whitespace-nowrap px-3 py-4 font-medium text-gray-900 dark:text-white"
                            scope="row">
                            {{ $loop->iteration }}
                        </th>
                        <th class="px-3 py-4 font-medium text-gray-900 dark:text-white"
                            scope="row">
                            {{ $item->uuid }} {{ $item->assignment->subject }}
                        </th>
                        <td class="whitespace-nowrap px-3 py-4">
                            {{ $item->assignment->taskmaster->name }}
                        </td>
                        <td class="whitespace-nowrap px-3 py-4">
                            {{ $item->created_at->format('d F Y H:i') }}
                        </td>
                        <td class="whitespace-nowrap px-3 py-4">
                            {{ $item->due->format('d F Y H:i') }}
                        </td>
                        <td class="whitespace-nowrap px-3 py-4">
                            {{ $item->resolved_at->format('d F Y H:i') }}
                        </td>
                        <td class="whitespace-nowrap px-3 py-4">
                            @if ($item->score() == 100)
                                <div class="flex align-items-center gap-1">
                                    {{ $item->score() . '%' }}
                                    <span>
                                        <svg class="inline-block h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path fill="currentColor" d="M48 128c-17.7 0-32 14.3-32 32s14.3 32 32 32l352 0c17.7 0 32-14.3 32-32s-14.3-32-32-32L48 128zm0 192c-17.7 0-32 14.3-32 32s14.3 32 32 32l352 0c17.7 0 32-14.3 32-32s-14.3-32-32-32L48 320z"/></svg>
                                    </span>
                                </div>
                            @elseif ($item->score() > 100)
                                <div class="flex align-items-center gap-1 text-green-600 dark:text-green-500">
                                    {{ $item->score() . '%'}}
                                    <span>
                                        <svg class="inline-block h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path fill="currentColor" d="M214.6 41.4c-12.5-12.5-32.8-12.5-45.3 0l-160 160c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 141.2 160 448c0 17.7 14.3 32 32 32s32-14.3 32-32l0-306.7L329.4 246.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3l-160-160z"/></svg>
                                    </span>
                                </div>
                            @elseif (!$item->isResolved() && $item->score() < 100)
                                <div>
                                    -
                                </div>
                            @elseif ($item->score() < 100)
                                <div class="flex align-items-center gap-1 text-red-600 dark:text-red-500">
                                    {{ $item->score() . '%' }}
                                    <span>
                                        <svg class="inline-block h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path fill="currentColor" d="M169.4 470.6c12.5 12.5 32.8 12.5 45.3 0l160-160c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L224 370.8 224 64c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 306.7L54.6 265.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l160 160z"/></svg>
                                    </span>
                                </div>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
