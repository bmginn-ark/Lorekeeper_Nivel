@extends('galleries.layout')

@section('gallery-title')
    갤러리 제출물
@endsection

@section('gallery-content')
    {!! breadcrumbs(['gallery' => 'gallery', 'Gallery Submissions' => 'Gallery/Submissions']) !!}

    <h1>
        갤러리 제출물
    </h1>

    <p>갤러리 제출 로그입니다. 특정 갤러리로 이동하여 '제출' 버튼을 클릭하여 작품을 제출할 수 있습니다.</p>
    <p>대기 중인 제출물은 협력자{{ Settings::get('gallery_submissions_require_approval') ? ', 그리고 관리자,' : '' }}의 승인을 받은 후 갤러리에 나타납니다.</p>

    <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <a class="nav-link {{ set_active('gallery/submissions/pending') }}" href="{{ url('gallery/submissions/pending') }}">대기중</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ set_active('gallery/submissions/accepted') }}" href="{{ url('gallery/submissions/accepted') }}">승인됨</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ set_active('gallery/submissions/rejected') }}" href="{{ url('gallery/submissions/rejected') }}">거절됨</a>
        </li>
    </ul>

    @if ($submissions->count())
        {!! $submissions->render() !!}

        @foreach ($submissions as $key => $submission)
            @include('galleries._queue_submission', ['queue' => true])
        @endforeach

        {!! $submissions->render() !!}
        <div class="text-center mt-4 small text-muted">{{ $submissions->total() }} result{{ $submissions->total() == 1 ? '' : 's' }} found.</div>
    @else
        <p>갤러리 제출물이 없습니다.</p>
    @endif

@endsection
