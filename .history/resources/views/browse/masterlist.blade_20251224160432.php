@extends('layouts.app')

@section('title')
    캐릭터 마스터리스트
@endsection

@section('sidebar')
    @include('browse._sidebar')
@endsection

@section('content')
    {!! breadcrumbs(['Character Masterlist' => 'masterlist']) !!}
    <h1>캐릭터 마스터리스트</h1>

    @include('browse._masterlist_content', ['characters' => $characters])
@endsection

@section('scripts')
    @include('browse._masterlist_js')
@endsection
