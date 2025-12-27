@extends('user.layout')

@section('profile-title')
    {{ $user->name }}의 은행
@endsection

@section('profile-content')
    {!! breadcrumbs(['Users' => 'users', $user->name => $user->url, 'Bank' => $user->url . '/bank']) !!}

    <h1>
        {!! $user->displayName !!}의 은행
    </h1>

    <h3>재화</h3>
    <div class="card mb-4">
        <ul class="list-group list-group-flush">

            @foreach ($user->getCurrencies(true) as $currency)
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

    <h3>최근 활동</h3>
    <div class="mb-4 logs-table">
        <div class="logs-table-header">
            <div class="row">
                <div class="col-6 col-md-2">
                    <div class="logs-table-cell">보내는 이</div>
                </div>
                <div class="col-6 col-md-2">
                    <div class="logs-table-cell">받는 이</div>
                </div>
                <div class="col-6 col-md-2">
                    <div class="logs-table-cell">재화</div>
                </div>
                <div class="col-6 col-md-4">
                    <div class="logs-table-cell">로그</div>
                </div>
                <div class="col-6 col-md-2">
                    <div class="logs-table-cell">날짜</div>
                </div>
            </div>
        </div>
        <div class="logs-table-body">
            @foreach ($logs as $log)
                <div class="logs-table-row">
                    @include('user._currency_log_row', ['log' => $log, 'owner' => $user])
                </div>
            @endforeach
        </div>
    </div>
    <div class="text-right">
        <a href="{{ url($user->url . '/currency-logs') }}">전체 보기...</a>
    </div>
@endsection
