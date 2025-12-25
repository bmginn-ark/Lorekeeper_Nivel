<ul>
    <li class="sidebar-header"><a href="{{ url('sales') }}" class="card-link">분양</a></li>
    <li class="sidebar-section">
        <div class="sidebar-section-header">분양 중</div>
        @foreach ($forsale as $sales)
            @php $salelink = 'sales/'.$sales->slug; @endphp
            <div class="sidebar-item"><a href="{{ $sales->url }}" class="{{ set_active($salelink) }}">{{ $sales->title }}</a></div>
        @endforeach
        @if (isset($saleses))
    <li class="sidebar-section">
        <div class="sidebar-section-header">이 페이지</div>
        @foreach ($saleses as $sales)
            @php $salelink = 'sales/'.$sales->slug; @endphp
            <div class="sidebar-item"><a href="{{ $sales->url }}" class="{{ set_active($salelink) }}">{{ '[' . ($sales->is_open ? 'OPEN' : 'CLOSED') . '] ' . $sales->title }}</a></div>
        @endforeach
    </li>
@else
    <li class="sidebar-section">
        <div class="sidebar-section-header">최근 분양</div>
        @foreach ($recentsales as $sales)
            @php $salelink = 'sales/'.$sales->slug; @endphp
            <div class="sidebar-item"><a href="{{ $sales->url }}" class="{{ set_active($salelink) }}">{{ '[' . ($sales->is_open ? 'OPEN' : 'CLOSED') . '] ' . $sales->title }}</a></div>
        @endforeach
    </li>
    @endif
</ul>
