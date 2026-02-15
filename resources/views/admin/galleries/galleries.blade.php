@extends('admin.layout')

@section('admin-title')
    {{ __('Galleries') }}
@endsection

@section('admin-content')
    {!! breadcrumbs([__('Admin Panel') => 'admin', __('Galleries') => 'admin/data/galleries']) !!}

    <h1>{{ __('Galleries') }}</h1>

    <p>{{ __('This is a list of galleries that art and literature can be submitted to.') }}</p>

    <div class="text-right mb-3"><a class="btn btn-primary" href="{{ url('admin/data/galleries/create') }}"><i class="fas fa-plus"></i> {{ __('Create New Gallery') }}</a></div>

    @if (!count($galleries))
        <p>{{ __('No galleries found.') }}</p>
    @else
        {!! $galleries->render() !!}

        <div class="mb-4 logs-table">
            <div class="logs-table-header">
                <div class="row">
                    <div class="col-6 col-md-1">
                        <div class="logs-table-cell">{{ __('Open') }}</div>
                    </div>
                    <div class="col-6 col-md-2">
                        <div class="logs-table-cell">{{ __('Name') }}</div>
                    </div>
                    <div class="col-6 col-md-1">
                        <div class="logs-table-cell">{{ Settings::get('gallery_submissions_reward_currency') ? __('Rewards') : '' }}</div>
                    </div>
                    <div class="col-6 col-md-2">
                        <div class="logs-table-cell">{{ Settings::get('gallery_submissions_require_approval') ? __('Votes Needed') : '' }}</div>
                    </div>
                    <div class="col-4 col-md-2">
                        <div class="logs-table-cell">{{ __('Start') }}</div>
                    </div>
                    <div class="col-4 col-md-2">
                        <div class="logs-table-cell">{{ __('End') }}</div>
                    </div>
                </div>
            </div>
            <div class="logs-table-body">
                @foreach ($galleries as $gallery)
                    <div class="logs-table-row">
                        @include('admin.galleries._galleries', ['gallery' => $gallery])
                    </div>
                @endforeach
            </div>
        </div>

        {!! $galleries->render() !!}
    @endif

@endsection
