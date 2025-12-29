<ul>
    <li class="sidebar-header"><a href="{{ url('/') }}" class="card-link">홈</a></li>
    <li class="sidebar-section">
        <div class="sidebar-section-header">인벤토리</div>
        <div class="sidebar-item"><a href="{{ url('characters') }}" class="{{ set_active('characters') }}">내 캐릭터</a></div>
        <div class="sidebar-item"><a href="{{ url('characters/myos') }}" class="{{ set_active('characters/myos') }}">내 MYO 슬롯</a></div>
        <div class="sidebar-item"><a href="{{ url('inventory') }}" class="{{ set_active('inventory*') }}">인벤토리</a></div>
        <div class="sidebar-item"><a href="{{ url('bank') }}" class="{{ set_active('bank*') }}">은행</a></div>
    </li>
    <li class="sidebar-section">
        <div class="sidebar-section-header">활동</div>
        <div class="sidebar-item"><a href="{{ url('submissions') }}" class="{{ set_active('submissions*') }}">프롬프트 제출</a></div>
        <div class="sidebar-item"><a href="{{ url('claims') }}" class="{{ set_active('claims*') }}">수령</a></div>
        <div class="sidebar-item"><a href="{{ url('characters/transfers/incoming') }}" class="{{ set_active('characters/transfers*') }}">캐릭터 거래</a></div>
        <div class="sidebar-item"><a href="{{ url('trades/open') }}" class="{{ set_active('trades/open*') }}">거래</a></div>
        <div class="sidebar-item"><a href="{{ url('comments/liked') }}" class="{{ set_active('comments/liked*') }}">좋아요 한 덧글</a></div>
    </li>
    <li class="sidebar-section">
        <div class="sidebar-section-header">신고</div>
        <div class="sidebar-item"><a href="{{ url('reports') }}" class="{{ set_active('reports*') }}">신고</a></div>
    </li>
</ul>
