<ul>
    <li class="sidebar-header"><a href="{{ $user->url }}" class="card-link">{{ Illuminate\Support\Str::limit($user->name, 10, $end = '...') }}</a></li>
    <li class="sidebar-section">
        <div class="sidebar-section-header">갤러리</div>
        <div class="sidebar-item"><a href="{{ $user->url . '/gallery' }}" class="{{ set_active('user/' . $user->name . '/gallery*') }}">갤러리</a></div>
        <div class="sidebar-item"><a href="{{ $user->url . '/favorites' }}" class="{{ set_active('user/' . $user->name . '/favorites*') }}">좋아요</a></div>
        <div class="sidebar-item"><a href="{{ $user->url . '/favorites/own-characters' }}" class="{{ set_active('user/' . $user->name . '/favorites/own-characters*') }}">소유 캐릭터 좋아요</a></div>
    </li>
    <li class="sidebar-section">
        <div class="sidebar-section-header">유저</div>
        <div class="sidebar-item"><a href="{{ $user->url . '/aliases' }}" class="{{ set_active('user/' . $user->name . '/aliases*') }}">SNS</a></div>
        <div class="sidebar-item"><a href="{{ $user->url . '/characters' }}" class="{{ set_active('user/' . $user->name . '/characters*') }}">캐릭터</a></div>
        @if (isset($sublists) && $sublists->count() > 0)
            @foreach ($sublists as $sublist)
                <div class="sidebar-item"><a href="{{ $user->url . '/sublist/' . $sublist->key }}" class="{{ set_active('user/' . $user->name . '/sublist/' . $sublist->key) }}">{{ $sublist->name }}</a></div>
            @endforeach
        @endif
        <div class="sidebar-item"><a href="{{ $user->url . '/myos' }}" class="{{ set_active('user/' . $user->name . '/myos*') }}">MYO 슬롯</a></div>
        <div class="sidebar-item"><a href="{{ $user->url . '/inventory' }}" class="{{ set_active('user/' . $user->name . '/inventory*') }}">인벤토리</a></div>
        <div class="sidebar-item"><a href="{{ $user->url . '/bank' }}" class="{{ set_active('user/' . $user->name . '/bank*') }}">은행</a></div>
    </li>
    <li class="sidebar-section">
        <div class="sidebar-section-header">History</div>
        <div class="sidebar-item"><a href="{{ $user->url . '/ownership' }}" class="{{ set_active('user/' . $user->name . '/ownership*') }}">소유자 기록</a></div>
        <div class="sidebar-item"><a href="{{ $user->url . '/item-logs' }}" class="{{ set_active('user/' . $user->name . '/item-logs*') }}">아이템 기록s</a></div>
        <div class="sidebar-item"><a href="{{ $user->url . '/currency-logs' }}" class="{{ set_active('user/' . $user->name . '/currency-logs*') }}">재화 기록</a></div>
        <div class="sidebar-item"><a href="{{ $user->url . '/submissions' }}" class="{{ set_active('user/' . $user->name . '/submissions*') }}">제출 기록</a></div>
    </li>

    @if (Auth::check() && Auth::user()->hasPower('edit_user_info'))
        <li class="sidebar-section">
            <div class="sidebar-section-header">관리자</div>
            <div class="sidebar-item"><a href="{{ $user->adminUrl }}">유저 수정</a></div>
        </li>
    @endif
</ul>
