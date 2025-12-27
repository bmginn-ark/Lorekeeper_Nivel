<ul>
    <li class="sidebar-header"><a href="{{ url('gallery') }}" class="card-link">갤러리</a></li>

    @auth
        <li class="sidebar-section">
            <div class="sidebar-section-header">내 제출물</div>
            <div class="sidebar-item"><a href="{{ url('gallery/submissions/pending') }}" class="{{ set_active('gallery/submissions*') }}">내 제출 대기열</a></div>
            <div class="sidebar-item"><a href="{{ url('user/' . Auth::user()->name . '/gallery') }}" class="{{ set_active('user/' . Auth::user()->name . '/gallery') }}">내 갤러리</a></div>
            <div class="sidebar-item"><a href="{{ url('user/' . Auth::user()->name . '/favorites') }}" class="{{ set_active('user/' . Auth::user()->name . '/favorites') }}">내 즐겨찾기</a></div>
        </li>
    @endauth

    @if (config('lorekeeper.extensions.show_all_recent_submissions.enable') && config('lorekeeper.extensions.show_all_recent_submissions.links.sidebar'))
        <li class="sidebar-section">
            <div class="sidebar-item"><a href="{{ url('gallery/all') }}" class="{{ set_active('gallery/all') }}">모든 최근 제출물</a></div>
        </li>
    @endif

    @if ($galleryPage && $sideGallery->children->count())
        <li class="sidebar-section">
            <div class="sidebar-section-header">{{ $sideGallery->name }}: Sub-Galleries</div>
            @foreach ($sideGallery->children()->visible()->get() as $child)
                <div class="sidebar-item"><a href="{{ url('gallery/' . $child->id) }}" class="{{ set_active('gallery/' . $child->id) }}">{{ $child->name }}</a></div>
            @endforeach
        </li>
    @endif

    @if ($galleryPage && $sideGallery->siblings() && $sideGallery->siblings->count())
        <li class="sidebar-section">
            <div class="sidebar-section-header">{{ $sideGallery->parent->name }}: Sub-Galleries</div>
            @foreach ($sideGallery->siblings()->visible()->get() as $sibling)
                <div class="sidebar-item"><a href="{{ url('gallery/' . $sibling->id) }}" class="{{ set_active('gallery/' . $sibling->id) }}">{{ $sibling->name }}</a></div>
            @endforeach
        </li>
    @endif

    @if ($galleryPage && $sideGallery->avunculi() && $sideGallery->avunculi->count())
        <li class="sidebar-section">
            <div class="sidebar-section-header">{{ $sideGallery->parent->parent->name }}: Sub-Galleries</div>
            @foreach ($sideGallery->avunculi()->visible()->get() as $avunculus)
                <div class="sidebar-item"><a href="{{ url('gallery/' . $avunculus->id) }}" class="{{ set_active('gallery/' . $avunculus->id) }}">{{ $avunculus->name }}</a></div>
            @endforeach
        </li>
    @endif

    <li class="sidebar-section">
        <div class="sidebar-section-header">Galleries</div>
        @foreach ($sidebarGalleries as $gallery)
            <div class="sidebar-item"><a href="{{ url('gallery/' . $gallery->id) }}" class="{{ set_active('gallery/' . $gallery->id) }}">{{ $gallery->name }}</a></div>
        @endforeach
    </li>
</ul>
