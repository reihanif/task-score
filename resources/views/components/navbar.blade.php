<nav class="fixed top-0 z-[32] w-full border-b border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-800">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start rtl:justify-end">
                @if ($sidebar == 'closed')
                    <button class="inline-flex items-center rounded-lg p-2 text-sm text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                        data-drawer-target="sidebar"
                        data-drawer-toggle="sidebar"
                        type="button"
                        aria-controls="sidebar">
                        <span class="sr-only">Open sidebar</span>
                        <x-icons.bars-from-left class="h-6 w-6"></x-icons.bars-from-left>
                    </button>
                @else
                    <button class="block sm:hidden inline-flex items-center rounded-lg p-2 text-sm text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                        data-drawer-target="sidebar"
                        data-drawer-toggle="sidebar"
                        type="button"
                        aria-controls="sidebar">
                        <span class="sr-only">Open sidebar</span>
                        <x-icons.bars-from-left class="h-6 w-6"></x-icons.bars-from-left>
                    </button>
                @endif
                <a class="ms-2 flex md:me-24"
                    href="/"
                    target="_blank">
                    <img class="me-3 block h-10 dark:hidden"
                        src="{{ asset('assets/img/logo-horizontal.png') }}"
                        alt="logo">
                    <img class="me-3 hidden h-10 dark:block"
                        src="{{ asset('assets/img/logo-horizontal-dark.png') }}"
                        alt="logo">
                </a>
            </div>
            <div id="right-pane" class="flex items-center">
                <button class="rounded-lg p-2.5 text-sm text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-700"
                    id="theme-toggle"
                    type="button">
                    <x-icons.moon class="hidden h-5 w-5"
                        id="theme-toggle-dark-icon"></x-icons.moon>
                    <x-icons.sun class="hidden h-5 w-5"
                        id="theme-toggle-light-icon"></x-icons.sun>
                </button>
                <x-notifications class="ms-3"></x-notifications>
                <x-user-menu class="ms-3"></x-user-menu>
            </div>
        </div>
    </div>
</nav>
