<ul>
    <li class="sidebar-header"><a href="{{ $character->url }}" class="card-link">{{ $character->slug }}</a></li>
    <li class="sidebar-section">
        <div class="sidebar-section-header">캐릭터</div>
        <div class="sidebar-item"><a href="{{ $character->url }}" class="{{ set_active('character/' . $character->slug) }}">정보</a></div>
        <div class="sidebar-item"><a href="{{ $character->url . '/profile' }}" class="{{ set_active('character/' . $character->slug . '/profile') }}">프로필</a></div>
        <div class="sidebar-item"><a href="{{ $character->url . '/gallery' }}" class="{{ set_active('character/' . $character->slug . '/gallery') }}">갤러리</a></div>
        <div class="sidebar-item"><a href="{{ $character->url . '/inventory' }}" class="{{ set_active('character/' . $character->slug . '/inventory') }}">인벤토리</a></div>
        <div class="sidebar-item"><a href="{{ $character->url . '/bank' }}" class="{{ set_active('character/' . $character->slug . '/bank') }}">은행</a></div>
    </li>
    <li class="sidebar-section">
        <div class="sidebar-section-header">기록</div>
        <div class="sidebar-item"><a href="{{ $character->url . '/images' }}" class="{{ set_active('character/' . $character->slug . '/images') }}">이미지</a></div>
        <div class="sidebar-item"><a href="{{ $character->url . '/change-log' }}" class="{{ set_active('character/' . $character->slug . '/change-log') }}">수정 기록</a></div>
        <div class="sidebar-item"><a href="{{ $character->url . '/ownership' }}" class="{{ set_active('character/' . $character->slug . '/ownership') }}">소유자 기록</a></div>
        <div class="sidebar-item"><a href="{{ $character->url . '/item-logs' }}" class="{{ set_active('character/' . $character->slug . '/item-logs') }}">아이템 기록</a></div>
        <div class="sidebar-item"><a href="{{ $character->url . '/currency-logs' }}" class="{{ set_active('character/' . $character->slug . '/currency-logs') }}">재화 기록</a></div>
        <div class="sidebar-item"><a href="{{ $character->url . '/submissions' }}" class="{{ set_active('character/' . $character->slug . '/submissions') }}">제출 기록</a></div>
    </li>
    @if (Auth::check() && (Auth::user()->id == $character->user_id || Auth::user()->hasPower('manage_characters')))
        <li class="sidebar-section">
            <div class="sidebar-section-header">설정</div>
            <div class="sidebar-item"><a href="{{ $character->url . '/profile/edit' }}" class="{{ set_active('character/' . $character->slug . '/profile/edit') }}">프로필 수정</a></div>
            <div class="sidebar-item"><a href="{{ $character->url . '/transfer' }}" class="{{ set_active('character/' . $character->slug . '/transfer') }}">전송</a></div>
            @if (Auth::user()->id == $character->user_id)
                <div class="sidebar-item"><a href="{{ $character->url . '/approval' }}" class="{{ set_active('character/' . $character->slug . '/approval') }}">디자인 업데이트</a></div>
            @endif
        </li>
    @endif
</ul>
