@if (!$subordinates->isEmpty())
    <ul>
        @foreach ($subordinates as $subordinate)
            <li>
                <a href="#">
                    {{ $subordinate->name }}
                </a>
                @include('app.positions.subhierarchy', ['subordinates' => $subordinate->direct_subordinates])
            </li>
        @endforeach
    </ul>
@endif
