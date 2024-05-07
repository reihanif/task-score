@extends('layouts.app')

@section('title', 'Organizations Hierarchy')

@section('content')
    <div class="col-span-full flex-row items-center justify-between space-y-3 sm:flex sm:space-x-4 sm:space-y-0">
        <div>
            <h5 class="mr-3 font-semibold dark:text-white">Organizations Hierarchy</h5>
        </div>
    </div>
    <div class="tree text-gray-900 dark:text-white">
        <ul>
            @foreach ($positions as $position)
                @if ($position->level == 0)
                    <li>
                        <a href="#">
                            {{ $position->name }}
                        </a>
                        @include('app.positions.subhierarchy', ['subordinates' => $position->direct_subordinates])
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
@endsection

@section('script')
@endsection
