@if ($currency)
    {!! Form::open(['url' => 'admin/data/currencies/delete/' . $currency->id]) !!}

    <p>{!! __('You are about to delete the currency :name. This is not reversible. If users who possess this currency exist, their owned currency will also be deleted.', ['name' => '<strong>'.$currency->name.'</strong>']) !!}</p>
    <p>{!! __('Are you sure you want to delete :name?', ['name' => '<strong>'.$currency->name.'</strong>']) !!}</p>

    <div class="text-right">
        {!! Form::submit(__('Delete Currency'), ['class' => 'btn btn-danger']) !!}
    </div>

    {!! Form::close() !!}
@else
    {{ __('Invalid currency selected.') }}
@endif
