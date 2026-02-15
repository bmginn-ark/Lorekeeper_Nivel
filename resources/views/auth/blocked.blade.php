@extends('layouts.app')

@section('title')
    {{ __('Blocked') }}
@endsection

@section('content')
    <h3>{{ __('You are not Permitted to access this site.') }}</h3>
    <p>{{ __('You are too young to access this website. Please contact an admin if you believe this is a mistake.') }}</p>
@endsection
