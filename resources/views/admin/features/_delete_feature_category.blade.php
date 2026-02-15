@if ($category)
    {!! Form::open(['url' => 'admin/data/trait-categories/delete/' . $category->id]) !!}

    <p>{{ __('You are about to delete the category :name. This is not reversible. If traits in this category exist, you will not be able to delete this category.', ['name' => '<strong>'.$category->name.'</strong>']) }}</p>
    <p>{{ __('Are you sure you want to delete :name?', ['name' => '<strong>'.$category->name.'</strong>']) }}</p>

    <div class="text-right">
        {!! Form::submit(__('Delete Category'), ['class' => 'btn btn-danger']) !!}
    </div>

    {!! Form::close() !!}
@else
    {{ __('Invalid category selected.') }}
@endif
