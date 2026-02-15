@extends('layouts.app')

@section('title')
    {{ __('MYO Slot Masterlist') }}
@endsection

@section('sidebar')
    @include('browse._sidebar')
@endsection

@section('content')
    {!! breadcrumbs([__('MYO Slot Masterlist') => 'myos']) !!}
    <h1>{{ __('MYO Slot Masterlist') }}</h1>

    @include('browse._masterlist_content', ['characters' => $slots])
@endsection

@section('scripts')
    @include('browse._masterlist_js')
@endsection
