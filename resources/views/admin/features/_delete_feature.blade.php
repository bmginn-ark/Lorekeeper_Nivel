@if ($feature)
    {!! Form::open(['url' => 'admin/data/traits/delete/' . $feature->id]) !!}

    <p>{{ __('You are about to delete the trait :name. This is not reversible. If characters possessing this trait exist, you will not be able to delete this trait.', ['name' => '<strong>'.$feature->name.'</strong>']) }}</p>
    <p>{{ __('Are you sure you want to delete :name?', ['name' => '<strong>'.$feature->name.'</strong>']) }}</p>

    <div class="text-right">
        {!! Form::submit(__('Delete Trait'), ['class' => 'btn btn-danger']) !!}
    </div>

    {!! Form::close() !!}
@else
    {{ __('Invalid trait selected.') }}
@endif
