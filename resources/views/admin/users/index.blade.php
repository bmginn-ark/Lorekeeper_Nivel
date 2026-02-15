@extends('admin.layout')

@section('admin-title')
    {{ __('User Index') }}
@endsection

@section('admin-content')
    {!! breadcrumbs([__('Admin Panel') => 'admin', __('User Index') => 'admin/users']) !!}

    <h1>{{ __('User Index') }}</h1>

    <p>{{ __("Click on a user's name to view/edit their information.") }}</p>

    <div>
        {!! Form::open(['method' => 'GET', 'class' => 'form-inline justify-content-end']) !!}
        <div class="form-group mr-sm-3 mb-3">
            {!! Form::text('name', Request::get('name'), ['class' => 'form-control']) !!}
        </div>
        <div class="form-group mr-sm-3 mb-3">
            {!! Form::select('rank_id', $ranks, Request::get('rank_id'), ['class' => 'form-control']) !!}
        </div>
        <div class="form-group mr-3 mb-3">
            {!! Form::select(
                'sort',
                [
                    'alpha' => __('Sort Alphabetically (A-Z)'),
                    'alpha-reverse' => __('Sort Alphabetically (Z-A)'),
                    'alias' => __('Sort by Alias (A-Z)'),
                    'alias-reverse' => __('Sort by Alias (Z-A)'),
                    'rank' => __('Sort by Rank (Default)'),
                    'newest' => __('Newest First'),
                    'oldest' => __('Oldest First'),
                ],
                Request::get('sort') ?: 'category',
                ['class' => 'form-control'],
            ) !!}
        </div>
        <div class="form-group mb-3">
            {!! Form::submit(__('Search'), ['class' => 'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
    </div>

    {!! $users->render() !!}
    <div class="mb-4 logs-table">
        <div class="logs-table-header">
            <div class="row">
                <div class="col-12 col-md-4">
                    <div class="logs-table-cell">{{ __('Username') }}</div>
                </div>
                <div class="col-4 col-md-3">
                    <div class="logs-table-cell">{{ __('Alias') }}</div>
                </div>
                <div class="col-4 col-md-2">
                    <div class="logs-table-cell">{{ __('Rank') }}</div>
                </div>
                <div class="col-4 col-md-3">
                    <div class="logs-table-cell">{{ __('Joined') }}</div>
                </div>
            </div>
        </div>
        <div class="logs-table-body">
            @foreach ($users as $user)
                <div class="logs-table-row">
                    <div class="row flex-wrap">
                        <div class="col-12 col-md-4 ">
                            <div class="logs-table-cell"><a href="{{ $user->adminUrl }}">{!! $user->is_banned ? '<strike>' : '' !!}{{ $user->name }}{!! $user->is_banned ? '</strike>' : '' !!}</a></div>
                        </div>
                        <div class="col-4 col-md-3">
                            <div class="logs-table-cell">{!! $user->displayAlias !!}</div>
                        </div>
                        <div class="col-4 col-md-2">
                            <div class="logs-table-cell">{!! $user->rank->displayName !!}</div>
                        </div>
                        <div class="col-4 col-md-3">
                            <div class="logs-table-cell">{!! pretty_date($user->created_at) !!}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    {!! $users->render() !!}

    <div class="text-center mt-4 small text-muted">{{ $count }} {{ $count == 1 ? __('user') : __('users') }} {{ __('found.') }}</div>
@endsection
