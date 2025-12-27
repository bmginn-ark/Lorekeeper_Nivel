@extends('user.layout')

@section('profile-title')
    {{ $user->name }}의 {{ $sublist->name }}
@endsection

@section('profile-content')
    {!! breadcrumbs(['Users' => 'users', $user->name => $user->url, $sublist->name => $user->url . '/sublist/' . $sublist->key]) !!}

    <h1>
        {!! $user->displayName !!}'s {{ $sublist->name }}
    </h1>

    @include('user._characters', ['characters' => $characters, 'myo' => false])
@endsection
