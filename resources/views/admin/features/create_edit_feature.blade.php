@extends('admin.layout')

@section('admin-title')
    {{ $feature->id ? __('Edit') : __('Create') }} {{ __('Trait') }}
@endsection

@section('admin-content')
    {!! breadcrumbs([__('Admin Panel') => 'admin', __('Traits') => 'admin/data/traits', ($feature->id ? __('Edit') : __('Create')) . ' ' . __('Trait') => $feature->id ? 'admin/data/traits/edit/' . $feature->id : 'admin/data/traits/create']) !!}

    <h1>{{ $feature->id ? __('Edit') : __('Create') }} {{ __('Trait') }}
        @if ($feature->id)
            <a href="#" class="btn btn-danger float-right delete-feature-button">{{ __('Delete Trait') }}</a>
        @endif
    </h1>

    {!! Form::open(['url' => $feature->id ? 'admin/data/traits/edit/' . $feature->id : 'admin/data/traits/create', 'files' => true]) !!}

    <h3>{{ __('Basic Information') }}</h3>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label(__('Name')) !!}
                {!! Form::text('name', $feature->name, ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label(__('Rarity')) !!}
                {!! Form::select('rarity_id', $rarities, $feature->rarity_id, ['class' => 'form-control']) !!}
            </div>
        </div>
    </div>

    <div class="form-group">
        {!! Form::label(__('World Page Image (Optional)')) !!} {!! add_help(__('This image is used only on the world information pages.')) !!}
        <div class="custom-file">
            {!! Form::label('image', __('Choose file...'), ['class' => 'custom-file-label']) !!}
            {!! Form::file('image', ['class' => 'custom-file-input']) !!}
        </div>
        <div class="text-muted">{{ __('Recommended size: 200px x 200px') }}</div>
        @if ($feature->has_image)
            <div class="form-check">
                {!! Form::checkbox('remove_image', 1, false, ['class' => 'form-check-input']) !!}
                {!! Form::label('remove_image', __('Remove current image'), ['class' => 'form-check-label']) !!}
            </div>
        @endif
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                {!! Form::label(__('Trait Category (Optional)')) !!}
                {!! Form::select('feature_category_id', $categories, $feature->feature_category_id, ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {!! Form::label(__('Species Restriction (Optional)')) !!}
                {!! Form::select('species_id', $specieses, $feature->species_id, ['class' => 'form-control', 'id' => 'species']) !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group" id="subtypes">
                {!! Form::label(__('Subtype (Optional)')) !!} {!! add_help(__('This is cosmetic and does not limit choice of traits in selections.')) !!}
                {!! Form::select('subtype_id', $subtypes, $feature->subtype_id, ['class' => 'form-control', 'id' => 'subtype']) !!}
            </div>
        </div>
    </div>
    <div class="form-group">
        {!! Form::label(__('Description (Optional)')) !!}
        {!! Form::textarea('description', $feature->description, ['class' => 'form-control wysiwyg']) !!}
    </div>

    <div class="form-group">
        {!! Form::checkbox('is_visible', 1, $feature->id ? $feature->is_visible : 1, ['class' => 'form-check-input', 'data-toggle' => 'toggle']) !!}
        {!! Form::label('is_visible', __('Is Visible'), ['class' => 'form-check-label ml-3']) !!} {!! add_help(__('If turned off, the trait will not be visible in the trait list or available for selection in search and design updates. Permissioned staff will still be able to add them to characters, however.')) !!}
    </div>

    <div class="text-right">
        {!! Form::submit($feature->id ? __('Edit') : __('Create'), ['class' => 'btn btn-primary']) !!}
    </div>

    {!! Form::close() !!}

    @if ($feature->id)
        <h3>{{ __('Preview') }}</h3>
        <div class="card mb-3">
            <div class="card-body">
                @include('world._feature_entry', ['feature' => $feature])
            </div>
        </div>
    @endif
@endsection

@section('scripts')
    @parent
    <script>
        $(document).ready(function() {
            $('.delete-feature-button').on('click', function(e) {
                e.preventDefault();
                loadModal("{{ url('admin/data/traits/delete') }}/{{ $feature->id }}", '{{ __("Delete Trait") }}');
            });
            refreshSubtype();
        });

        $("#species").change(function() {
            refreshSubtype();
        });

        function refreshSubtype() {
            var species = $('#species').val();
            var subtype_id = {{ $feature->subtype_id ?: 'null' }};
            $.ajax({
                type: "GET",
                url: "{{ url('admin/data/traits/check-subtype') }}?species=" + species + "&subtype_id=" + subtype_id,
                dataType: "text"
            }).done(function(res) {
                $("#subtypes").html(res);
            }).fail(function(jqXHR, textStatus, errorThrown) {
                alert("AJAX call failed: " + textStatus + ", " + errorThrown);
            });
        };
    </script>
@endsection
