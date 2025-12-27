@extends('layouts.app')

@section('title')
    디자인 승인{!! View::hasSection('design-title') ? ' :: ' . trim(View::getSection('design-title')) : '' !!}
@endsection

@section('sidebar')
    @include('character.design._sidebar')
@endsection

@section('content')
    @yield('design-content')
@endsection

@section('scripts')
    @parent
@endsection
