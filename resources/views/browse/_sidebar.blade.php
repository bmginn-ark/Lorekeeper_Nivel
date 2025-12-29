<ul>
    <li class="sidebar-header"><a href="{{ url('masterlist') }}" class="card-link">마스터리스트</a></li>
    <li class="sidebar-section">
        <div class="sidebar-section-header">마스터리스트</div>
        <div class="sidebar-item"><a href="{{ url('masterlist') }}" class="{{ set_active('masterlist*') }}">캐릭터</a></div>
        <div class="sidebar-item"><a href="{{ url('myos') }}" class="{{ set_active('myos*') }}">MYO 슬롯</a></div>
    </li>
    @if (isset($sublists) && $sublists->count() > 0)
        <li class="sidebar-section">
            <div class="sidebar-section-header">하위 마스터리스트</div>
            @foreach ($sublists as $sublist)
                <div class="sidebar-item"><a href="{{ url('sublist/' . $sublist->key) }}" class="{{ set_active('sublist/' . $sublist->key) }}">{{ $sublist->name }}</a></div>
            @endforeach
        </li>
    @endif
</ul>
