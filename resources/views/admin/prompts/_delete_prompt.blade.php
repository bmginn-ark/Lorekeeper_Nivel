@if ($prompt)
    {!! Form::open(['url' => 'admin/data/prompts/delete/' . $prompt->id]) !!}

    <p>{{ __('You are about to delete the prompt :name. This is not reversible. If submissions exist under this prompt, you will not be able to delete it.', ['name' => '<strong>'.$prompt->name.'</strong>']) }}</p>
    <p>{{ __('Are you sure you want to delete :name?', ['name' => '<strong>'.$prompt->name.'</strong>']) }}</p>

    <div class="text-right">
        {!! Form::submit(__('Delete Prompt'), ['class' => 'btn btn-danger']) !!}
    </div>

    {!! Form::close() !!}
@else
    {{ __('Invalid prompt selected.') }}
@endif
