@if ($subtype)
    {!! Form::open(['url' => 'admin/data/subtypes/delete/' . $subtype->id]) !!}

    <p>{{ __('You are about to delete the subtype :name. This is not reversible. If traits and/or characters that have this subtype exist, you will not be able to delete this subtype.', ['name' => $subtype->name]) }}</p>
    <p>{{ __('Are you sure you want to delete :name?', ['name' => $subtype->name]) }}</p>

    <div class="text-right">
        {!! Form::submit(__('Delete Subtype'), ['class' => 'btn btn-danger']) !!}
    </div>

    {!! Form::close() !!}
@else
    {{ __('Invalid subtype selected.') }}
@endif
