@if ($submission)
    <ul>
        @foreach ($favorites as $favorite)
            <li>{!! $favorite->user->displayName !!}</li>
        @endforeach
    </ul>
@else
    잘못된 제출이 선택되었습니다.
@endif
