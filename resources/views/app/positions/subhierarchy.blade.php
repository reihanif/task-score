@if (!$positions->isEmpty())
    <ul class="hierarchy pt-5 relative flex">
        @foreach ($positions as $position)
            <li class="hierarchy-list pt-5 pb-0 px-2 after:content-['_'] after:absolute after:top-0 after:right-1/2 after:border-t after:border-gray-300 after:w-1/2 after:h-5 before:content-['_'] before:absolute before:top-0 before:right-1/2 before:border-t before:border-gray-300 before:w-1/2 before:h-5 relative flex flex-col items-center">
                <a href="{{ route('positions.show', $position->id) }}" class="w-fit-content min-w-64 cursor-pointer rounded-lg border border-gray-400 p-4 text-center dark:border-white">
                    <p class="font-semibold whitespace-nowrap">{{ $position->name }}</p>
                    @foreach ($position->permitted_users as $user)
                        <p class="text-xs text-gray-600 dark:text-gray-400">{{ $user->name }}</p>
                    @endforeach
                </a>
                @include('app.positions.subhierarchy', ['positions' => $position->direct_subordinates])
            </li>
        @endforeach
    </ul>
@endif
