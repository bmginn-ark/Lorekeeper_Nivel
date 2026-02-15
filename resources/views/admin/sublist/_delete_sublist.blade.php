@if ($sublist)
    {!! Form::open(['url' => 'admin/data/sublists/delete/' . $sublist->id]) !!}

    <p>{{ __('You are about to delete the sublist :name. This is not reversible.', ['name' => $sublist->name]) }}</p>
    <p>{{ __('Are you sure you want to delete :name?', ['name' => $sublist->name]) }}</p>

    <div class="text-right">
        {!! Form::submit(__('Delete Sublist'), ['class' => 'btn btn-danger']) !!}
    </div>

    {!! Form::close() !!}
@else
    {{ __('Invalid sublist selected.') }}
@endif
