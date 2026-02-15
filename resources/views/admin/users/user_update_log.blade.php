@extends('admin.layout')

@section('admin-title')
    {{ __('User Account Updates') }}: {{ $user->name }}
@endsection

@section('admin-content')
    {!! breadcrumbs([__('Admin Panel') => 'admin', __('User Index') => 'admin/users', $user->name => 'admin/users/' . $user->name . '/edit', __('Account Updates') => 'admin/users/' . $user->name . '/updates']) !!}

    <h1>{{ __('User') }}: {!! $user->displayName !!}</h1>
    <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <a class="nav-link" href="{{ $user->adminUrl }}">{{ __('Account') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="{{ url('admin/users/' . $user->name . '/updates') }}">{{ __('Account Updates') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('admin/users/' . $user->name . '/ban') }}">{{ __('Ban') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('admin/users/' . $user->name . '/deactivate') }}">{{ __('Deactivate') }}</a>
        </li>
    </ul>

    <h3>{{ __('Account Updates') }}</h3>
    <p>{{ __("This is a list of changes that have been made to this account's information, whether by the user or by a staff member.") }}</p>

    {!! $logs->render() !!}
    <div class="mb-4 logs-table">
        <div class="logs-table-header">
            <div class="row">
                <div class="col-6 col-md-3">
                    <div class="logs-table-cell">{{ __('Staff Member') }}</div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="logs-table-cell">{{ __('Type') }}</div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="logs-table-cell">{{ __('Data') }}</div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="logs-table-cell">{{ __('Date') }}</div>
                </div>
            </div>
        </div>
        <div class="logs-table-body">
            @foreach ($logs as $log)
                <div class="row">
                    <div class="col-6 col-md-3">
                        <div class="logs-table-cell">{!! $log->staff_id ? $log->staff->displayName : '---' !!}</div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="logs-table-cell">{{ $log->type }}</div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="logs-table-cell">
                            @foreach ($log->data as $key => $value)
                                <div>
                                    @if (is_string($value))
                                        <strong>{{ ucfirst(str_replace('_', ' ', $key)) }}: </strong>{{ $value }}
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="logs-table-cell">{!! format_date($log->created_at) !!}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    {!! $logs->render() !!}
@endsection
