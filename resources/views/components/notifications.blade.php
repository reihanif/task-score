<div {{ $attributes }}>
    <!-- Notifications -->
    <button
        class="relative mr-1 rounded-lg p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-900 focus:ring-4 focus:ring-gray-300 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-600"
        data-dropdown-toggle="notification-dropdown"
        type="button">
        <span class="sr-only">View notifications</span>
        <!-- Bell icon -->
        <svg class="h-6 w-6"
            aria-hidden="true"
            fill="currentColor"
            viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg">
            <path
                d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z">
            </path>
        </svg>
        @if (count(auth()->user()->unreadNotifications) > 0)
            <span class="absolute start-6 top-1 h-3 w-3 rounded-full border-2 border-white bg-red-500 dark:border-gray-800"></span>
        @endif
    </button>
    <!-- Dropdown menu -->
    <div class="z-50 my-4 hidden max-w-sm list-none divide-y divide-gray-100 overflow-hidden rounded-xl bg-white text-base shadow-lg dark:divide-gray-600 dark:bg-gray-700"
        id="notification-dropdown">
        <div class="block bg-gray-50 px-4 py-2 text-center text-base font-medium text-gray-700 dark:bg-gray-700 dark:text-gray-300">
            Notifications
        </div>
        <div class="max-h-96 overflow-y-auto">
            @forelse (auth()->user()->unreadNotifications as $notification)
                <a class="notification-item flex cursor-pointer border-b px-4 py-3 hover:bg-gray-100 dark:border-gray-600 dark:hover:bg-gray-600"
                    data-id="{{ $notification->id }}"
                    data-route="{{ $notification->data['action'] }}">
                    <div class="relative flex-shrink-0">
                        <img class="h-11 w-11 rounded-full"
                            src="https://ui-avatars.com/api/?name={{ urlencode($notification->data['from']) }}&background=0D8ABF&color=fff&bold=true" />
                        @if ($notification->type == 'new-assignment')
                            <div class="absolute -mt-5 ml-6 flex h-5 w-5 items-center justify-center rounded-full border border-white bg-blue-700 dark:border-gray-700">
                                <x-icons.person-fill-check class="h-3 w-3 text-white" />
                            </div>
                        @elseif ($notification->type == 'assignment-submitted')
                            <div class="absolute -mt-5 ml-6 flex h-5 w-5 items-center justify-center rounded-full border border-white bg-yellow-500 dark:border-gray-700">
                                <x-icons.file-import class="h-3 w-3 text-white" />
                            </div>
                        @elseif ($notification->type == 'assignment-approved')
                            <div class="absolute -mt-5 ml-6 flex h-5 w-5 items-center justify-center rounded-full border border-white bg-green-700 dark:border-gray-700">
                                <x-icons.file-check class="h-3 w-3 text-white" />
                            </div>
                        @elseif ($notification->type == 'assignment-rejected')
                            <div class="absolute -mt-5 ml-6 flex h-5 w-5 items-center justify-center rounded-full border border-white bg-red-700 dark:border-gray-700">
                                <x-icons.file class="h-3 w-3 text-white" />
                            </div>
                        @endif
                    </div>
                    <div class="w-full pl-3">
                        <div class="mb-1.5 text-sm font-normal text-gray-500 dark:text-gray-400">
                            {{ Str::of($notification->data['body'])->toHtmlString }}
                        </div>
                        <div class="text-xs font-medium text-blue-600 dark:text-blue-500">
                            {{ $notification->created_at->diffForHumans() }}
                        </div>
                    </div>
                </a>
            @empty
                <a class="flex cursor-default border-b px-4 py-3 hover:bg-gray-100 dark:border-gray-600 dark:hover:bg-gray-600"
                    href="#">
                    <div class="w-80 text-center text-sm text-gray-500 dark:text-gray-400">
                        No notifications
                    </div>
                </a>
            @endforelse
        </div>
        <a class="text-md block bg-gray-50 py-2 text-center font-medium text-gray-900 hover:bg-gray-100 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600 dark:hover:underline"
            href="{{ route('notifications') }}">
            <div class="inline-flex items-center">
                <svg class="mr-2 h-4 w-4 text-gray-500 dark:text-gray-400"
                    aria-hidden="true"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                    <path fill-rule="evenodd"
                        d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                        clip-rule="evenodd"></path>
                </svg>
                View all
            </div>
        </a>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.notification-item').forEach(function(item) {
            item.addEventListener('click', function(event) {
                event.preventDefault();

                let notificationId = this.getAttribute('data-id');
                let route = this.getAttribute('data-route');

                axios.post('/notifications/mark-as-read', {
                    id: notificationId
                }).then(response => {
                    if (response.data.success) {
                        window.open(route, "_self"); // Open route
                    }
                }).catch(error => {
                    console.error(error);
                });
            });
        });
    });
</script>
