@extends('admin.layout')

@section('admin-title')
    {{ __('Gallery Queue') }}
@endsection

@section('admin-content')
    {!! breadcrumbs([__('Admin Panel') => 'admin', __('Gallery Submissions Queue') => 'admin/gallery/submissions/pending']) !!}

    <h1>
        {{ __('Gallery Submission Queue') }}
    </h1>

    <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <a class="nav-link {{ set_active('admin/gallery/submissions/pending*') }} {{ set_active('admin/gallery/submissions') }}" href="{{ url('admin/gallery/submissions/pending') }}">{{ __('Pending') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ set_active('admin/gallery/submissions/accepted*') }}" href="{{ url('admin/gallery/submissions/accepted') }}">{{ __('Accepted') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ set_active('admin/gallery/submissions/rejected*') }}" href="{{ url('admin/gallery/submissions/rejected') }}">{{ __('Rejected') }}</a>
        </li>
    </ul>

    <div>
        {!! Form::open(['method' => 'GET', 'class' => 'form-inline justify-content-end']) !!}
        <div class="form-group mr-sm-3 mb-3">
            {!! Form::select('gallery_id', $galleries, Request::get('gallery_id'), ['class' => 'form-control']) !!}
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
    </div>

    {!! $submissions->render() !!}

    @foreach ($submissions as $key => $submission)
        @include('galleries._queue_submission', ['queue' => true])
    @endforeach

    {!! $submissions->render() !!}
    <div class="text-center mt-4 small text-muted">{{ $submissions->total() }} {{ $submissions->total() == 1 ? __('result') : __('results') }} {{ __('found.') }}</div>
@endsection
