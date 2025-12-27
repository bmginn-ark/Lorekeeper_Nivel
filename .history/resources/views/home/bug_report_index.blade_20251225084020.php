@extends('layouts.app')

@section('title')
    버그 신고
@endsection

@section('content')
    {!! breadcrumbs(['Reports' => 'reports']) !!}
    <h1>
        버그 신고
    </h1>

    <p>현재 진행 중인 '수정 중' 보고서를 확인하여 버그가 아직 수정되지 않았는지 확인해 주세요! 제목이 충분히 설명되지 않았거나 버그와 일치하지 않는 경우 언제든지 새 버그를 만드세요.</p>
    <div class="alert alert-warning">특정 버그 보고서는 남용을 방지하기 위해 종료될 때까지 볼 수 없습니다.</div>

    @if (Auth::check())
        <div class="text-right">
            <a href="{{ url('reports/new') }}" class="btn btn-success">새 신고</a>
        </div>
    @endif
    <br>
    {!! Form::open(['method' => 'GET', 'class' => 'form-inline justify-content-end']) !!}
    <div class="form-group mr-3 mb-3">
        {!! Form::text('url', Request::get('url'), ['class' => 'form-control', 'placeholder' => 'URL / Title']) !!}
    </div>
    <div class="form-group mb-3">
        {!! Form::submit('Search', ['class' => 'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}

    @if (count($reports))
        {!! $reports->render() !!}
        <div class="mb-4 logs-table">
            <div class="logs-table-header">
                <div class="row">
                    <div class="col-6 col-md-4">
                        <div class="logs-table-cell">링크/제목</div>
                    </div>
                    <div class="col-6 col-md-5">
                        <div class="logs-table-cell">제출일</div>
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
        <p>신고를 찾을 수 없습니다.</p>
    @endif

@endsection
