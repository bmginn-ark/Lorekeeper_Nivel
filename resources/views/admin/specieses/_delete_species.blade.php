@if ($species)
    {!! Form::open(['url' => 'admin/data/species/delete/' . $species->id]) !!}

    <p>{{ __('You are about to delete the species :name. This is not reversible. If traits and/or characters that have this species exist, you will not be able to delete this species.', ['name' => $species->name]) }}</p>
    <p>{{ __('Are you sure you want to delete :name?', ['name' => $species->name]) }}</p>

    <div class="text-right">
        {!! Form::submit(__('Delete Species'), ['class' => 'btn btn-danger']) !!}
    </div>

    {!! Form::close() !!}
@else
    {{ __('Invalid species selected.') }}
@endif
