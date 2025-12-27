@extends('character.layout', ['isMyo' => $character->is_myo_slot])

@section('profile-title')
    {{ $character->fullName }}의 프로필 수정
@endsection

@section('meta-img')
    {{ $character->image->thumbnailUrl }}
@endsection

@section('profile-content')
    @if ($character->is_myo_slot)
        {!! breadcrumbs(['MYO Slot Masterlist' => 'myos', $character->fullName => $character->url, 'Editing Profile' => $character->url . '/profile/edit']) !!}
    @else
        {!! breadcrumbs([
            $character->category->masterlist_sub_id ? $character->category->sublist->name . ' Masterlist' : 'Character masterlist' => $character->category->masterlist_sub_id ? 'sublist/' . $character->category->sublist->key : 'masterlist',
            $character->fullName => $character->url,
            'Editing Profile' => $character->url . '/profile/edit',
        ]) !!}
    @endif

    @include('character._header', ['character' => $character])

    @if ($character->user_id != Auth::user()->id)
        <div class="alert alert-warning">
           이 캐릭터를 스태프 권한으로 편집하고 있습니다.
        </div>
    @endif

    {!! Form::open(['url' => $character->url . '/profile/edit']) !!}
    @if (!$character->is_myo_slot)
        <div class="form-group">
            {!! Form::label('name', '이름') !!}
            {!! Form::text('name', $character->name, ['class' => 'form-control']) !!}
        </div>
        @if (config('lorekeeper.extensions.character_TH_profile_link'))
            <div class="form-group">
                {!! Form::label('link', '프로필 링크') !!}
                {!! Form::text('link', $character->profile->link, ['class' => 'form-control']) !!}
            </div>
        @endif
    @endif
    <div class="form-group">
        {!! Form::label('text', '프로필 내용') !!}
        {!! Form::textarea('text', $character->profile->text, ['class' => 'wysiwyg form-control']) !!}
    </div>

    @if ($character->user_id == Auth::user()->id)
        @if (!$character->is_myo_slot)
            <div class="row">
                <div class="col-md form-group">
                    {!! Form::label('is_gift_art_allowed', '그림 선물 허용', ['class' => 'form-check-label mb-3']) !!} {!! add_help('이렇게 하면 선물용으로 그릴 수 있는 캐릭터 목록에 캐릭터가 표시됩니다. 다른 기능은 없지만 그릴 캐릭터를 찾는 사용자가 캐릭터를 쉽게 찾을 수 있습니다.') !!}
                    {!! Form::select('is_gift_art_allowed', [0 => '비허용', 1 => '허용', 2 => '먼저 물어보기'], $character->is_gift_art_allowed, ['class' => 'form-control user-select']) !!}
                </div>
                <div class="col-md form-group">
                    {!! Form::label('is_gift_writing_allowed', '글 선물 허용', ['class' => 'form-check-label mb-3']) !!} {!! add_help(
                        '이렇게 하면 선물용으로 쓸 수 있는 캐릭터 목록에 캐릭터가 표시됩니다. 다른 기능은 없지만 글을 쓰는 사용자가 캐릭터를 쉽게 찾을 수 있습니다.',
                    ) !!}
                    {!! Form::select('is_gift_writing_allowed', [0 => '비허용', 1 => '허용', 2 => '먼저 물어보기'], $character->is_gift_writing_allowed, ['class' => 'form-control user-select']) !!}
                </div>
            </div>
        @endif
        @if ($character->is_tradeable || $character->is_sellable)
            <div class="form-group disabled">
                {!! Form::checkbox('is_trading', 1, $character->is_trading, ['class' => 'form-check-input', 'data-toggle' => 'toggle']) !!}
                {!! Form::label('is_trading', '거래 요청 받기', ['class' => 'form-check-label ml-3']) !!} {!! add_help('이렇게 하면 캐릭터가 현재 거래 중인 캐릭터 목록에 표시됩니다. 다른 기능은 없지만 거래를 원하는 사용자가 캐릭터를 쉽게 찾을 수 있습니다.') !!}
            </div>
        @else
            <div class="alert alert-secondary">캐릭터를 거래하거나 판매할 수 없으므로 "거래 요청 받기"로 설정할 수 없습니다.</div>
        @endif
    @endif
    @if ($character->user_id != Auth::user()->id)
        <div class="form-group">
            {!! Form::checkbox('alert_user', 1, true, ['class' => 'form-check-input', 'data-toggle' => 'toggle', 'data-onstyle' => 'danger']) !!}
            {!! Form::label('alert_user', 'Notify User', ['class' => 'form-check-label ml-3']) !!} {!! add_help('This will send a notification to the user that their character profile has been edited. A notification will not be sent if the character is not visible.') !!}
        </div>
    @endif
    <div class="text-right">
        {!! Form::submit('프로필 수정', ['class' => 'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}

@endsection
