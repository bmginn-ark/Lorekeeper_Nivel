@extends('galleries.layout')

@section('gallery-title')
    {{ $gallery->name }}
@endsection

@section('gallery-content')
    <x-admin-edit title="Gallery" :object="$gallery" />
    {!! breadcrumbs(['갤러리' => 'gallery', $gallery->name => 'gallery/' . $gallery->id]) !!}

    <h1>
        {{ $gallery->name }}
        @if (Auth::check() && $gallery->canSubmit(Settings::get('gallery_submissions_open'), Auth::user()))
            <a href="{{ url('gallery/submit/' . $gallery->id) }}" class="btn btn-primary float-right">
                <i class="fas fa-plus mr-1"></i> 제출
            </a>
        @endif
    </h1>

    @if (isset($gallery->start_at) || isset($gallery->end_at))
        <p>
            @if ($gallery->start_at)
                <strong>오픈{{ $gallery->start_at->isFuture() ? ' 예정' : '됨' }}: </strong>{!! pretty_date($gallery->start_at) !!}
            @endif
            {{ $gallery->start_at && $gallery->end_at ? ' ・ ' : '' }}
            @if ($gallery->end_at)
                <strong>마감{{ $gallery->end_at->isFuture() ? ' 예정' : '됨' }}: </strong>{!! pretty_date($gallery->end_at) !!}
            @endif
        </p>
    @endif

    <p>{!! $gallery->description !!}</p>

    @if (!$gallery->submissions_count && $gallery->children->count() && $childSubmissions->count())
        <p>
            이 갤러리에는 직접 제출된 작품이 없습니다. 대신 하위 갤러리의 최근 제출물 일부가 표시되고 있습니다.
            더 많은 작품을 보려면 하위 갤러리 중 하나로 이동해 주세요.
        </p>
    @endif

    <div>
        {!! Form::open(['method' => 'GET', 'class' => 'form-inline justify-content-end']) !!}
        <div class="form-group mr-3 mb-3">
            {!! Form::text('title', Request::get('title'), ['class' => 'form-control', 'placeholder' => '제목']) !!}
        </div>
        <div class="form-group mr-3 mb-3">
            {!! Form::select('prompt_id', $prompts, Request::get('prompt_id'), ['class' => 'form-control']) !!}
        </div>
        <div class="form-group mr-3 mb-3">
            {!! Form::select(
                'sort',
                [
                    'newest' => '최신순',
                    'oldest' => '오래된 순',
                    'alpha' => '알파벳순 (A-Z)',
                    'alpha-reverse' => '알파벳 역순 (Z-A)',
                    'prompt' => '프롬프트별 정렬 (최신 → 오래된)',
                    'prompt-reverse' => '프롬프트별 정렬 (오래된 → 최신)',
                ],
                Request::get('sort') ?: 'category',
                ['class' => 'form-control'],
            ) !!}
        </div>
        <div class="form-group mb-3">
            {!! Form::submit('검색', ['class' => 'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
    </div>

    @if ($gallery->submissions_count)
        {!! $submissions->render() !!}

        <div class="d-flex align-content-around flex-wrap mb-2">
            @foreach ($submissions as $submission)
                @include('galleries._thumb', ['submission' => $submission, 'gallery' => true])
            @endforeach
        </div>

        {!! $submissions->render() !!}
    @elseif($childSubmissions->count())
        <div class="d-flex align-content-around flex-wrap mb-2">
            @foreach ($childSubmissions->orderBy('created_at', 'DESC')->get()->take(20) as $submission)
                @include('galleries._thumb', ['submission' => $submission, 'gallery' => false])
            @endforeach
        </div>
    @else
        <p>제출된 작품이 없습니다!</p>
    @endif

@endsection
