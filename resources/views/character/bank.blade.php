@extends('character.layout', ['isMyo' => $character->is_myo_slot])

@section('profile-title')
    {{ $character->fullName }}의 ㅇ은행
@endsection

@section('meta-img')
    {{ $character->image->thumbnailUrl }}
@endsection

@section('profile-content')
    {!! breadcrumbs([
        $character->category->masterlist_sub_id ? $character->category->sublist->name . ' Masterlist' : 'Character masterlist' => $character->category->masterlist_sub_id ? 'sublist/' . $character->category->sublist->key : 'masterlist',
        $character->fullName => $character->url,
        'Bank' => $character->url . '/bank',
    ]) !!}

    @include('character._header', ['character' => $character])

    <h3>
        @if (Auth::check() && Auth::user()->hasPower('edit_inventories'))
            <a href="#" class="float-right btn btn-outline-info btn-sm" id="grantButton" data-toggle="modal" data-target="#grantModal"><i class="fas fa-cog"></i> {{ __('Admin') }}</a>
        @endif
        재화
    </h3>
    @if (count($currencies))
        <div class="card mb-4">
            <ul class="list-group list-group-flush">

                @foreach ($currencies as $currency)
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-lg-2 col-md-3 col-6 text-right">
                                <strong>
                                    <a href="{{ $currency->url }}">
                                        {{ $currency->name }}
                                        @if ($currency->abbreviation)
                                            ({{ $currency->abbreviation }})
                                        @endif
                                    </a>
                                </strong>
                            </div>
                            <div class="col-lg-10 col-md-9 col-6">
                                {{ $currency->quantity }} @if ($currency->has_icon)
                                    {!! $currency->displayIcon !!}
                                @endif
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    @else
        <div class="card mb-4">
            <div class="card-body">
                재화가 없습니다.
            </div>
        </div>
    @endif

    @if (Auth::check() && Auth::user()->id == $character->user_id)
        <h3>
            재화 주기/가져오기
        </h3>
        {!! Form::open(['url' => 'character/' . $character->slug . '/bank/transfer']) !!}
        <div class="form-group">
            <div class="row">
                <div class="col-md-6">
                    <label>{{ Form::radio('action', 'take', true, ['class' => 'take-button']) }} 캐릭터에서 가져오기</label>
                </div>
                <div class="col-md-6">
                    <label>{{ Form::radio('action', 'give', false, ['class' => 'give-button']) }} 캐릭터에게 주기</label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-md-6">
                    {!! Form::label('quantity', '개수') !!}
                    {!! Form::text('quantity', null, ['class' => 'form-control']) !!}
                </div>
                <div class="col-md-6 take">
                    {!! Form::label('currency_id', '재화') !!}
                    {!! Form::select('take_currency_id', $takeCurrencyOptions, null, ['class' => 'form-control', 'placeholder' => 'Select Currency']) !!}
                </div>
                <div class="col-md-6 give hide">
                    {!! Form::label('currency_id', '재화') !!}
                    {!! Form::select('give_currency_id', $giveCurrencyOptions, null, ['class' => 'form-control', 'placeholder' => 'Select Currency']) !!}
                </div>
            </div>
        </div>
        <div class="text-right">
            {!! Form::submit('Transfer', ['class' => 'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
    @endif

    <h3>최근 활동</h3>
    <div class="mb-4 logs-table">
        <div class="logs-table-header">
            <div class="row">
                <div class="col-6 col-md-2">
                    <div class="logs-table-cell">보낸 사람</div>
                </div>
                <div class="col-6 col-md-2">
                    <div class="logs-table-cell">받는 사람</div>
                </div>
                <div class="col-6 col-md-2">
                    <div class="logs-table-cell">재화</div>
                </div>
                <div class="col-6 col-md-4">
                    <div class="logs-table-cell">기록</div>
                </div>
                <div class="col-6 col-md-2">
                    <div class="logs-table-cell">날짜</div>
                </div>
            </div>
        </div>
        <div class="logs-table-body">
            @foreach ($logs as $log)
                <div class="logs-table-row">
                    @include('user._currency_log_row', ['log' => $log, 'owner' => $character])
                </div>
            @endforeach
        </div>
    </div>
    <div class="text-right">
        <a href="{{ url($character->url . '/currency-logs') }}">전체 보기...</a>
    </div>

    @if (Auth::check() && Auth::user()->hasPower('edit_inventories'))
        <div class="modal fade" id="grantModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <span class="modal-title h5 mb-0">[ADMIN] 재화 지급/회수</span>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        {!! Form::open(['url' => 'admin/character/' . $character->slug . '/grant']) !!}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('currency_id', 'Currency') !!}
                                    {!! Form::select('currency_id', $currencyOptions, null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('quantity', 'Quantity') !!} {!! add_help('If the value given is less than 0, this will be deducted from the character.') !!}
                                    {!! Form::text('quantity', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('data', 'Reason (Optional)') !!} {!! add_help('A reason for the grant. This will be noted in the logs.') !!}
                            {!! Form::text('data', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="text-right">
                            {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('scripts')
    @parent
    <script>
        $(document).ready(function() {
            $('.take-button').on('click', function() {
                $('.take').removeClass('hide');
                $('.give').addClass('hide');
            })
            $('.give-button').on('click', function() {
                $('.give').removeClass('hide');
                $('.take').addClass('hide');
            })
        });
    </script>
@endsection
