{!! Form::open(['url' => 'admin/masterlist/trade/' . $trade->id]) !!}
<p>{{ __('This will process the trade between :sender and :recipient immediately. Please enter the transfer cooldown period for each character in days (the fields have been pre-filled with the default cooldown value).', ['sender' => $trade->sender->displayName, 'recipient' => $trade->recipient->displayName]) }}</p>
@foreach ($trade->getCharacterData() as $character)
    <div class="form-group">
        <label for="cooldowns[{{ $character->id }}]">{{ __('Cooldown for :name (Number of Days)', ['name' => $character->displayName]) }}</label>
        {!! Form::text('cooldowns[' . $character->id . ']', $cooldown, ['class' => 'form-control']) !!}
    </div>
@endforeach
<div class="text-right">
    {!! Form::submit(__('Approve'), ['class' => 'btn btn-success', 'name' => 'action']) !!}
</div>
{!! Form::close() !!}
