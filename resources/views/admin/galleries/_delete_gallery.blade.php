@if ($gallery)
    {!! Form::open(['url' => 'admin/data/galleries/delete/' . $gallery->id]) !!}

    <p>{{ __('You are about to delete the gallery :name. This is not reversible. If submissions in this gallery exist, or this gallery has sub-galleries, you will not be able to delete this gallery.', ['name' => '<strong>'.$gallery->name.'</strong>']) }}</p>
    <p>{{ __('Are you sure you want to delete :name?', ['name' => '<strong>'.$gallery->name.'</strong>']) }}</p>

    <div class="text-right">
        {!! Form::submit(__('Delete Gallery'), ['class' => 'btn btn-danger']) !!}
    </div>

    {!! Form::close() !!}
@else
    {{ __('Invalid gallery selected.') }}
@endif
