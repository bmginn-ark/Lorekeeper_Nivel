@if ($rarity)
    {!! Form::open(['url' => 'admin/data/rarities/delete/' . $rarity->id]) !!}

    <p>{{ __('You are about to delete the rarity :name. This is not reversible. If traits and/or characters that have this rarity exist, you will not be able to delete this rarity.', ['name' => '<strong>'.$rarity->name.'</strong>']) }}</p>
    <p>{{ __('Are you sure you want to delete :name?', ['name' => '<strong>'.$rarity->name.'</strong>']) }}</p>

    <div class="text-right">
        {!! Form::submit(__('Delete Rarity'), ['class' => 'btn btn-danger']) !!}
    </div>

    {!! Form::close() !!}
@else
    {{ __('Invalid rarity selected.') }}
@endif
