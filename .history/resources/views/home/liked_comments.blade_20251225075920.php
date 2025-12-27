@extends('home.layout')

@section('home-title')
    내가 좋아요한 덧글
@endsection

@section('home-content')
    {!! breadcrumbs(['Liked Comments' => 'liked-comments']) !!}

    <h1>
        내가 좋아요한 덧글
    </h1>

    <p>이것은 당신이 좋아요하거나 싫어요한 덧글 목록입니다. 이 목록은 공개되지 않으며, 사용자는 덧글에서 누가 좋아요했는지 확인할 수 있습니다.</p>
    <div class="p-2">
        {{-- Order user CommentLikes by when the comment was created inside the foreach --}}
        @php
            $comments = $user->commentLikes;
            $comments = $comments->sortByDesc(function ($comment) {
                return $comment->comment->created_at;
            });
        @endphp

        @foreach ($comments as $comment)
            <div class="card col-12 mb-2">
                @include('comments._perma_comments', ['comment' => $comment->comment, ($limit = 0), ($depth = 0)])
            </div>
        @endforeach
    </div>
@endsection
