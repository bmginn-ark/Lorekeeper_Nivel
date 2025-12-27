@extends('layouts.app')

@section('title')
    상점{!! View::hasSection('shops-title') ? ' :: ' . trim(View::getSection('shops-title')) : '' !!}
@endsection

@section('sidebar')
    @include('shops._sidebar')
@endsection

@section('content')
    @yield('shops-content')
@endsection

@section('scripts')
    @parent
@endsection
