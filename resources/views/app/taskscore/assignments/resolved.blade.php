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
                            {{ $item->score() }}%
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
