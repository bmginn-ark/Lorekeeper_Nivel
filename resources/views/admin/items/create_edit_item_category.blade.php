@extends('admin.layout')

@section('admin-title')
    {{ $category->id ? __('Edit') : __('Create') }} {{ __('Item Category') }}
@endsection

@section('admin-content')
    {!! breadcrumbs([
        __('Admin Panel') => 'admin',
        __('Item Categories') => 'admin/data/item-categories',
        ($category->id ? __('Edit') : __('Create')) . ' ' . __('Category') => $category->id ? 'admin/data/item-categories/edit/' . $category->id : 'admin/data/item-categories/create',
    ]) !!}

    <h1>{{ $category->id ? __('Edit') : __('Create') }} {{ __('Item Category') }}
        @if ($category->id)
            <a href="#" class="btn btn-danger float-right delete-category-button">{{ __('Delete Category') }}</a>
        @endif
    </h1>

    {!! Form::open(['url' => $category->id ? 'admin/data/item-categories/edit/' . $category->id : 'admin/data/item-categories/create', 'files' => true]) !!}

    <h3>{{ __('Basic Information') }}</h3>

    <div class="form-group">
        {!! Form::label(__('Name')) !!}
        {!! Form::text('name', $category->name, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label(__('World Page Image (Optional)')) !!} {!! add_help(__('This image is used only on the world information pages.')) !!}
        <div class="custom-file">
            {!! Form::label('image', __('Choose file...'), ['class' => 'custom-file-label']) !!}
            {!! Form::file('image', ['class' => 'custom-file-input']) !!}
        </div>
        <div class="text-muted">{{ __('Recommended size: 200px x 200px') }}</div>
        @if ($category->has_image)
            <div class="form-check">
                {!! Form::checkbox('remove_image', 1, false, ['class' => 'form-check-input']) !!}
                {!! Form::label('remove_image', __('Remove current image'), ['class' => 'form-check-label']) !!}
            </div>
        @endif
    </div>

    <div class="form-group">
        {!! Form::label(__('Description (Optional)')) !!}
        {!! Form::textarea('description', $category->description, ['class' => 'form-control wysiwyg']) !!}
    </div>

    <div class="form-group">
        {!! Form::checkbox('is_visible', 1, $category->id ? $category->is_visible : 1, ['class' => 'form-check-input', 'data-toggle' => 'toggle']) !!}
        {!! Form::label('is_visible', __('Is Visible'), ['class' => 'form-check-label ml-3']) !!} {!! add_help(__('If turned off, the category will not be visible in the category list or available for selection in search. Permissioned staff will still be able to add items to them, however.')) !!}
    </div>

    <div class="card mb-3" id="characterOptions">
        <div class="card-body">
            <div class="mb-2">
                <div class="form-group">
                    {!! Form::checkbox('is_character_owned', 1, $category->is_character_owned, ['class' => 'form-check-input', 'data-toggle' => 'toggle', 'data-on' => 'Allow', 'data-off' => 'Disallow']) !!}
                    {!! Form::label('is_character_owned', __('Can Be Owned by Characters'), ['class' => 'form-check-label ml-3']) !!} {!! add_help(__('This will allow items in this category to be owned by characters.')) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('character_limit', __('Character Hold Limit')) !!} {!! add_help(__('This is the maximum amount of items from this category a character can possess. Set to 0 to allow infinite.')) !!}
                    {!! Form::text('character_limit', $category ? $category->character_limit : 0, ['class' => 'form-control stock-field', 'data-name' => 'character_limit']) !!}
                </div>
                <div class="form-group">
                    {!! Form::checkbox('can_name', 1, $category->can_name, ['class' => 'form-check-input', 'data-toggle' => 'toggle', 'data-on' => 'Allow', 'data-off' => 'Disallow']) !!}
                    {!! Form::label('can_name', __('Can be Named'), ['class' => 'form-check-label ml-3']) !!} {!! add_help(__('This will set items in this category to be able to be named when in character inventories-- for instance, for pets. Works best in conjunction with a hold limit on the category.')) !!}
                </div>
            </div>
        </div>
    </div>

    <div class="text-right">
        {!! Form::submit($category->id ? __('Edit') : __('Create'), ['class' => 'btn btn-primary']) !!}
    </div>

    {!! Form::close() !!}

    @if ($category->id)
        <h3>{{ __('Preview') }}</h3>
        <div class="card mb-3">
            <div class="card-body">
                @include('world._item_category_entry', ['imageUrl' => $category->categoryImageUrl, 'name' => $category->displayName, 'description' => $category->parsed_description, 'category' => $category])
            </div>
        </div>
    @endif
@endsection

@section('scripts')
    @parent
    <script>
        $(document).ready(function() {
            $('.delete-category-button').on('click', function(e) {
                e.preventDefault();
                loadModal("{{ url('admin/data/item-categories/delete') }}/{{ $category->id }}", '{{ __("Delete Category") }}');
            });
        });
    </script>
@endsection
