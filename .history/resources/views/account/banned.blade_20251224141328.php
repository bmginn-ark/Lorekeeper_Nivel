@extends('layouts.app')

@section('title')
    차단
@endsection

@section('content')
    {!! breadcrumbs(['Banned' => 'banned']) !!}

    <h1>차단</h1>

    <p>사이트 활동이 차단되었습니다 {!! format_date(Auth::user()->settings->banned_at) !!}. {{ Auth::user()->settings->ban_reason ? '사유:' : '' }}</p>

    @if (Auth::user()->settings->ban_reason)
        <div class="alert alert-danger">
            {!! nl2br(htmlentities(Auth::user()->settings->ban_reason)) !!}
        </div>
    @endif

    <p>따라서 사이트 기능을 계속 사용할 수 없습니다. 계정에 연결된 항목, 통화, 문자 및 기타 자산은 다른 사용자에게 이전할 수 없으며, 다른 사용자가 계정으로 자산을 이전할 수도 없습니다. 보류 중인 모든 항목
제출 대기열에서 제출물도 제거되었습니다. </p>
    <p>이 결정이 잘못되었다고 느끼신다면 직원에게 연락해 주시기 바랍니다. 그러나 그들의 최종 판단을 존중해 주시기 바랍니다.</p>
@endsection
