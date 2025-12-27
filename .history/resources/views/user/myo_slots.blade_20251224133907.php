@extends('user.layout')

@section('profile-title')
    {{ $user->name }}의 MYO 슬롯
@endsection

@section('profile-content')
    {!! breadcrumbs(['Users' => 'users', $user->name => $user->url, 'MYO Slots' => $user->url . '/myos']) !!}

    <h1>
        {!! $user->displayName !!}의 MYO 슬롯
    </h1>

    @include('user._characters', ['characters' => $myos, 'myo' => true])
@endsection
