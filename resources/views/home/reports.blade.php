@extends('home.layout')

@section('home-title')
    신고
@endsection

@section('home-content')
    {!! breadcrumbs(['Reports' => 'reports']) !!}
    <h1>
        내 신고
    </h1>

    <div class="text-right">
        <a href="{{ url('reports/new') }}" class="btn btn-success">새 리포트</a>
    </div>

    <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <a class="nav-link {{ !Request::get('type') || Request::get('type') == 'pending' ? 'active' : '' }}" href="{{ url('reports') }}">대기중</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::get('type') == 'assigned' ? 'active' : '' }}" href="{{ url('reports') . '?type=assigned' }}">할당됨</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::get('type') == 'closed' ? 'active' : '' }}" href="{{ url('reports') . '?type=closed' }}">닫힘</a>
        </li>
    </ul>

    @if (count($reports))
        {!! $reports->render() !!}
        <div class="mb-4 logs-table">
            <div class="logs-table-header">
                <div class="row">
                    <div class="col-6 col-md-4">
                        <div class="logs-table-cell">링크/제목</div>
                    </div>
                    <div class="col-6 col-md-5">
                        <div class="logs-table-cell">제출됨</div>
                    </div>
                    <div class="col-12 col-md-1">
                        <div class="logs-table-cell">상태</div>
                    </div>
                </div>
            </div>
            <div class="logs-table-body">
                @foreach ($reports as $report)
                    <div class="logs-table-row">
                        @include('home._report', ['report' => $report])
                    </div>
                @endforeach
            </div>
        </div>
        {!! $reports->render() !!}
        <div class="text-center mt-4 small text-muted">{{ $reports->total() }} result{{ $reports->total() == 1 ? '' : 's' }} found.</div>
    @else
        <p>신고가 없습니다.</p>
    @endif

@endsection
