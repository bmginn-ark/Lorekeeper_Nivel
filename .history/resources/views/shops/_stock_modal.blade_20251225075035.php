@if (!$stock)
    <div class="text-center">잘못된 항목을 선택했습니다.</div>
@else
    <div class="text-center mb-3">
        <div class="mb-1"><a href="{{ $stock->item->idUrl }}"><img class="img-fluid" src="{{ $stock->item->imageUrl }}" alt="{{ $stock->item->name }}" /></a></div>
        <div><a href="{{ $stock->item->idUrl }}"><strong>{{ $stock->item->name }}</strong></a></div>
        <div><strong>가격: </strong> {!! $stock->currency->display($stock->cost) !!}</div>
        @if ($stock->is_limited_stock)
            <div>재고: {{ $stock->quantity }}</div>
        @endif
        @if ($stock->purchase_limit)
            <div class="text-danger">최대 {{ $stock->purchase_limit }}개까지 구매 가능</div>
        @endif
    </div>

    @if ($stock->item->parsed_description)
        <div class="mb-2">
            <a data-toggle="collapse" href="#itemDescription" class="h5">설명 <i class="fas fa-caret-down"></i></a>
            <div class="card collapse show mt-1" id="itemDescription">
                <div class="card-body">
                    {!! $stock->item->parsed_description !!}
                </div>
            </div>
        </div>
    @endif

    @if (Auth::check())
        <h5>
            구매 
            <span class="float-right">
                인벤토리: {{ $userOwned->pluck('count')->sum() }}
            </span>
        </h5>
        @if ($stock->is_limited_stock && $stock->quantity == 0)
            <div class="alert alert-warning mb-0">이 아이템은 매진되었습니다.</div>
        @elseif($purchaseLimitReached)
            <div class="alert alert-warning mb-0">이미 이 아이템을 {{ $stock->purchase_limit }}개까지 구매했습니다.</div>
        @else
            @if ($stock->purchase_limit)
                <div class="alert alert-warning mb-3">이 아이템을 {{ $userPurchaseCount }}번 구매했습니다.</div>
            @endif
            {!! Form::open(['url' => 'shops/buy']) !!}
            {!! Form::hidden('shop_id', $shop->id) !!}
            {!! Form::hidden('stock_id', $stock->id) !!}
            {!! Form::label('quantity', '수량') !!}
            {!! Form::selectRange('quantity', 1, $quantityLimit, 1, ['class' => 'form-control mb-3']) !!}
            @if ($stock->use_user_bank && $stock->use_character_bank)
                <p>사용자 계정 은행이나 캐릭터 은행으로 지불할 수 있습니다. 사용하려는 항목을 선택하십시오.</p>
                <div class="form-group">
                    <div>
                        <label class="h5">{{ Form::radio('bank', 'user', true, ['class' => 'bank-select mr-1']) }} 유저 은행</label>
                    </div>
                    <div>
                        <label class="h5">{{ Form::radio('bank', 'character', false, ['class' => 'bank-select mr-1']) }} 캐릭터 은행</label>
                        <div class="card use-character-bank hide">
                            <div class="card-body">
                                <p>구매할 아이템에 사용할 캐릭터 코드를 입력하십시오.</p>
                                <div class="form-group">
                                    {!! Form::label('slug', 'Character Code') !!}
                                    {!! Form::text('slug', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif($stock->use_user_bank)
                <p>이 항목은 사용자 계정 은행을 사용해 결제됩니다.</p>
                {!! Form::hidden('bank', 'user') !!}
            @elseif($stock->use_character_bank)
                <p>이 항목은 캐릭터 은행을 사용해 결제됩니다. 결제에 사용할 캐릭터 코드를 입력하십시오.</p>
                {!! Form::hidden('bank', 'character') !!}
                <div class="form-group">
                    {!! Form::label('slug', 'Character Code') !!}
                    {!! Form::text('slug', null, ['class' => 'form-control']) !!}
                </div>
            @endif
            <div class="text-right">
                {!! Form::submit('구매', ['class' => 'btn btn-primary']) !!}
            </div>
            {!! Form::close() !!}
        @endif
    @else
        <div class="alert alert-danger">이 항목을 구매하려면 로그인해야 합니다.</div>
    @endif
@endif

@if (Auth::check())
    <script>
        var $useCharacterBank = $('.use-character-bank');
        $('.bank-select').on('click', function(e) {
            if ($('input[name=bank]:checked').val() == 'character')
                $useCharacterBank.removeClass('hide');
            else
                $useCharacterBank.addClass('hide');
        });
    </script>
@endif
