<ul>
    <li class="sidebar-header"><a href="{{ $user->url }}" class="card-link">{{ Illuminate\Support\Str::limit($user->name, 10, $end = '...') }}</a></li>
    <li class="sidebar-section">
        <div class="sidebar-item px-2">이 계정은 비활성화 되었습니다.</div>
    </li>
</ul>
