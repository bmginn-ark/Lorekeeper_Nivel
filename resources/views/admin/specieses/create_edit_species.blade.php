@extends('admin.layout')

@section('admin-title')
    {{ $species->id ? __('Edit') : __('Create') }} {{ __('Species') }}
@endsection

@section('admin-content')
    {!! breadcrumbs([__('Admin Panel') => 'admin', __('Species') => 'admin/data/species', ($species->id ? __('Edit') : __('Create')) . ' ' . __('Species') => $species->id ? 'admin/data/species/edit/' . $species->id : 'admin/data/species/create']) !!}

    <h1>{{ $species->id ? __('Edit') : __('Create') }} {{ __('Species') }}
        @if ($species->id)
            <a href="#" class="btn btn-danger float-right delete-species-button">{{ __('Delete Species') }}</a>
        @endif
    </h1>

    {!! Form::open(['url' => $species->id ? 'admin/data/species/edit/' . $species->id : 'admin/data/species/create', 'files' => true]) !!}

    <h3>{{ __('Basic Information') }}</h3>

    <div class="form-group">
        {!! Form::label(__('Name')) !!}
        {!! Form::text('name', $species->name, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label(__('Sub Masterlist (Optional)')) !!} {!! add_help(__('This puts it onto a sub masterlist.')) !!}
        {!! Form::select('masterlist_sub_id', $sublists, $species->masterlist_sub_id, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label(__('World Page Image (Optional)')) !!} {!! add_help(__('This image is used only on the world information pages.')) !!}
        <div class="custom-file">
            {!! Form::label('image', __('Choose file...'), ['class' => 'custom-file-label']) !!}
            {!! Form::file('image', ['class' => 'custom-file-input']) !!}
        </div>
        <div class="text-muted">{{ __('Recommended size: 200px x 200px') }}</div>
        @if ($species->has_image)
            <div class="form-check">
                {!! Form::checkbox('remove_image', 1, false, ['class' => 'form-check-input']) !!}
                {!! Form::label('remove_image', __('Remove current image'), ['class' => 'form-check-label']) !!}
            </div>
        @endif
    </div>

    <div class="form-group">
        {!! Form::label(__('Description (Optional)')) !!}
        {!! Form::textarea('description', $species->description, ['class' => 'form-control wysiwyg']) !!}
    </div>

    <div class="form-group">
        {!! Form::checkbox('is_visible', 1, $species->id ? $species->is_visible : 1, ['class' => 'form-check-input', 'data-toggle' => 'toggle']) !!}
        {!! Form::label('is_visible', __('Is Visible'), ['class' => 'form-check-label ml-3']) !!} {!! add_help(__('If turned off, the species will not be visible in the species list or available for selection in search and design updates. Permissioned staff will still be able to add them to characters, however.')) !!}
    </div>

    <div class="text-right">
        {!! Form::submit($species->id ? __('Edit') : __('Create'), ['class' => 'btn btn-primary']) !!}
    </div>

    {!! Form::close() !!}

    @if ($species->id)
        <h3>{{ __('Preview') }}</h3>
        <div class="card mb-3">
            <div class="card-body">
                @include('world._species_entry', ['species' => $species])
            </div>
        </div>
    @endif
@endsection

@section('scripts')
    @parent
    <script>
        $(document).ready(function() {
            $('.delete-species-button').on('click', function(e) {
                e.preventDefault();
                loadModal("{{ url('admin/data/species/delete') }}/{{ $species->id }}", '{{ __('Delete Species') }}');
            });
        });
    </script>
@endsection
