{!! Form::open(['url' => 'admin/masterlist/transfer/' . $transfer->id]) !!}
@if ($transfer->status == 'Accepted')
    <p>{{ __('This will process the transfer of :character from :sender to :recipient immediately.', ['character' => $transfer->character->displayName, 'sender' => $transfer->sender->displayName, 'recipient' => $transfer->recipient->displayName]) }}</p>
@else
    <p>{{ __('This will approve the transfer of :character from :sender to :recipient, and it will be processed once the recipient accepts it.', ['character' => $transfer->character->displayName, 'sender' => $transfer->sender->displayName, 'recipient' => $transfer->recipient->displayName]) }}</p>
@endif
<div class="form-group">
    {!! Form::label('cooldown', __('Cooldown (days)')) !!}
    {!! Form::text('cooldown', $cooldown, ['class' => 'form-control']) !!}
</div>
<div class="text-right">
    {!! Form::submit(__('Approve'), ['class' => 'btn btn-success', 'name' => 'action']) !!}
</div>
{!! Form::close() !!}
