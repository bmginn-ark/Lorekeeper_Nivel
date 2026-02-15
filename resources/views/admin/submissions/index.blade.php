@extends('admin.layout')

@section('admin-title')
    {{ $isClaims ? __('Claim Queue') : __('Prompt Queue') }}
@endsection

@section('admin-content')
    @if ($isClaims)
        {!! breadcrumbs([__('Admin Panel') => 'admin', __('Claim Queue') => 'admin/claims/pending']) !!}
    @else
        {!! breadcrumbs([__('Admin Panel') => 'admin', __('Prompt Queue') => 'admin/submissions/pending']) !!}
    @endif

    <h1>
        {{ $isClaims ? __('Claim Queue') : __('Prompt Queue') }}
    </h1>

    <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <a class="nav-link {{ set_active('admin/' . ($isClaims ? 'claims' : 'submissions') . '/pending*') }} {{ set_active('admin/' . ($isClaims ? 'claims' : 'submissions')) }}"
                href="{{ url('admin/' . ($isClaims ? 'claims' : 'submissions') . '/pending') }}">{{ __('Pending') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ set_active('admin/' . ($isClaims ? 'claims' : 'submissions') . '/approved*') }}" href="{{ url('admin/' . ($isClaims ? 'claims' : 'submissions') . '/approved') }}">{{ __('Approved') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ set_active('admin/' . ($isClaims ? 'claims' : 'submissions') . '/rejected*') }}" href="{{ url('admin/' . ($isClaims ? 'claims' : 'submissions') . '/rejected') }}">{{ __('Rejected') }}</a>
        </li>
    </ul>

    {!! Form::open(['method' => 'GET', 'class' => 'form-inline justify-content-end']) !!}
    <div class="form-inline justify-content-end">
        @if (!$isClaims)
            <div class="form-group ml-3 mb-3">
                {!! Form::select('prompt_category_id', $categories, Request::get('prompt_category_id'), ['class' => 'form-control']) !!}
            </div>
        @endif
    </div>
    <div class="form-inline justify-content-end">
        <div class="form-group ml-3 mb-3">
            {!! Form::select(
                'sort',
                [
                    'newest' => __('Newest First'),
                    'oldest' => __('Oldest First'),
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

    {!! $submissions->render() !!}
    <div class="mb-4 logs-table">
        <div class="logs-table-header">
            <div class="row">
                @if (!$isClaims)
                    <div class="col-12 col-md-2">
                        <div class="logs-table-cell">{{ __('Prompt') }}</div>
                    </div>
                @endif
                <div class="col-6 {{ !$isClaims ? 'col-md-2' : 'col-md-3' }}">
                    <div class="logs-table-cell">{{ __('User') }}</div>
                </div>
                <div class="col-6 {{ !$isClaims ? 'col-md-3' : 'col-md-4' }}">
                    <div class="logs-table-cell">{{ __('Link') }}</div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="logs-table-cell">{{ __('Submitted') }}</div>
                </div>
                <div class="col-6 col-md-1">
                    <div class="logs-table-cell">{{ __('Status') }}</div>
                </div>
            </div>
        </div>
        <div class="logs-table-body">
            @foreach ($submissions as $submission)
                <div class="logs-table-row">
                    <div class="row flex-wrap">
                        @if (!$isClaims)
                            <div class="col-12 col-md-2">
                                <div class="logs-table-cell">{!! $submission->prompt->displayName !!}</div>
                            </div>
                        @endif
                        <div class="col-6 {{ !$isClaims ? 'col-md-2' : 'col-md-3' }}">
                            <div class="logs-table-cell">{!! $submission->user->displayName !!}</div>
                        </div>
                        <div class="col-6 {{ !$isClaims ? 'col-md-3' : 'col-md-4' }}">
                            <div class="logs-table-cell">
                                <span class="ubt-texthide"><a href="{{ $submission->url }}">{{ $submission->url }}</a></span>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="logs-table-cell">{!! pretty_date($submission->created_at) !!}</div>
                        </div>
                        <div class="col-3 col-md-1">
                            <div class="logs-table-cell">
                                <span class="btn btn-{{ $submission->status == 'Pending' ? 'secondary' : ($submission->status == 'Approved' ? 'success' : 'danger') }} btn-sm py-0 px-1">{{ __($submission->status) }}</span>
                            </div>
                        </div>
                        <div class="col-3 col-md-1">
                            <div class="logs-table-cell"><a href="{{ $submission->adminUrl }}" class="btn btn-primary btn-sm py-0 px-1">{{ __('Details') }}</a></div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    {!! $submissions->render() !!}
    <div class="text-center mt-4 small text-muted">{{ $submissions->total() }} {{ $submissions->total() == 1 ? __('result') : __('results') }} {{ __('found.') }}</div>
@endsection
