@if ($shop)
    {!! Form::open(['url' => 'admin/data/shops/delete/' . $shop->id]) !!}

    <p>{{ __('You are about to delete the shop :name. This is not reversible. If you would like to hide the shop from users, you can set it as inactive from the shop settings page.', ['name' => $shop->name]) }}</p>
    <p>{{ __('Are you sure you want to delete :name?', ['name' => $shop->name]) }}</p>

    <div class="text-right">
        {!! Form::submit(__('Delete Shop'), ['class' => 'btn btn-danger']) !!}
    </div>

    {!! Form::close() !!}
@else
    {{ __('Invalid shop selected.') }}
@endif
