@extends('user.layout')

@section('profile-title')
    {{ $user->name }}의 제출
@endsection

@section('profile-content')
    {!! breadcrumbs(['Users' => 'users', $user->name => $user->url, 'Submissions' => $user->url . '/submissions']) !!}

    <h1>
        {!! $user->displayName !!}의 제출
    </h1>

    {!! $logs->render() !!}
    <div class="mb-4 logs-table">
        <div class="logs-table-header">
            <div class="row">
                <div class="col-12 col-md-2">
                    <div class="logs-table-cell">프롬프트</div>
                </div>
                <div class="col-6 col-md-4">
                    <div class="logs-table-cell">링크</div>
                </div>
                <div class="col-6 col-md-5">
                    <div class="logs-table-cell">날짜</div>
                </div>
            </div>
        </div>
        <div class="logs-table-body">
            @foreach ($logs as $log)
                <div class="logs-table-row">
                    <div class="row flex-wrap">
                        <div class="col-12 col-md-2">
                            <div class="logs-table-cell">
                                {!! $log->prompt_id ? $log->prompt->displayName : '---' !!}
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="logs-table-cell">
                                <span class="ubt-texthide"><a href="{{ $log->url }}">{{ $log->url }}</a></span>
                            </div>
                        </div>
                        <div class="col-6 col-md-5">
                            <div class="logs-table-cell">
                                {!! pretty_date($log->created_at) !!}
                            </div>
                        </div>
                        <div class="col-6 col-md-1">
                            <div class="logs-table-cell">
                                <a href="{{ $log->viewUrl }}" class="btn btn-primary btn-sm py-0 px-1">자세히</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    {!! $logs->render() !!}
@endsection
