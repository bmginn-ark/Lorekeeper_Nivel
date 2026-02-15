@extends('admin.layout')

@section('admin-title')
    {{ $category->id ? __('Edit') : __('Create') }} {{ __('Prompt Category') }}
@endsection

@section('admin-content')
    {!! breadcrumbs([
        __('Admin Panel') => 'admin',
        __('Prompt Categories') => 'admin/data/prompt-categories',
        ($category->id ? __('Edit') : __('Create')) . ' ' . __('Category') => $category->id ? 'admin/data/prompt-categories/edit/' . $category->id : 'admin/data/prompt-categories/create',
    ]) !!}

    <h1>{{ $category->id ? __('Edit') : __('Create') }} {{ __('Prompt Category') }}
        @if ($category->id)
            <a href="#" class="btn btn-danger float-right delete-category-button">{{ __('Delete Category') }}</a>
        @endif
    </h1>

    {!! Form::open(['url' => $category->id ? 'admin/data/prompt-categories/edit/' . $category->id : 'admin/data/prompt-categories/create', 'files' => true]) !!}

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

    <div class="text-right">
        {!! Form::submit($category->id ? __('Edit') : __('Create'), ['class' => 'btn btn-primary']) !!}
    </div>

    {!! Form::close() !!}

    @if ($category->id)
        <h3>{{ __('Preview') }}</h3>
        <div class="card mb-3">
            <div class="card-body">
                @include('prompts._entry', ['imageUrl' => $category->categoryImageUrl, 'name' => $category->displayName, 'description' => $category->parsed_description])
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
                loadModal("{{ url('admin/data/prompt-categories/delete') }}/{{ $category->id }}", '{{ __("Delete Category") }}');
            });
        });
    </script>
@endsection
