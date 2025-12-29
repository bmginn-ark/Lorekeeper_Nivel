<ul>
    <li class="sidebar-header"><a href="{{ url('news') }}" class="card-link">공지</a></li>
    @if (isset($newses))
        <li class="sidebar-section">
            <div class="sidebar-section-header">이 페이지</div>
            @foreach ($newses as $news)
                @php $newslink = 'news/'.$news->slug; @endphp
                <div class="sidebar-item"><a href="{{ $news->url }}" class="{{ set_active($newslink) }}">{{ $news->title }}</a></div>
            @endforeach
        </li>
    @else
        <li class="sidebar-section">
            <div class="sidebar-section-header">최근 공지</div>
            @foreach ($recentnews as $news)
                @php $newslink = 'news/'.$news->slug; @endphp
                <div class="sidebar-item"><a href="{{ $news->url }}" class="{{ set_active($newslink) }}">{{ $news->title }}</a></div>
            @endforeach
        </li>
    @endif
</ul>
