<h1>어서오세요 {!! Auth::user()->displayName !!}님!</h1>
<div class="card mb-4 timestamp">
    <div class="card-body">
        <i class="far fa-clock"></i> {!! format_date(Carbon\Carbon::now()) !!}
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-body text-center">
                <img src="{{ asset('images/account.png') }}" alt="Account" />
                <h5 class="card-title">계정</h5>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><a href="{{ Auth::user()->url }}">프로필</a></li>
                <li class="list-group-item"><a href="{{ url('account/settings') }}">유저 설정</a></li>
                <li class="list-group-item"><a href="{{ url('trades/open') }}">거래</a></li>
            </ul>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-body text-center">
                <img src="{{ asset('images/characters.png') }}" alt="Characters" />
                <h5 class="card-title">캐릭터</h5>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><a href="{{ url('characters') }}">내 캐릭터</a></li>
                <li class="list-group-item"><a href="{{ url('characters/myos') }}">내 MYO 슬롯</a></li>
                <li class="list-group-item"><a href="{{ url('characters/transfers/incoming') }}">캐릭터 거래</a></li>
            </ul>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-body text-center">
                <img src="{{ asset('images/inventory.png') }}" alt="Inventory" />
                <h5 class="card-title">인벤토리</h5>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><a href="{{ url('inventory') }}">내 인벤토리</a></li>
                <li class="list-group-item"><a href="{{ Auth::user()->url . '/item-logs' }}">아이템 로그</a></li>
            </ul>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-body text-center">
                <img src="{{ asset('images/currency.png') }}" alt="Bank" />
                <h5 class="card-title">은행</h5>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><a href="{{ url('bank') }}">은행</a></li>
                <li class="list-group-item"><a href="{{ Auth::user()->url . '/currency-logs' }}">재화 로그</a></li>
            </ul>
        </div>
    </div>
</div>

@include('widgets._recent_gallery_submissions', ['gallerySubmissions' => $gallerySubmissions])
