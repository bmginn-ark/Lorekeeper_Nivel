@extends('user.layout')

@section('profile-title')
    {{ $user->name }}의 캐릭터
@endsection

@section('profile-content')
    {!! breadcrumbs(['Users' => 'users', $user->name => $user->url, 'Characters' => $user->url . '/characters']) !!}

    <h1>
        {!! $user->displayName !!}의 캐릭터
    </h1>

    @include('user._characters', ['characters' => $characters, 'myo' => false])
@endsection
