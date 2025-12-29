@extends('shops.layout')

@section('shops-title')
    내 구매 기록
@endsection

@section('shops-content')
    {!! breadcrumbs(['Shops' => 'shops', 'My Purchase History' => 'history']) !!}

    <h1>
        내 구매 기록
    </h1>

    {!! $logs->render() !!}

    <div class="mb-4 logs-table">
        <div class="logs-table-header">
            <div class="row">
                <div class="col-12 col-md-2">
                    <div class="logs-table-cell">아이템</div>
                </div>
                <div class="col-6 col-md-2">
                    <div class="logs-table-cell">수량</div>
                </div>
                <div class="col-6 col-md-2">
                    <div class="logs-table-cell">상점</div>
                </div>
                <div class="col-6 col-md-2">
                    <div class="logs-table-cell">캐릭터</div>
                </div>
                <div class="col-6 col-md-2">
                    <div class="logs-table-cell">가격</div>
                </div>
                <div class="col-6 col-md-2">
                    <div class="logs-table-cell">날짜</div>
                </div>
            </div>
        </div>
        <div class="logs-table-body">
            @foreach ($logs as $log)
                <div class="logs-table-row">
                    @include('shops._purchase_history_row', ['log' => $log])
                </div>
            @endforeach
        </div>
    </div>
    {!! $logs->render() !!}
@endsection
