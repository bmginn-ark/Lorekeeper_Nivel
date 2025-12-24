<ul>
    <li class="sidebar-header"><a href="{{ url('shops') }}" class="card-link">상점</a></li>

    @if (Auth::check())
        <li class="sidebar-section">
            <div class="sidebar-section-header">기록</div>
            <div class="sidebar-item"><a href="{{ url('shops/history') }}" class="{{ set_active('shops/history') }}">내 구매 기록</a></div>
            <div class="sidebar-section-header">내 재화</div>
            @foreach (Auth::user()->getCurrencies(true) as $currency)
                <div class="sidebar-item pr-3">{!! $currency->display($currency->quantity) !!}</div>
            @endforeach
        </li>
    @endif

    <li class="sidebar-section">
        <div class="sidebar-section-header">상점</div>
        @foreach ($shops as $shop)
            <div class="sidebar-item"><a href="{{ $shop->url }}" class="{{ set_active('shops/' . $shop->id) }}">{{ $shop->name }}</a></div>
        @endforeach
    </li>
</ul>
