@extends('home.layout')

@section('home-title')
    신고 (#{{ $report->id }})
@endsection

@section('home-content')
    {!! breadcrumbs(['Users' => 'users', $user->name => $user->url, 'Report (#' . $report->id . ')' => $report->viewUrl]) !!}

    @if (Auth::user()->id == $report->user->id || Auth::user()->hasPower('manage_reports') || ($report->is_br == 1 && ($report->status == 'Closed' || $report->error_type != 'exploit')))
        @include('home._report_content', ['report' => $report])
    @else
        <div class="alert alert-danger">신고는 비공개입니다. 이 문제가 발생한 경우 지원팀에 문의해주세요.</div>
    @endif
@endsection
