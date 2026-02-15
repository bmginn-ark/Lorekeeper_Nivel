@extends('layouts.app')

@section('title')
    {{ $sublist->name }} {{ __('Masterlist') }}
@endsection

@section('sidebar')
    @include('browse._sidebar')
@endsection

@section('content')
    {!! breadcrumbs([$sublist->name . ' ' . __('Masterlist') => 'sublist/' . $sublist->key]) !!}
    <h1>{{ $sublist->name }} {{ __('Masterlist') }}</h1>

    @include('browse._masterlist_content', ['characters' => $characters])
@endsection

@section('scripts')
    @include('browse._masterlist_js')
@endsection
