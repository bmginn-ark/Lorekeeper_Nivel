@extends('layouts.app')

@section('title')
    사이트 공지{!! View::hasSection('news-title') ? ' :: ' . trim(View::getSection('news-title')) : '' !!}
@endsection

@section('sidebar')
    @include('news._sidebar')
@endsection

@section('content')
    @yield('news-content')
@endsection
