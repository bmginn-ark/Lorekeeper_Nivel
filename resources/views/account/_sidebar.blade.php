<ul>
    <li class="sidebar-header"><a href="{{ url('/') }}" class="card-link">홈</a></li>
    <li class="sidebar-section">
        <div class="sidebar-section-header">계정</div>
        <div class="sidebar-item"><a href="{{ url('notifications') }}" class="{{ set_active('notifications') }}">알림</a></div>
        <div class="sidebar-item"><a href="{{ url('account/settings') }}" class="{{ set_active('account/settings') }}">설정</a></div>
        <div class="sidebar-item"><a href="{{ url('account/aliases') }}" class="{{ set_active('account/aliases') }}">SNS</a></div>
        <div class="sidebar-item"><a href="{{ url('account/bookmarks') }}" class="{{ set_active('account/bookmarks') }}">북마크</a></div>
        <div class="sidebar-item"><a href="{{ url('account/deactivate') }}" class="{{ set_active('account/deactivate') }}">비활성화</a></div>
    </li>
</ul>
