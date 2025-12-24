@extends('character.layout', ['isMyo' => $character->is_myo_slot])

@section('profile-title')
    {{ $character->fullName }}의 갤러리
@endsection

@section('meta-img')
    {{ $character->image->thumbnailUrl }}
@endsection

@section('profile-content')
    @if ($character->is_myo_slot)
        {!! breadcrumbs(['MYO Slot Masterlist' => 'myos', $character->fullName => $character->url, 'Gallery' => $character->url . '/gallery']) !!}
    @else
        {!! breadcrumbs([
            $character->category->masterlist_sub_id ? $character->category->sublist->name . ' Masterlist' : 'Character masterlist' => $character->category->masterlist_sub_id ? 'sublist/' . $character->category->sublist->key : 'masterlist',
            $character->fullName => $character->url,
            'Gallery' => $character->url . '/gallery',
        ]) !!}
    @endif

    @include('character._header', ['character' => $character])

    <p>이 이미지는 사용자가 제출한 것이므로 캐릭터의 디자인에 대한 <a href="{{ url($character->url . '/images') }}">공식 기록</a>과 혼동해서는 안 됩니다 .</p>

    @if ($character->gallerySubmissions->count())
        {!! $submissions->render() !!}

        <div class="d-flex align-content-around flex-wrap mb-2">
            @foreach ($submissions as $submission)
                @include('galleries._thumb', ['submission' => $submission, 'gallery' => false])
            @endforeach
        </div>

        {!! $submissions->render() !!}
    @else
        <p>제출된 항목이 없습니다.</p>
    @endif

@endsection
