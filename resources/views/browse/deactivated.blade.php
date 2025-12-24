@extends('layouts.app')

@section('title')
    비활성화된 유저
@endsection

@section('content')
    {!! breadcrumbs(['Users' => 'users', 'Deactivated' => 'deactivated']) !!}
    <h1>비활성화된 유저</h1>

    @if (!$canView)
        {{-- blade-formatter-disable --}}
    @if($key != '0' &&
        ($privacy == 3 ||
        (Auth::check() &&
        ($privacy == 2 ||
        ($privacy == 1 && Auth::user()->isStaff) ||
        ($privacy == 0 && Auth::user()->isAdmin)))))
    {{-- blade-formatter-enable --}}
        <p>이 페이지를 보려면 키가 필요합니다. 비활성화된 사용자를 보려면 아래 키를 입력하세요.</p>
        @if (Request::get('key'))
            <p class="text-danger">키가 틀렸습니다.</p>
        @endif
        {!! Form::open(['method' => 'GET', 'class' => 'form-inline']) !!}
        <div class="form-group mr-3 mb-3">
            {!! Form::text('key', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group mb-3">
            {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
    @else
        <p>이 페이지를 볼 수 없습니다.</p>
    @endif
@else
    {!! $users->render() !!}
    <div class="row ml-md-2">
        <div class="d-flex row flex-wrap col-12 pb-1 px-0 ubt-bottom">
            <div class="col-12 col-md-4 font-weight-bold">닉네임</div>
            <div class="col-4 col-md-2 font-weight-bold">대표 SNS</div>
            <div class="col-4 col-md-3 font-weight-bold">비활성화한 스태프</div>
            <div class="col-4 col-md-2 font-weight-bold">비활성화된 날짜</div>
        </div>
        @foreach ($users as $user)
            <div class="d-flex row flex-wrap col-12 mt-1 pt-1 px-0 ubt-top">
                <div class="col-12 col-md-4 ">{!! $user->displayName !!}</div>
                <div class="col-4 col-md-2">{!! $user->displayAlias !!}</div>
                <div class="col-4 col-md-3">{!! $user->deactivated_by == $user->id ? 'Self' : 'Staff' !!}</div>
                <div class="col-4 col-md-2">{!! pretty_date($user->settings->deactivated_at, false) !!}</div>
            </div>
        @endforeach
    </div>
    {!! $users->render() !!}

    <div class="text-center mt-4 small text-muted">{{ $users->total() }} result{{ $users->total() == 1 ? '' : 's' }}
        found.</div>
    @endif
@endsection
