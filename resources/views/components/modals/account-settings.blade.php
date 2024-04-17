<!-- Main modal -->
<div class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden md:inset-0"
    id="{{ $attributes->get('id') }}"
    aria-hidden="true"
    tabindex="-1">
    <div class="relative max-h-full w-full max-w-md p-4">
        <!-- Modal content -->
        <div class="relative rounded-lg bg-white shadow dark:bg-gray-800">
            <!-- Modal header -->
            <div class="flex items-center justify-between rounded-t border-b p-4 dark:border-gray-600 md:p-5">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    {{ $attributes->get('data-title') }}
                </h3>
                <button
                    class="ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-toggle="{{ $attributes->get('id') }}"
                    type="button">
                    <svg class="h-3 w-3"
                        aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            @if ($attributes->get('body') == 'empty')
                {{ $slot }}
            @else
                <!-- Modal body -->
                <form class="p-4 md:p-5"
                    x-on:submit="loading = ! loading"
                    action="{{ is_null($attributes->get('action')) ? route('account.update', $attributes->get('data-user-id')) : $attributes->get('action') }}"
                    method="post">
                    @method('put')
                    @csrf
                    <div class="mb-5">
                        {{ $slot }}
                    </div>
                    <div class="flex place-content-end">
                        <button
                            class="inline-flex items-center rounded-lg bg-blue-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                            type="submit">
                            Save
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>
