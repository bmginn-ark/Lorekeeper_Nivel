@extends('user.layout', ['user' => isset($user) ? $user : null])

@section('profile-title')
    {{ $user->name }}의 프로필
@endsection

@section('meta-img')
    {{ $user->avatarUrl }}
@endsection

@section('profile-content')
    {!! breadcrumbs(['Users' => 'users', $user->name => $user->url]) !!}

    @if (mb_strtolower($user->name) != mb_strtolower($name))
        <div class="alert alert-info">이 유저는 닉네임을 <strong>{{ $user->name }}</strong>으로 변경하였습니다.</div>
    @endif

    @if ($user->is_banned)
        <div class="alert alert-danger">이 유저는 차단되었습니다.</div>
    @endif

    @if ($user->is_deactivated)
        <div class="alert alert-info text-center">
            <h1>{!! $user->displayName !!}</h1>
            <p>이 계정은 현재 비활성화되어 있습니다. 관리자 또는 사용자의 직접적인 요청으로 인해 비활성화되었습니다. 계정이 재활성화될 때까지 여기에 있는 모든 정보는 숨겨져 있습니다.</p>
            @if (Auth::check() && Auth::user()->isStaff)
                <p class="mb-0">관리자이므로 아래 프로필 내용과 사이드바 내용을 볼 수 있습니다.</p>
            @endif
        </div>
    @endif

    @if (!$user->is_deactivated || (Auth::check() && Auth::user()->isStaff))
        @include('user._profile_content', ['user' => $user, 'deactivated' => $user->is_deactivated])
    @endif

@endsection
