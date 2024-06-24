<a class="hover:underline"
    data-popover-target="{{ $attributes->get('id') }}"
    href="{{ $attributes->get('href') }}">
    @if ($attributes->get('type') == 'username')
        {{ $user->username }}
    @else
        {{ $user->name }}
    @endif
</a>

<div class="invisible absolute z-[100] inline-block w-fit rounded-lg border border-gray-200 bg-white text-sm text-gray-500 opacity-0 shadow-sm transition-opacity duration-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400"
    id="{{ $attributes->get('id') }}"
    data-popover
    role="tooltip">
    <div class="p-3">
        <div class="flex items-center">
            <a href="{{ $attributes->get('href') }}">
                <img class="h-11 w-11 min-h-11 min-w-11 rounded-full"
                    src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=0D8ABC&color=fff&bold=true"
                    alt="{{ $user->name }} avatar" />
            </a>
            <div class="ml-2">
                <span class="block text-sm font-semibold text-gray-900 dark:text-white">
                    <div class="inline-flex items-center">
                        {{ $user->name }}
                    </div>
                </span>
                <span class="block text-sm">
                    {{ $user->email }}
                </span>
            </div>
        </div>
        @if ($user->position)
            <div class="mt-2">
                <div class="font-semibold text-gray-500 dark:text-gray-400">Position :</div>
                <a class="hover:underline"
                    href="#">
                    <span>{{ $user->position->name }}</span>
                </a>
            </div>
        @endif
        <div class="mt-2">
            <div class="font-semibold text-gray-500 dark:text-gray-400">Role :</div>
            <span>{{ ucwords($user->role) }}</span>
        </div>
    </div>
    <div data-popper-arrow></div>
</div>
