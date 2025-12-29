@extends('user.layout')

@section('profile-title')
    {{ $user->name }}의 캐릭터 기록
@endsection

@section('profile-content')
    {!! breadcrumbs(['Users' => 'users', $user->name => $user->url, 'Logs' => $user->url . '/ownership']) !!}

    <h1>
        {!! $user->displayName !!}의 캐릭터 기록
    </h1>

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
                    <div class="logs-table-cell">캐릭터</div>
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
                    @include('user._ownership_log_row', ['log' => $log, 'user' => $user, 'showCharacter' => true])
                </div>
            @endforeach
        </div>
    </div>
    {!! $logs->render() !!}
@endsection
