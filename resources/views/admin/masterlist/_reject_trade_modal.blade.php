{!! Form::open(['url' => 'admin/masterlist/trade/' . $trade->id]) !!}
<p>{{ __('This will reject the trade between :sender and :recipient automatically, returning all items/currency/characters to their owners. The character transfer cooldown will not be applied. Are you sure?', ['sender' => $trade->sender->displayName, 'recipient' => $trade->recipient->displayName]) }}</p>
<div class="form-group">
    {!! Form::label('reason', __('Reason for Rejection (optional)')) !!}
    {!! Form::textarea('reason', '', ['class' => 'form-control']) !!}
</div>
<div class="text-right">
    {!! Form::submit(__('Reject'), ['class' => 'btn btn-danger', 'name' => 'action']) !!}
</div>
{!! Form::close() !!}
