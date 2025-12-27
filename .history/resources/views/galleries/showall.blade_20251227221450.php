@extends('galleries.layout')

@section('gallery-title')
    모든 최근 제출물
@endsection

@section('gallery-content')
    {!! breadcrumbs(['Gallery' => 'gallery', 'All Recent Submissions' => 'gallery/all']) !!}

    <h1>
        모든 최근 제출물
    </h1>

    <p>이 페이지는 갤러리에 관계없이 최근 제출물을 표시합니다.</p>
    @if (!$submissions->count())
        <p>제출물이 없습니다.</p>
    @endif

    <div>
        {!! Form::open(['method' => 'GET', 'class' => 'form-inline justify-content-end']) !!}
        <div class="form-group mr-3 mb-3">
            {!! Form::text('title', Request::get('title'), ['class' => 'form-control', 'placeholder' => 'Title']) !!}
        </div>
        <div class="form-group mr-3 mb-3">
            {!! Form::select('prompt_id', $prompts, Request::get('prompt_id'), ['class' => 'form-control']) !!}
        </div>
        <div class="form-group mr-3 mb-3">
            {!! Form::select(
                'sort',
                [
                    'newest' => 'Newest First',
                    'oldest' => 'Oldest First',
                    'alpha' => 'Sort Alphabetically (A-Z)',
                    'alpha-reverse' => 'Sort Alphabetically (Z-A)',
                    'prompt' => 'Sort by Prompt (Newest to Oldest)',
                    'prompt-reverse' => 'Sort by Prompt (Oldest to Newest)',
                ],
                Request::get('sort') ?: 'category',
                ['class' => 'form-control'],
            ) !!}
        </div>
        <div class="form-group mb-3">
            {!! Form::submit('Search', ['class' => 'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
    </div>

    @if ($submissions->count())
        {!! $submissions->render() !!}

        <div class="d-flex align-content-around flex-wrap mb-2">
            @foreach ($submissions as $submission)
                @include('galleries._thumb', ['submission' => $submission, 'gallery' => true])
            @endforeach
        </div>

        {!! $submissions->render() !!}
    @else
        <p>No submissions found!</p>
    @endif

@endsection
