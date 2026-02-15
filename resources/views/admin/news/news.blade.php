@extends('admin.layout')

@section('admin-title')
    {{ __('News') }}
@endsection

@section('admin-content')
    {!! breadcrumbs([__('Admin Panel') => 'admin', __('News') => 'admin/news']) !!}

    <h1>{{ __('News') }}</h1>

    <p>{{ __('You can create new news posts here. Creating a news post alerts every user that there is a new post, unless the post is marked as not viewable (see the post creation page for details).') }}</p>

    <div class="text-right mb-3"><a class="btn btn-primary" href="{{ url('admin/news/create') }}"><i class="fas fa-plus"></i> {{ __('Create New Post') }}</a></div>
    @if (!count($newses))
        <p>{{ __('No news found.') }}</p>
    @else
        {!! $newses->render() !!}
        <div class="mb-4 logs-table">
            <div class="logs-table-header">
                <div class="row">
                    <div class="col-12 col-md-5">
                        <div class="logs-table-cell">{{ __('Title') }}</div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="logs-table-cell">{{ __('Posted At') }}</div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="logs-table-cell">{{ __('Last Edited') }}</div>
                    </div>
                </div>
            </div>
            <div class="logs-table-body">
                @foreach ($newses as $news)
                    <div class="logs-table-row">
                        <div class="row flex-wrap">
                            <div class="col-12 col-md-5">
                                <div class="logs-table-cell">
                                    @if (!$news->is_visible)
                                        @if ($news->post_at)
                                            <i class="fas fa-clock mr-1" data-toggle="tooltip" title="{{ __('This post is scheduled to be posted in the future.') }}"></i>
                                        @else
                                            <i class="fas fa-eye-slash mr-1" data-toggle="tooltip" title="{{ __('This post is hidden.') }}"></i>
                                        @endif
                                    @endif
                                    <a href="{{ $news->url }}">{{ $news->title }}</a>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="logs-table-cell">{!! pretty_date($news->post_at ?: $news->created_at) !!}</div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="logs-table-cell">{!! pretty_date($news->updated_at) !!}</div>
                            </div>
                            <div class="col-12 col-md-1 text-right">
                                <div class="logs-table-cell"><a href="{{ url('admin/news/edit/' . $news->id) }}" class="btn btn-primary py-0 px-2 w-100">{{ __('Edit') }}</a></div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        {!! $newses->render() !!}

        <div class="text-center mt-4 small text-muted">{{ $newses->total() }} {{ $newses->total() == 1 ? __('result') : __('results') }} {{ __('found.') }}</div>
    @endif

@endsection
