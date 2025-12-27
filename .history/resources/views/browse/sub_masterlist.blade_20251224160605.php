@extends('layouts.app')

@section('title')
    {{ $sublist->name }} 마스터리스트
@endsection

@section('sidebar')
    @include('browse._sidebar')
@endsection

@section('content')
    {!! breadcrumbs([$sublist->name . ' Masterlist' => $sublist->key]) !!}
    <h1>{{ $sublist->name }} 마스터리스트</h1>

    @include('browse._masterlist_content', ['characters' => $characters])
@endsection

@section('scripts')
    @include('browse._masterlist_js')
@endsection
