@extends('character.layout', ['isMyo' => $character->is_myo_slot])

@section('profile-title')
    {{ $character->is_myo_slot ? 'MYO Approval' : 'Design Update' }} for {{ $character->fullName }}
@endsection

@section('meta-img')
    {{ $character->image->thumbnailUrl }}
@endsection

@section('profile-content')
    @if ($character->is_myo_slot)
        {!! breadcrumbs(['MYO Slot Masterlist' => 'myos', $character->fullName => $character->url, $character->is_myo_slot ? 'MYO Approval' : 'Design Update' => $character->url . '/approval']) !!}
    @else
        {!! breadcrumbs([
            $character->category->masterlist_sub_id ? $character->category->sublist->name . ' Masterlist' : 'Character masterlist' => $character->category->masterlist_sub_id ? 'sublist/' . $character->category->sublist->key : 'masterlist',
            $character->fullName => $character->url,
            $character->is_myo_slot ? 'MYO Approval' : 'Design Update' => $character->url . '/approval',
        ]) !!}
    @endif

    @include('character._header', ['character' => $character])

    <h3>
        {{ $character->is_myo_slot ? 'MYO 승인' : '디자인 업데이트' }} 요청
    </h3>
    @if (!$queueOpen)
        <div class="alert alert-danger">
            {{ $character->is_myo_slot ? 'MYO 승인' : '디자인 업데이트' }} 요청은 현재 닫혀 있습니다.
        </div>
    @elseif(!$request)
        <p>{{ $character->is_myo_slot ? 'MYO 승인' : '디자인 업데이트' }} 요청 기록이 없습니다. 새로 만드시겠습니까?</p>
        <p>이것은 {{ $character->is_myo_slot ? 'MYO 슬롯 디자인' : '디자인 업데이트' }}요청을 생성할 것입니다. 새로운 마스터리스트 이미지를 업로드하고, 캐릭터의 특성을 수정하고, 아이템/재화를 사용할 수 있게 해줍니다.
            제출하기 전에 요청한 내용을 원하는 만큼 편집할 수 있습니다. 스태프들이 초안을 보고 피드백을 제공할 수 있습니다.</p>
        {!! Form::open(['url' => $character->is_myo_slot ? 'myo/' . $character->id . '/approval' : 'character/' . $character->slug . '/approval']) !!}
        <div class="text-right">
            {!! Form::submit('Create Request', ['class' => 'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
    @else
        <p>{{ $character->is_myo_slot ? 'MYO 승인' : '디자인 업데이트' }} 요청이 {{ $request->status == 'Draft' ? '아직 제출되지 않았습니다.' : '승인을 기다리고 있습니다.' }}. <a href="{{ $request->url }}">여기를 클릭해 보
                {{ $request->status == 'Draft' ? '고 수정하' : '' }}기.</a></p>
    @endif
@endsection

@section('scripts')
    @parent
    @include('widgets._image_upload_js')
    <script>
        $(document).ready(function() {});
    </script>
@endsection
