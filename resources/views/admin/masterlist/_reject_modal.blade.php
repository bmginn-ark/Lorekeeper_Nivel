{!! Form::open(['url' => 'admin/masterlist/transfer/' . $transfer->id]) !!}
<p>{{ __('This will reject the transfer of :character from :sender to :recipient automatically. The transfer cooldown will not be applied. Are you sure?', ['character' => $transfer->character->displayName, 'sender' => $transfer->sender->displayName, 'recipient' => $transfer->recipient->displayName]) }}</p>
<div class="form-group">
    {!! Form::label('reason', __('Reason for Rejection (optional)')) !!}
    {!! Form::textarea('reason', '', ['class' => 'form-control']) !!}
</div>
<div class="text-right">
    {!! Form::submit(__('Reject'), ['class' => 'btn btn-danger', 'name' => 'action']) !!}
</div>
{!! Form::close() !!}
