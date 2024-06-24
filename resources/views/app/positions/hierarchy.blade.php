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
            @foreach ($positions as $key => $position)
                @if ($position->level == 0)
                    <li>
                        <a href="#">
                            {{ $position->name }}
                        </a>
                        @if (!$position->subordinates->isEmpty())
                            <ul>
                                @foreach ($position->subordinates as $subordinate1)
                                    <li>
                                        <a href="#">
                                            {{ $subordinate1->name }}
                                        </a>
                                        @if (!$subordinate1->subordinates->isEmpty())
                                            <ul>
                                                @foreach ($subordinate1->subordinates as $subordinate2)
                                                    <li>
                                                        <a href="#">
                                                            {{ $subordinate2->name }}
                                                        </a>
                                                        @if (!$subordinate2->subordinates->isEmpty())
                                                            <ul>
                                                                @foreach ($subordinate2->subordinates as $subordinate3)
                                                                    <li>
                                                                        <a href="#">
                                                                            {{ $subordinate3->name }}
                                                                        </a>
                                                                        @if (!$subordinate3->subordinates->isEmpty())
                                                                            <ul>
                                                                                @foreach ($subordinate3->subordinates as $subordinate4)
                                                                                    <li>
                                                                                        <a href="#">
                                                                                            {{ $subordinate4->name }}
                                                                                        </a>
                                                                                    </li>
                                                                                @endforeach
                                                                            </ul>
                                                                        @endif
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
@endsection

@section('script')
@endsection
