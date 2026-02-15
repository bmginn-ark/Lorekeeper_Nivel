@if ($table)
    {!! Form::open(['url' => 'admin/data/loot-tables/delete/' . $table->id]) !!}

    <p>{{ __('You are about to delete the loot table :name. This is not reversible. If prompts that use this loot table exist, you will not be able to delete this table.', ['name' => '<strong>'.$table->name.'</strong>']) }}</p>
    <p>{{ __('Are you sure you want to delete :name?', ['name' => '<strong>'.$table->name.'</strong>']) }}</p>

    <div class="text-right">
        {!! Form::submit(__('Delete Loot Table'), ['class' => 'btn btn-danger']) !!}
    </div>

    {!! Form::close() !!}
@else
    {{ __('Invalid loot table selected.') }}
@endif
