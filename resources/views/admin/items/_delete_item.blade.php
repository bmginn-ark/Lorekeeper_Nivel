@if ($item)
    {!! Form::open(['url' => 'admin/data/items/delete/' . $item->id]) !!}

    <p>{{ __('You are about to delete the item :name. This is not reversible. If this item exists in at least one user\'s possession, you will not be able to delete this item.', ['name' => '<strong>'.$item->name.'</strong>']) }}</p>
    <p>{{ __('Are you sure you want to delete :name?', ['name' => '<strong>'.$item->name.'</strong>']) }}</p>

    <div class="text-right">
        {!! Form::submit(__('Delete Item'), ['class' => 'btn btn-danger']) !!}
    </div>

    {!! Form::close() !!}
@else
    {{ __('Invalid item selected.') }}
@endif
