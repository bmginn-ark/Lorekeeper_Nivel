@extends('layouts.app')

@section('title')
    {{ __('Character masterlist') }}
@endsection

@section('sidebar')
    @include('browse._sidebar')
@endsection

@section('content')
    {!! breadcrumbs([__('Character Masterlist') => 'masterlist']) !!}
    <h1>{{ __('Character masterlist') }}</h1>

    @include('browse._masterlist_content', ['characters' => $characters])
@endsection

@section('scripts')
    @include('browse._masterlist_js')
@endsection
