@if ($sales)
    {!! Form::open(['url' => 'admin/sales/delete/' . $sales->id]) !!}

    <p>{{ __('You are about to delete the sales post :name. This is not reversible. If you would like to preserve the content while preventing users from accessing the post, you can use the viewable setting instead to hide the post.', ['name' => $sales->title]) }}</p>
    <p>{{ __('Are you sure you want to delete :name?', ['name' => $sales->title]) }}</p>

    <div class="text-right">
        {!! Form::submit(__('Delete Post'), ['class' => 'btn btn-danger']) !!}
    </div>

    {!! Form::close() !!}
@else
    {{ __('Invalid post selected.') }}
@endif
