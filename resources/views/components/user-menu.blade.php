<div {{ $attributes }}>
    <div class="items-centers flex"
        x-data="{ expanded: false }">
        <button
            class="inline-flex items-center bg-white text-center text-sm font-medium text-gray-500 dark:bg-gray-800 dark:text-white"
            type="button"
            x-on:click="expanded = ! expanded"
            x-on:keydown.escape="expanded = false">
            <span class="sr-only">Open user menu</span>
            <img class="h-8 w-8 rounded-full"
                src="https://ui-avatars.com/api/?name={{ urlencode(Auth::User()->name) }}&background=0D8ABC&color=fff&bold=true"
                alt="{{ Auth::User()->name }} avatar" />
            <span class="hidden sm:mx-2 sm:block">
                {{ Auth::User()->username }}
            </span>
            <svg class="h-5 w-5 transition"
                aria-hidden="true"
                :class="expanded ? 'rotate-180' : ''"
                fill="currentColor"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                    clip-rule="evenodd">
                </path>
            </svg>
        </button>

        <!-- Dropdown menu -->
        <template x-teleport="nav">
            <div class="min-w-80 w-fit-content absolute right-4 top-12 z-50 my-4 list-none divide-y divide-gray-100 rounded-xl bg-white text-base shadow dark:divide-gray-600 dark:bg-gray-700"
                id="dropdown-user-menu"
                x-show="expanded"
                x-on:click.away="expanded = false"
                x-transition>
                <div class="px-4 py-3">
                    <div class="flex items-center">
                        <img class="h-11 w-11 rounded-full"
                            src="https://ui-avatars.com/api/?name={{ urlencode(Auth::User()->name) }}&background=0D8ABC&color=fff&bold=true"
                            alt="{{ Auth::User()->name }} avatar" />
                        <div class="mx-2">
                            <span class="block text-sm font-semibold text-gray-900 dark:text-white">
                                <div class="inline-flex items-center">
                                    {{ Auth::User()->name }}

                                    @if (Auth::User()->role == 'superadmin')
                                        <span class="ms-2 h-2.5 w-2.5 rounded-full bg-red-500"
                                            data-tooltip-target="tooltip-role">
                                        </span>
                                    @elseif (Auth::User()->role == 'admin')
                                        <span class="ms-2 h-2.5 w-2.5 rounded-full bg-yellow-500"
                                            data-tooltip-target="tooltip-role">
                                        </span>
                                    @elseif (Auth::User()->role == 'user')
                                        <span class="ms-2 h-2.5 w-2.5 rounded-full bg-blue-500"
                                            data-tooltip-target="tooltip-role">
                                        </span>
                                    @elseif (Auth::User()->role == 'guest')
                                        <span class="ms-2 h-2.5 w-2.5 rounded-full bg-gray-500"
                                            data-tooltip-target="tooltip-role">
                                        </span>
                                    @endif

                                    <div class="tooltip invisible absolute z-10 inline-block rounded-lg bg-gray-900 px-3 py-2 text-sm font-medium text-white opacity-0 shadow-sm transition-opacity duration-300"
                                        id="tooltip-role"
                                        role="tooltip">
                                        {{ ucwords(Auth::User()->role) }}
                                        <div class="tooltip-arrow"
                                            data-popper-arrow>
                                        </div>
                                    </div>
                                </div>
                            </span>
                            @if (Auth::User()->position)
                                <span class="block text-sm text-gray-900 dark:text-white">
                                    {{ Auth::User()->position->name }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                <ul class="py-1 text-gray-700 dark:text-gray-300"
                    aria-labelledby="dropdown-user-menu">
                    <li>
                        <a class="block px-4 py-2 text-sm hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                            href="#">My score</a>
                    </li>
                    <li>
                        <a class="block px-4 py-2 text-sm hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                            href="{{ route('account.settings', Auth::User()->id) }}">Account settings</a>
                    </li>
                </ul>
                <ul class="py-1 text-gray-700 dark:text-gray-300"
                    aria-labelledby="dropdown-user-menu">
                    <li>
                        <a class="flex items-center px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                            href="{{ route('notifications') }}">
                            <svg class="mr-2 h-5 w-5 text-gray-400"
                                aria-hidden="true"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z">
                                </path>
                            </svg>
                            My notifications
                        </a>
                    </li>
                </ul>
                <ul class="pb-3 pt-1 text-gray-700 dark:text-gray-300"
                    aria-labelledby="dropdown-user-menu">
                    <li>
                        <a class="flex items-center px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:text-red-500 dark:hover:bg-gray-600"
                            href="{{ route('auth.logout') }}">
                            <svg class="mr-2 h-5 w-5 text-red-500"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="currentColor"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M20 12H8m12 0-4 4m4-4-4-4M9 4H7a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h2" />
                            </svg>
                            Logout
                        </a>
                    </li>
                </ul>
            </div>
        </template>
    </div>
</div>
