@extends('admin.layout')

@section('admin-title')
    {{ $rarity->id ? __('Edit') : __('Create') }} {{ __('Rarity') }}
@endsection

@section('admin-content')
    {!! breadcrumbs([__('Admin Panel') => 'admin', __('Rarities') => 'admin/data/rarities', ($rarity->id ? __('Edit') : __('Create')) . ' ' . __('Rarity') => $rarity->id ? 'admin/data/rarities/edit/' . $rarity->id : 'admin/data/rarities/create']) !!}

    <h1>{{ $rarity->id ? __('Edit') : __('Create') }} {{ __('Rarity') }}
        @if ($rarity->id)
            <a href="#" class="btn btn-danger float-right delete-rarity-button">{{ __('Delete Rarity') }}</a>
        @endif
    </h1>

    {!! Form::open(['url' => $rarity->id ? 'admin/data/rarities/edit/' . $rarity->id : 'admin/data/rarities/create', 'files' => true]) !!}

    <h3>{{ __('Basic Information') }}</h3>

    <div class="form-group">
        {!! Form::label(__('Name')) !!}
        {!! Form::text('name', $rarity->name, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label(__('Colour (Hex code; optional)')) !!}
        <div class="input-group cp">
            {!! Form::text('color', $rarity->color, ['class' => 'form-control']) !!}
            <span class="input-group-append">
                <span class="input-group-text colorpicker-input-addon"><i></i></span>
            </span>
        </div>
    </div>

    <div class="form-group">
        {!! Form::label(__('World Page Image (Optional)')) !!} {!! add_help(__('This image is used only on the world information pages.')) !!}
        <div class="custom-file">
            {!! Form::label('image', __('Choose file...'), ['class' => 'custom-file-label']) !!}
            {!! Form::file('image', ['class' => 'custom-file-input']) !!}
        </div>
        <div class="text-muted">{{ __('Recommended size: 200px x 200px') }}</div>
        @if ($rarity->has_image)
            <div class="form-check">
                {!! Form::checkbox('remove_image', 1, false, ['class' => 'form-check-input']) !!}
                {!! Form::label('remove_image', __('Remove current image'), ['class' => 'form-check-label']) !!}
            </div>
        @endif
    </div>

    <div class="form-group">
        {!! Form::label(__('Description (Optional)')) !!}
        {!! Form::textarea('description', $rarity->description, ['class' => 'form-control wysiwyg']) !!}
    </div>

    <div class="text-right">
        {!! Form::submit($rarity->id ? __('Edit') : __('Create'), ['class' => 'btn btn-primary']) !!}
    </div>

    {!! Form::close() !!}

    @if ($rarity->id)
        <h3>{{ __('Preview') }}</h3>
        <div class="card mb-3">
            <div class="card-body">
                @include('world._rarity_entry', [
                    'imageUrl' => $rarity->rarityImageUrl,
                    'name' => $rarity->displayName,
                    'description' => $rarity->parsed_description,
                    'searchFeaturesUrl' => $rarity->searchFeaturesUrl,
                    'searchCharactersUrl' => $rarity->searchCharactersUrl,
                    'edit' => [
                        'title' => __('Edit Rarity'),
                        'object' => $rarity,
                    ],
                ])
            </div>
        </div>
    @endif
@endsection

@section('scripts')
    @parent
    <script>
        $(document).ready(function() {
            $('.delete-rarity-button').on('click', function(e) {
                e.preventDefault();
                loadModal("{{ url('admin/data/rarities/delete') }}/{{ $rarity->id }}", '{{ __("Delete Rarity") }}');
            });
        });
    </script>
@endsection
