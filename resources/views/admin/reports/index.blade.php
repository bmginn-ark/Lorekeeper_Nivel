@extends('admin.layout')

@section('admin-title')
    {{ __('Report Queue') }}
@endsection

@section('admin-content')
    {!! breadcrumbs([__('Admin Panel') => 'admin', __('Report Queue') => 'admin/reports/pending']) !!}

    <h1>
        {{ __('Report Queue') }}
    </h1>

    <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <a class="nav-link {{ set_active('admin/reports/pending*') }} {{ set_active('admin/reports') }}" href="{{ url('admin/reports/pending') }}">{{ __('Pending') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ set_active('admin/reports/assigned-to-me*') }}" href="{{ url('admin/reports/assigned-to-me') }}">{{ __('Assigned To Me') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ set_active('admin/reports/assigned') }}" href="{{ url('admin/reports/assigned') }}">{{ __('Assigned') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ set_active('admin/reports/closed*') }}" href="{{ url('admin/reports/closed') }}">{{ __('Closed') }}</a>
        </li>
    </ul>

    <div>
        {!! Form::open(['method' => 'GET', 'class' => 'form-inline justify-content-end']) !!}
        <div class="form-inline justify-content-end">
            <div class="form-group ml-3 mb-3">
                {!! Form::select(
                    'sort',
                    [
                        'newest' => __('Newest First'),
                        'oldest' => __('Oldest First'),
                        'bug' => __('Bug Reports'),
                    ],
                    Request::get('sort') ?: 'oldest',
                    ['class' => 'form-control'],
                ) !!}
            </div>
            <div class="form-group ml-3 mb-3">
                {!! Form::submit(__('Search'), ['class' => 'btn btn-primary']) !!}
            </div>
        </div>
        {!! Form::close() !!}
    </div>

    {!! $reports->render() !!}
    <div class="mb-4 logs-table">
        <div class="logs-table-header">
            <div class="row">
                <div class="col-6 col-md-3">
                    <div class="logs-table-cell">{{ __('User') }}</div>
                </div>
                <div class="col-6 col-md-4">
                    <div class="logs-table-cell">{{ __('Url/Title') }}</div>
                </div>
                <div class="col-6 col-md-2">
                    <div class="logs-table-cell">{{ __('Submitted') }}</div>
                </div>
                <div class="col-6 col-md-2">
                    <div class="logs-table-cell">{{ __('Status') }}</div>
                </div>
            </div>
        </div>
        <div class="logs-table-body">
            @foreach ($reports as $report)
                <div class="logs-table-row">
                    <div class="row flex-wrap">
                        <div class="col-6 col-md-3">
                            <div class="logs-table-cell">{!! $report->user->displayName !!}</div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="logs-table-cell">
                                <span class="ubt-texthide">
                                    {{-- check if $report->url is url --}}
                                    @if (filter_var($report->url, FILTER_VALIDATE_URL))
                                        <a href="{{ $report->url }}">
                                    @endif
                                    {{ $report->url }}
                                    @if (filter_var($report->url, FILTER_VALIDATE_URL))
                                        </a>
                                    @endif
                                </span>
                            </div>
                        </div>
                        <div class="col-6 col-md-2">
                            <div class="logs-table-cell">{!! pretty_date($report->created_at) !!}</div>
                        </div>
                        <div class="col-3 col-md-2">
                            <div class="logs-table-cell">
                                <span class="badge badge-{{ $report->status == 'Pending' ? 'secondary' : ($report->status == 'Closed' ? 'success' : 'danger') }}">{{ __($report->status) }}</span>{!! $report->status == 'Assigned' ? ' (' . __('to') . ' ' . $report->staff->displayName . ')' : '' !!}
                            </div>
                        </div>
                        <div class="col-3 col-md-1">
                            <div class="logs-table-cell"><a href="{{ $report->adminUrl }}" class="btn btn-primary btn-sm py-0 px-1">{{ __('Details') }}</a></div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {!! $reports->render() !!}
    <div class="text-center mt-4 small text-muted">{{ $reports->total() }} {{ $reports->total() == 1 ? __('result') : __('results') }} {{ __('found.') }}</div>
@endsection
