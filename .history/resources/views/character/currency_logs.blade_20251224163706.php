@extends('character.layout', ['isMyo' => $character->is_myo_slot])

@section('profile-title')
    {{ $character->fullName }}의 재화 기록
@endsection

@section('meta-img')
    {{ $character->image->thumbnailUrl }}
@endsection

@section('profile-content')
    {!! breadcrumbs([
        $character->category->masterlist_sub_id ? $character->category->sublist->name . ' Masterlist' : 'Character masterlist' => $character->category->masterlist_sub_id ? 'sublist/' . $character->category->sublist->key : 'masterlist',
        $character->fullName => $character->url,
        'Bank' => $character->url . '/bank',
        'Logs' => $character->url . '/currency-logs',
    ]) !!}

    @include('character._header', ['character' => $character])

    <h3>재화 기록</h3>

    {!! $logs->render() !!}

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
    {!! $logs->render() !!}
@endsection
