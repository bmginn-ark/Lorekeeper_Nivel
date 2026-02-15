@extends('character.layout', ['isMyo' => $character->is_myo_slot])

@section('profile-title')
    {{ $character->fullName }} 이전
@endsection

@section('meta-img')
    {{ $character->image->thumbnailUrl }}
@endsection

@section('profile-content')
    @if ($character->is_myo_slot)
        {!! breadcrumbs(['MYO Slot Masterlist' => 'myos', $character->fullName => $character->url, 'Transfer' => $character->url . '/transfer']) !!}
    @else
        {!! breadcrumbs([
            $character->category->masterlist_sub_id ? $character->category->sublist->name . ' Masterlist' : 'Character masterlist' => $character->category->masterlist_sub_id ? 'sublist/' . $character->category->sublist->key : 'masterlist',
            $character->fullName => $character->url,
            'Transfer' => $character->url . '/transfer',
        ]) !!}
    @endif

    @include('character._header', ['character' => $character])

    @if ($character->user_id == Auth::user()->id)
        <h3>캐릭터 전송</h3>
        @if (!$character->is_sellable && !$character->is_tradeable && !$character->is_giftable)
            <p>이 캐릭터는 전송할 수 없습니다.</p>
        @elseif($character->transferrable_at && $character->transferrable_at->isFuture())
            <p>이 캐릭터는 <strong>{!! format_date($character->transferrable_at) !!}일 까지 쿨다운입니다.</strong> ({{ $character->transferrable_at->diffForHumans() }}). 그 전까지 이전할 수 없습니다..</p>
        @elseif($transfer)
            <div class="card bg-light mb-3">
                <div class="card-body">
                    <p>
                        이 캐릭터는 이미 {!! $transfer->recipient->displayName !!}님 에게 전송중입니다.
                    </p>
                    <div class="text-right">
                        {!! Form::open(['url' => 'characters/transfer/act/' . $transfer->id]) !!}
                        {!! Form::submit(__('Cancel'), ['class' => 'btn btn-danger', 'name' => 'action']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        @elseif($character->trade_id)
            <p>이 캐릭터는 현재 거래중입니다. (<a href="{{ $character->trade->url }}">거래 보기</a>)</p>
        @else
            <p>
                전송은 수신자가 캐릭터를 받고 싶은지 확인해야 합니다. 수신자가 확인하기 전에 전송을 취소할 수 있지만, 전송된 후에는 캐릭터를 검색할 수 없습니다.
                @if ($transfersQueue)
                    또한 스태프가 전송을 승인해야 합니다. 수신자가 전송을 확인한 후에도 캐릭터를 받을 때까지 대기 시간이 있을 수 있습니다.
                @endif
            </p>
            @if ($cooldown)
                <p>
                    캐릭터가 전송된 후(전송이 수락되면 {{ $transferQueue ? ' ' . __(' and approved') : '' }}), <strong>{{$cooldown}}</strong> 일수의 쿨다운이 적용됩니다. 이 기간 동안 캐릭터는 다른 사람에게 전송할 수 없습니다.
                </p>
            @endif
            {!! Form::open(['url' => $character->url . '/transfer']) !!}
            <div class="form-group">
                {!! Form::label('recipient_id', '받는 이') !!}
                {!! Form::select('recipient_id', $userOptions, old('recipient_id'), ['class' => 'form-control selectize', 'placeholder' => '유저 선택']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('user_reason', '전송 이유 (필수)') !!}
                {!! Form::text('user_reason', '', ['class' => 'form-control']) !!}
            </div>
            <div class="text-right">
                {!! Form::submit(__('Send Transfer'), ['class' => 'btn btn-primary']) !!}
            </div>
            {!! Form::close() !!}
        @endif
    @endif

    @if (Auth::user()->hasPower('manage_characters'))
        <h3>{{ __('Admin Transfer') }}</h3>
        <div class="alert alert-warning">
            이 캐릭터를 스태프 권한으로 편집하고 있습니다.
        </div>
        <p>이렇게 하면 수신자가 전송을 확인할 필요 없이 캐릭터가 자동으로 전송됩니다. 전송 불가 또는 재사용 대기 중인 것으로 표시된 캐릭터를 전송할 수도 있습니다. 이전 소유자와 새 소유자 모두에게 양도에 대해 알림이 전송됩니다.</p>
        <p>수신자 필드 중 하나를 입력합니다 - 사이트 밖 사용자에게 전송하는 경우 수신자 필드를 비워두거나 그 반대의 경우도 마찬가지입니다.</p>
        {!! Form::open(['url' => $character->is_myo_slot ? 'admin/myo/' . $character->id . '/transfer' : 'admin/character/' . $character->slug . '/transfer']) !!}
        <div class="form-group">
            {!! Form::label('recipient_id', '받는 이') !!}
            {!! Form::select('recipient_id', $userOptions, old('recipient_id'), ['class' => 'form-control selectize', 'placeholder' => '유저 선택']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('recipient_url', '받는 이 Url') !!} {!! add_help(__('Characters can only be transferred to offsite user URLs from site(s) used for authentication.')) !!}
            {!! Form::text('recipient_url', old('recipient_url'), ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('cooldown', '전송 쿨다운 (일)') !!}
            {!! Form::text('cooldown', $cooldown, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('reason', '전송 이유 (선택)') !!}
            {!! Form::text('reason', '', ['class' => 'form-control']) !!}
        </div>
        <div class="text-right">
            {!! Form::submit(__('Send Transfer'), ['class' => 'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
    @endif

@endsection
@section('scripts')
    @parent
    <script>
        $('.selectize').selectize();
    </script>
@endsection
