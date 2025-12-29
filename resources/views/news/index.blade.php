@extends('news.layout')

@section('title')
    사이트 공지
@endsection

@section('news-content')
    {!! breadcrumbs(['Site News' => 'news']) !!}
    <h1>사이트 공지</h1>
    @if (count($newses))
        {!! $newses->render() !!}
        @foreach ($newses as $news)
            @include('news._news', ['news' => $news, 'page' => false])
        @endforeach
        {!! $newses->render() !!}
    @else
        <div>아직 공지사항이 없습니다.</div>
    @endif
@endsection
