@extends('admin.layout')

@section('admin-title')
    {{ $category->id ? __('Edit') : __('Create') }} {{ __('Character Category') }}
@endsection

@section('admin-content')
    {!! breadcrumbs([
        __('Admin Panel') => 'admin',
        __('Character Categories') => 'admin/data/character-categories',
        ($category->id ? __('Edit') : __('Create')) . ' ' . __('Category') => $category->id ? 'admin/data/character-categories/edit/' . $category->id : 'admin/data/character-categories/create',
    ]) !!}

    <h1>{{ $category->id ? __('Edit') : __('Create') }} {{ __('Character Category') }}
        @if ($category->id)
            <a href="#" class="btn btn-danger float-right delete-category-button">{{ __('Delete Category') }}</a>
        @endif
    </h1>

    {!! Form::open(['url' => $category->id ? 'admin/data/character-categories/edit/' . $category->id : 'admin/data/character-categories/create', 'files' => true]) !!}

    <h3>{{ __('Basic Information') }}</h3>

    <div class="form-group">
        {!! Form::label(__('Name')) !!}
        {!! Form::text('name', $category->name, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label(__('Code')) !!} {!! add_help(__('This is used in generating the codename for the character. Choose a short unique identifier, e.g. MYO, GUEST, etc.')) !!}
        {!! Form::text('code', $category->code, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label(__('Sub Masterlist (Optional)')) !!} {!! add_help(__('This puts it onto a sub masterlist.')) !!}
        {!! Form::select('masterlist_sub_id', $sublists, $category->masterlist_sub_id, ['class' => 'form-control']) !!}
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
        {!! Form::label('is_visible', __('Is Visible'), ['class' => 'form-check-label ml-3']) !!} {!! add_help(__('If turned off, the category will not be visible in the category list or available for selection in search. Permissioned staff will still be able to add characters to them, however.')) !!}
    </div>

    <div class="text-right">
        {!! Form::submit($category->id ? __('Edit') : __('Create'), ['class' => 'btn btn-primary']) !!}
    </div>

    {!! Form::close() !!}

    @if ($category->id)
        <h3>{{ __('Preview') }}</h3>
        <div class="card mb-3">
            <div class="card-body">
                @include('world._entry', [
                    'imageUrl' => $category->categoryImageUrl,
                    'name' => $category->displayName,
                    'description' => $category->parsed_description,
                    'searchUrl' => $category->searchUrl,
                    'visible' => $category->is_visible,
                ])
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
                loadModal("{{ url('admin/data/character-categories/delete') }}/{{ $category->id }}", '{{ __("Delete Category") }}');
            });
        });
    </script>
@endsection
