@extends('user.layout')

@section('profile-title')
    {{ $user->name }}의 갤러리
@endsection

@section('profile-content')
    {!! breadcrumbs(['Users' => 'users', $user->name => $user->url, 'Gallery' => $user->url . '/gallery']) !!}

    <h1>
        갤러리
    </h1>

    @if ($user->gallerySubmissions->count())
        {!! $submissions->render() !!}

        <div class="d-flex align-content-around flex-wrap mb-2">
            @foreach ($submissions as $submission)
                @include('galleries._thumb', ['submission' => $submission, 'gallery' => false])
            @endforeach
        </div>

        {!! $submissions->render() !!}
    @else
        <p>제출된 항목이 없습니다!</p>
    @endif

@endsection
