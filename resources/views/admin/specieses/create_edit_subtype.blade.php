@extends('admin.layout')

@section('admin-title')
    {{ $subtype->id ? __('Edit') : __('Create') }} {{ __('Subtype') }}
@endsection

@section('admin-content')
    {!! breadcrumbs([__('Admin Panel') => 'admin', __('Subtypes') => 'admin/data/subtypes', ($subtype->id ? __('Edit') : __('Create')) . ' ' . __('Subtype') => $subtype->id ? 'admin/data/subtypes/edit/' . $subtype->id : 'admin/data/subtypes/create']) !!}

    <h1>{{ $subtype->id ? __('Edit') : __('Create') }} {{ __('Subtype') }}
        @if ($subtype->id)
            <a href="#" class="btn btn-danger float-right delete-subtype-button">{{ __('Delete Subtype') }}</a>
        @endif
    </h1>

    {!! Form::open(['url' => $subtype->id ? 'admin/data/subtypes/edit/' . $subtype->id : 'admin/data/subtypes/create', 'files' => true]) !!}

    <h3>{{ __('Basic Information') }}</h3>

    <div class="form-group">
        {!! Form::label(__('Name')) !!}
        {!! Form::text('name', $subtype->name, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label(__('Species')) !!}
        {!! Form::select('species_id', $specieses, $subtype->species_id, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label(__('World Page Image (Optional)')) !!} {!! add_help(__('This image is used only on the world information pages.')) !!}
        <div class="custom-file">
            {!! Form::label('image', __('Choose file...'), ['class' => 'custom-file-label']) !!}
            {!! Form::file('image', ['class' => 'custom-file-input']) !!}
        </div>
        <div class="text-muted">{{ __('Recommended size: 200px x 200px') }}</div>
        @if ($subtype->has_image)
            <div class="form-check">
                {!! Form::checkbox('remove_image', 1, false, ['class' => 'form-check-input']) !!}
                {!! Form::label('remove_image', __('Remove current image'), ['class' => 'form-check-label']) !!}
            </div>
        @endif
    </div>

    <div class="form-group">
        {!! Form::label(__('Description (Optional)')) !!}
        {!! Form::textarea('description', $subtype->description, ['class' => 'form-control wysiwyg']) !!}
    </div>

    <div class="form-group">
        {!! Form::checkbox('is_visible', 1, $subtype->id ? $subtype->is_visible : 1, ['class' => 'form-check-input', 'data-toggle' => 'toggle']) !!}
        {!! Form::label('is_visible', __('Is Visible'), ['class' => 'form-check-label ml-3']) !!} {!! add_help(__('If turned off, the subtype will not be visible in the subtypes list or available for selection in search and design updates. Permissioned staff will still be able to add them to characters, however.')) !!}
    </div>
    <div class="text-right">
        {!! Form::submit($subtype->id ? __('Edit') : __('Create'), ['class' => 'btn btn-primary']) !!}
    </div>

    {!! Form::close() !!}

    @if ($subtype->id)
        <h3>{{ __('Preview') }}</h3>
        <div class="card mb-3">
            <div class="card-body">
                @include('world._subtype_entry', ['subtype' => $subtype])
            </div>
        </div>
    @endif
@endsection

@section('scripts')
    @parent
    <script>
        $(document).ready(function() {
            $('.delete-subtype-button').on('click', function(e) {
                e.preventDefault();
                loadModal("{{ url('admin/data/subtypes/delete') }}/{{ $subtype->id }}", '{{ __('Delete Subtype') }}');
            });
        });
    </script>
@endsection
