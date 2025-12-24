@extends('layouts.app')

@section('title')
    MYO 슬롯 마스터리스트
@endsection

@section('sidebar')
    @include('browse._sidebar')
@endsection

@section('content')
    {!! breadcrumbs(['MYO Slot Masterlist' => 'myos']) !!}
    <h1>MYO 슬롯 마스터리스트</h1>

    @include('browse._masterlist_content', ['characters' => $slots])
@endsection

@section('scripts')
    @include('browse._masterlist_js')
@endsection
