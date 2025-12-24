@extends('layouts.app')

@section('title')
    유저
@endsection

@section('content')
    {!! breadcrumbs(['Users' => 'users']) !!}
    <h1>
        유저 인덱스
        @if ($blacklistLink)
            <a href="{{ url('blacklist') }}" class="btn btn-dark float-right ml-2">블랙리스트</a>
        @endif
        @if ($deactivatedLink || (Auth::check() && Auth::user()->isStaff))
            <a href="{{ url('deactivated-list') }}" class="btn btn-dark float-right">비활성화된 계정</a>
        @endif
    </h1>

    <div>
        {!! Form::open(['method' => 'GET', 'class' => 'form-inline justify-content-end']) !!}
        <div class="form-group mr-3 mb-3">
            {!! Form::text('name', Request::get('name'), ['class' => 'form-control']) !!}
        </div>
        <div class="form-group mr-3 mb-3">
            {!! Form::select('rank_id', $ranks, Request::get('rank_id'), ['class' => 'form-control']) !!}
        </div>
        <div class="form-group mr-3 mb-3">
            {!! Form::select(
                'sort',
                [
                    'alpha' => 'Sort Alphabetically (A-Z)',
                    'alpha-reverse' => 'Sort Alphabetically (Z-A)',
                    'alias' => 'Sort by Alias (A-Z)',
                    'alias-reverse' => 'Sort by Alias (Z-A)',
                    'rank' => 'Sort by Rank (Default)',
                    'newest' => 'Newest First',
                    'oldest' => 'Oldest First',
                ],
                Request::get('sort') ?: 'rank',
                ['class' => 'form-control'],
            ) !!}
        </div>
        <div class="form-group mb-3">
            {!! Form::submit('Search', ['class' => 'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
    </div>
    {!! $users->render() !!}
    <div class="mb-4 logs-table">
        <div class="logs-table-header">
            <div class="row">
                <div class="col-12 col-md-4">
                    <div class="logs-table-cell">닉네임</div>
                </div>
                <div class="col-4 col-md-3">
                    <div class="logs-table-cell">대표 SNS</div>
                </div>
                <div class="col-4 col-md-2">
                    <div class="logs-table-cell">등급</div>
                </div>
                <div class="col-4 col-md-3">
                    <div class="logs-table-cell">가입일</div>
                </div>
            </div>
        </div>
        <div class="logs-table-body">
            @foreach ($users as $user)
                <div class="logs-table-row">
                    <div class="row flex-wrap">
                        <div class="col-12 col-md-4">
                            <div class="logs-table-cell">{!! $user->displayName !!}</div>
                        </div>
                        <div class="col-4 col-md-3">
                            <div class="logs-table-cell">{!! $user->displayAlias !!}</div>
                        </div>
                        <div class="col-4 col-md-2">
                            <div class="logs-table-cell">{!! $user->rank->displayName !!}</div>
                        </div>
                        <div class="col-4 col-md-3">
                            <div class="logs-table-cell">{!! pretty_date($user->created_at, false) !!}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    {!! $users->render() !!}

    <div class="text-center mt-4 small text-muted">{{ $users->total() }} result{{ $users->total() == 1 ? '' : 's' }} found.</div>
@endsection
