@if ($page)
    {!! Form::open(['url' => 'admin/pages/delete/' . $page->id]) !!}

    <p>{{ __('You are about to delete the page :name. This is not reversible. If you would like to preserve the content while preventing users from accessing the page, you can use the viewable setting instead to hide the page.', ['name' => '<strong>'.($page->title ?? $page->name ?? $page->key).'</strong>']) }}</p>
    <p>{{ __('Are you sure you want to delete :name?', ['name' => '<strong>'.($page->title ?? $page->name ?? $page->key).'</strong>']) }}</p>

    <div class="text-right">
        {!! Form::submit(__('Delete Page'), ['class' => 'btn btn-danger']) !!}
    </div>

    {!! Form::close() !!}
@else
    {{ __('Invalid page selected.') }}
@endif
