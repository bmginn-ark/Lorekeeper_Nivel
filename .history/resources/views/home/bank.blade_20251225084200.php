@extends('home.layout')

@section('home-title')
    은행
@endsection

@section('home-content')
    {!! breadcrumbs(['Bank' => 'bank']) !!}

    <h1>
        은행
    </h1>

    <h3>재화</h3>
    <div class="card mb-2">
        <ul class="list-group list-group-flush">

            @foreach (Auth::user()->getCurrencies(true) as $currency)
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
    <div class="text-right mb-4">
        <a href="{{ url(Auth::user()->url . '/currency-logs') }}">기록 보기...</a>
    </div>

    <h3>재화 전송</h3>
    <p>자원(아이템, 재화, 캐릭터) 거래의 일환으로 재화를 송금하는 경우 사기를 당하지 않도록 <a href="{{ url('trades/open') }}">거래 시스템</a>를 사용하는 것이 좋습니다    {!! Form::open(['url' => 'bank/transfer']) !!}
    <div class="form-group">
        {!! Form::label('user_id', 'Recipient') !!}
        {!! Form::select('user_id', $userOptions, null, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-6">
                {!! Form::label('quantity', 'Quantity') !!}
                {!! Form::text('quantity', null, ['class' => 'form-control']) !!}
            </div>
            <div class="col-md-6">
                {!! Form::label('currency_id', 'Currency') !!}
                {!! Form::select('currency_id', $currencyOptions, null, ['class' => 'form-control', 'placeholder' => 'Select Currency']) !!}
            </div>
        </div>
    </div>
    <div class="text-right">
        {!! Form::submit('Transfer', ['class' => 'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}
@endsection
