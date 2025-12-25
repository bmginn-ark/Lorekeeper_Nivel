@extends('home.layout')

@section('home-title')
    캐릭터 거래
@endsection

@section('home-content')
    {!! breadcrumbs(['Character Transfers' => 'characters/transfers']) !!}

    <h1>
        캐릭터 거래
    </h1>

    <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <a class="nav-link {{ set_active('characters/transfers/incoming*') }}" href="{{ url('characters/transfers/incoming') }}">받은 거래</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ set_active('characters/transfers/outgoing*') }}" href="{{ url('characters/transfers/outgoing') }}">보낸 거래</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ set_active('characters/transfers/completed*') }}" href="{{ url('characters/transfers/completed') }}">완료됨</a>
        </li>
    </ul>

    {!! $transfers->render() !!}
    @foreach ($transfers as $transfer)
        @include('home._transfer', ['transfer' => $transfer])
    @endforeach
    {!! $transfers->render() !!}
@endsection
