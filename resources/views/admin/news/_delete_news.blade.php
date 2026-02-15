@if ($news)
    {!! Form::open(['url' => 'admin/news/delete/' . $news->id]) !!}

    <p>{{ __('You are about to delete the news post :name. This is not reversible. If you would like to preserve the content while preventing users from accessing the post, you can use the viewable setting instead to hide the post.', ['name' => '<strong>'.$news->title.'</strong>']) }}</p>
    <p>{{ __('Are you sure you want to delete :name?', ['name' => '<strong>'.$news->title.'</strong>']) }}</p>

    <div class="text-right">
        {!! Form::submit(__('Delete Post'), ['class' => 'btn btn-danger']) !!}
    </div>

    {!! Form::close() !!}
@else
    {{ __('Invalid post selected.') }}
@endif
