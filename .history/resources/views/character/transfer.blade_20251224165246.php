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
                        {!! Form::submit('Cancel', ['class' => 'btn btn-danger', 'name' => 'action']) !!}
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
                    캐릭터가 전송된 후(전송이 수락되면 {{$transferQueue ? ' and approved' : '' }}), <strong>{{$cooldown}}/<strong> 일수의 쿨다운이 적용됩니다. 이 기간 동안 캐릭터는 다른 사람에게 전송할 수 없습니다.
                </p>
            @endif
            {!! Form::open(['url' => $character->url . '/transfer']) !!}
            <div class="form-group">
                {!! Form::label('recipient_id', 'Recipient') !!}
                {!! Form::select('recipient_id', $userOptions, old('recipient_id'), ['class' => 'form-control selectize', 'placeholder' => 'Select User']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('user_reason', 'Reason for Transfer (Required)') !!}
                {!! Form::text('user_reason', '', ['class' => 'form-control']) !!}
            </div>
            <div class="text-right">
                {!! Form::submit('Send Transfer', ['class' => 'btn btn-primary']) !!}
            </div>
            {!! Form::close() !!}
        @endif
    @endif

    @if (Auth::user()->hasPower('manage_characters'))
        <h3>Admin Transfer</h3>
        <div class="alert alert-warning">
            You are editing this character as a staff member.
        </div>
        <p>This will transfer the character automatically, without requiring the recipient to confirm the transfer. You may also transfer a character that is marked non-transferrable, or still under cooldown. Both the old and new owners will be notified
            of the transfer.</p>
        <p>Fill in either of the recipient fields - if transferring to an off-site user, leave the recipient field blank and vice versa.</p>
        {!! Form::open(['url' => $character->is_myo_slot ? 'admin/myo/' . $character->id . '/transfer' : 'admin/character/' . $character->slug . '/transfer']) !!}
        <div class="form-group">
            {!! Form::label('recipient_id', 'Recipient') !!}
            {!! Form::select('recipient_id', $userOptions, old('recipient_id'), ['class' => 'form-control selectize', 'placeholder' => 'Select User']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('recipient_url', 'Recipient Url') !!} {!! add_help('Characters can only be transferred to offsite user URLs from site(s) used for authentication.') !!}
            {!! Form::text('recipient_url', old('recipient_url'), ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('cooldown', 'Transfer Cooldown (days)') !!}
            {!! Form::text('cooldown', $cooldown, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('reason', 'Reason for Transfer (optional)') !!}
            {!! Form::text('reason', '', ['class' => 'form-control']) !!}
        </div>
        <div class="text-right">
            {!! Form::submit('Send Transfer', ['class' => 'btn btn-primary']) !!}
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
