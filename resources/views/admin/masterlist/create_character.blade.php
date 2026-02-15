@extends('admin.layout')

@section('admin-title')
    {{ $isMyo ? __('Create MYO Slot') : __('Create Character') }}
@endsection

@section('admin-content')
    {!! breadcrumbs([__('Admin Panel') => 'admin', ($isMyo ? __('Create MYO Slot') : __('Create Character')) => 'admin/masterlist/create-' . ($isMyo ? 'myo' : 'character')]) !!}

    <h1>{{ $isMyo ? __('Create MYO Slot') : __('Create Character') }}</h1>

    @if (!$isMyo && !count($categories))

        <div class="alert alert-danger">{{ __('Creating characters requires at least one') }} <a href="{{ url('admin/data/character-categories') }}">{{ __('character category') }}</a> {{ __('to be created first, as character categories are used to generate the character code.') }}</div>
    @else
        {!! Form::open(['url' => 'admin/masterlist/create-' . ($isMyo ? 'myo' : 'character'), 'files' => true]) !!}

        <h3>{{ __('Basic Information') }}</h3>

        @if ($isMyo)
            <div class="form-group">
                {!! Form::label(__('Name')) !!} {!! add_help(__('Enter a descriptive name for the type of character this slot can create, e.g. Rare MYO Slot. This will be listed on the MYO slot masterlist.')) !!}
                {!! Form::text('name', old('name'), ['class' => 'form-control']) !!}
            </div>
        @endif

        <div class="alert alert-info">
            {{ __('Fill in either of the owner fields - you can select a user from the list if they have registered for the site, or enter the URL of their off-site profile, such as their deviantArt profile, if they don\'t have an account. If the owner registers an account later and links their account, :types linked to that account\'s profile will automatically be credited to their site account. If both fields are filled, the URL field will be ignored.', ['types' => $isMyo ? __('MYO slots') : __('characters')]) }}
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label(__('Owner')) !!}
                    {!! Form::select('user_id', $userOptions, old('user_id'), ['class' => 'form-control', 'placeholder' => __('Select User'), 'id' => 'userSelect']) !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label(__('Owner URL (Optional)')) !!}
                    {!! Form::text('owner_url', old('owner_url'), ['class' => 'form-control']) !!}
                </div>
            </div>
        </div>

        @if (!$isMyo)
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label(__('Character Category')) !!}
                        <select name="character_category_id" id="category" class="form-control" placeholder="{{ __('Select Category') }}">
                            <option value="" data-code="">{{ __('Select Category') }}</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" data-code="{{ $category->code }}" {{ old('character_category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }} ({{ $category->code }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label(__('Number')) !!} {!! add_help(__('This number helps to identify the character and should preferably be unique either within the category, or among all characters.')) !!}
                        <div class="d-flex">
                            {!! Form::text('number', old('number'), ['class' => 'form-control mr-2', 'id' => 'number']) !!}
                            <a href="#" id="pull-number" class="btn btn-primary" data-toggle="tooltip"
                                title="{{ __('This will find the highest number assigned to a character currently and add 1 to it. It can be adjusted to pull the highest number in the category or the highest overall number - this setting is in the code.') }}">{{ __('Pull Next Number') }}</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                {!! Form::label(__('Character Code')) !!} {!! add_help(__('This code identifies the character itself. You don\'t have to use the automatically generated code, but this must be unique among all characters (as it\'s used to generate the character\'s page URL).')) !!}
                {!! Form::text('slug', old('slug'), ['class' => 'form-control', 'id' => 'code']) !!}
            </div>
        @endif

        <div class="form-group">
            {!! Form::label(__('Description (Optional)')) !!}
            @if ($isMyo)
                {!! add_help(__('This section is for making additional notes about the MYO slot. If there are restrictions for the character that can be created by this slot that cannot be expressed with the options below, use this section to describe them.')) !!}
            @else
                {!! add_help(__('This section is for making additional notes about the character and is separate from the character\'s profile (this is not editable by the user).')) !!}
            @endif
            {!! Form::textarea('description', old('description'), ['class' => 'form-control wysiwyg']) !!}
        </div>

        <div class="form-group">
            {!! Form::checkbox('is_visible', 1, old('is_visible'), ['class' => 'form-check-input', 'data-toggle' => 'toggle']) !!}
            {!! Form::label('is_visible', __('Is Visible'), ['class' => 'form-check-label ml-3']) !!} {!! add_help(
                __('Turn this off to hide the :type. Only mods with the Manage Masterlist power (that\'s you!) can view it - the owner will also not be able to see the :type\'s page.', ['type' => $isMyo ? __('MYO slot') : __('character')]),
            ) !!}
        </div>

        <h3>{{ __('Transfer Information') }}</h3>

        <div class="alert alert-info">
            {{ __('These are displayed on the :type\'s profile, but don\'t have any effect on site functionality except for the following:', ['type' => $isMyo ? __('MYO slot') : __('character')]) }}
            <ul>
                <li>{{ __('If all switches are off, the :type cannot be transferred by the user (directly or through trades).', ['type' => $isMyo ? __('MYO slot') : __('character')]) }}</li>
                <li>{{ __('If a transfer cooldown is set, the :type also cannot be transferred by the user (directly or through trades) until the cooldown is up.', ['type' => $isMyo ? __('MYO slot') : __('character')]) }}</li>
            </ul>
        </div>
        <div class="form-group">
            {!! Form::checkbox('is_giftable', 1, old('is_giftable'), ['class' => 'form-check-input', 'data-toggle' => 'toggle']) !!}
            {!! Form::label('is_giftable', __('Is Giftable'), ['class' => 'form-check-label ml-3']) !!}
        </div>
        <div class="form-group">
            {!! Form::checkbox('is_tradeable', 1, old('is_tradeable'), ['class' => 'form-check-input', 'data-toggle' => 'toggle']) !!}
            {!! Form::label('is_tradeable', __('Is Tradeable'), ['class' => 'form-check-label ml-3']) !!}
        </div>
        <div class="form-group">
            {!! Form::checkbox('is_sellable', 1, old('is_sellable'), ['class' => 'form-check-input', 'data-toggle' => 'toggle', 'id' => 'resellable']) !!}
            {!! Form::label('is_sellable', __('Is Resellable'), ['class' => 'form-check-label ml-3']) !!}
        </div>
        <div class="card mb-3" id="resellOptions">
            <div class="card-body">
                {!! Form::label(__('Resale Value')) !!} {!! add_help(__('This value is publicly displayed on the :type\'s page.', ['type' => $isMyo ? __('MYO slot') : __('character')])) !!}
                {!! Form::text('sale_value', old('sale_value'), ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label(__('On Transfer Cooldown Until (Optional)')) !!}
            {!! Form::text('transferrable_at', old('transferrable_at'), ['class' => 'form-control datepicker']) !!}
        </div>

        <h3>{{ __('Image Upload') }}</h3>

        <div class="form-group">
            {!! Form::label(__('Image')) !!}
            @if ($isMyo)
                {!! add_help(__('This is a cover image for the MYO slot. If left blank, a default image will be used.')) !!}
            @else
                {!! add_help(__('This is the full masterlist image. Note that the image is not protected in any way, so take precautions to avoid art/design theft.')) !!}
            @endif
            <div class="custom-file">
                {!! Form::label('image', __('Choose file...'), ['class' => 'custom-file-label']) !!}
                {!! Form::file('image', ['class' => 'custom-file-input', 'id' => 'mainImage']) !!}
            </div>
        </div>
        @if (config('lorekeeper.settings.masterlist_image_automation') === 1)
            <div class="form-group">
                {!! Form::checkbox('use_cropper', 1, 1, ['class' => 'form-check-input', 'data-toggle' => 'toggle', 'id' => 'useCropper']) !!}
                {!! Form::label('use_cropper', __('Use Thumbnail Automation'), ['class' => 'form-check-label ml-3']) !!} {!! add_help(__('A thumbnail is required for the upload (used for the masterlist). You can use the Thumbnail Automation, or upload a custom thumbnail.')) !!}
            </div>
            <div class="card mb-3" id="thumbnailCrop">
                <div class="card-body">
                    <div id="cropSelect">{{ __('By using this function, the thumbnail will be automatically generated from the full image.') }}</div>
                    {!! Form::hidden('x0', 1) !!}
                    {!! Form::hidden('x1', 1) !!}
                    {!! Form::hidden('y0', 1) !!}
                    {!! Form::hidden('y1', 1) !!}
                </div>
            </div>
        @else
            <div class="form-group">
                {!! Form::checkbox('use_cropper', 1, 1, ['class' => 'form-check-input', 'data-toggle' => 'toggle', 'id' => 'useCropper']) !!}
                {!! Form::label('use_cropper', __('Use Image Cropper'), ['class' => 'form-check-label ml-3']) !!} {!! add_help(__('A thumbnail is required for the upload (used for the masterlist). You can use the image cropper (crop dimensions can be adjusted in the site code), or upload a custom thumbnail.')) !!}
            </div>
            <div class="card mb-3" id="thumbnailCrop">
                <div class="card-body">
                    <div id="cropSelect">{{ __('Select an image to use the thumbnail cropper.') }}</div>
                    <img src="#" id="cropper" class="hide" alt="" />
                    {!! Form::hidden('x0', null, ['id' => 'cropX0']) !!}
                    {!! Form::hidden('x1', null, ['id' => 'cropX1']) !!}
                    {!! Form::hidden('y0', null, ['id' => 'cropY0']) !!}
                    {!! Form::hidden('y1', null, ['id' => 'cropY1']) !!}
                </div>
            </div>
        @endif
        <div class="card mb-3" id="thumbnailUpload">
            <div class="card-body">
                {!! Form::label(__('Thumbnail Image')) !!} {!! add_help(__('This image is shown on the masterlist page.')) !!}
                <div class="custom-file">
                    {!! Form::label('thumbnail', __('Choose thumbnail...'), ['class' => 'custom-file-label']) !!}
                    {!! Form::file('thumbnail', ['class' => 'custom-file-input']) !!}
                </div>
                <div class="text-muted">{{ __('Recommended size:') }} {{ config('lorekeeper.settings.masterlist_thumbnails.width') }}px x {{ config('lorekeeper.settings.masterlist_thumbnails.height') }}px</div>
            </div>
        </div>
        <p class="alert alert-info">
            {{ __('This section is for crediting the image creators. The first box is for the designer or artist\'s on-site username (if any). The second is for a link to the designer or artist if they don\'t have an account on the site.') }}
        </p>
        <div class="form-group">
            {!! Form::label(__('Designer(s)')) !!}
            <div id="designerList">
                <div class="mb-2 d-flex">
                    {!! Form::select('designer_id[]', $userOptions, null, ['class' => 'form-control mr-2 selectize', 'placeholder' => __('Select a Designer')]) !!}
                    {!! Form::text('designer_url[]', null, ['class' => 'form-control mr-2', 'placeholder' => __('Designer URL')]) !!}
                    <a href="#" class="add-designer btn btn-link" data-toggle="tooltip" title="{{ __('Add another designer') }}">+</a>
                </div>
            </div>
            <div class="designer-row hide mb-2">
                {!! Form::select('designer_id[]', $userOptions, null, ['class' => 'form-control mr-2 designer-select', 'placeholder' => __('Select a Designer')]) !!}
                {!! Form::text('designer_url[]', null, ['class' => 'form-control mr-2', 'placeholder' => __('Designer URL')]) !!}
                <a href="#" class="add-designer btn btn-link" data-toggle="tooltip" title="{{ __('Add another designer') }}">+</a>
            </div>
        </div>
        <div class="form-group">
            {!! Form::label(__('Artist(s)')) !!}
            <div id="artistList">
                <div class="mb-2 d-flex">
                    {!! Form::select('artist_id[]', $userOptions, null, ['class' => 'form-control mr-2 selectize', 'placeholder' => __('Select an Artist')]) !!}
                    {!! Form::text('artist_url[]', null, ['class' => 'form-control mr-2', 'placeholder' => __('Artist URL')]) !!}
                    <a href="#" class="add-artist btn btn-link" data-toggle="tooltip" title="{{ __('Add another artist') }}">+</a>
                </div>
            </div>
            <div class="artist-row hide mb-2">
                {!! Form::select('artist_id[]', $userOptions, null, ['class' => 'form-control mr-2 artist-select', 'placeholder' => __('Select an Artist')]) !!}
                {!! Form::text('artist_url[]', null, ['class' => 'form-control mr-2', 'placeholder' => __('Artist URL')]) !!}
                <a href="#" class="add-artist btn btn-link mb-2" data-toggle="tooltip" title="{{ __('Add another artist') }}">+</a>
            </div>
        </div>
        @if (!$isMyo)
            <div class="form-group">
                {!! Form::label(__('Image Notes (Optional)')) !!} {!! add_help(__('This section is for making additional notes about the image.')) !!}
                {!! Form::textarea('image_description', old('image_description'), ['class' => 'form-control wysiwyg']) !!}
            </div>
        @endif

        <h3>{{ __('Traits') }}</h3>

        <div class="form-group">
            {!! Form::label(__('Species')) !!} @if ($isMyo)
                {!! add_help(__('This will lock the slot into a particular species. Leave it blank if you would like to give the user a choice.')) !!}
            @endif
            {!! Form::select('species_id', $specieses, old('species_id'), ['class' => 'form-control', 'id' => 'species']) !!}
        </div>

        <div class="form-group" id="subtypes">
            {!! Form::label(__('Subtype (Optional)')) !!} @if ($isMyo)
                {!! add_help(
                    __('This will lock the slot into a particular subtype. Leave it blank if you would like to give the user a choice, or not select a subtype. The subtype must match the species selected above, and if no species is specified, the subtype will not be applied.'),
                ) !!}
            @endif
            {!! Form::select('subtype_id', $subtypes, old('subtype_id'), ['class' => 'form-control disabled', 'id' => 'subtype']) !!}
        </div>

        <div class="form-group">
            {!! Form::label(__('Character Rarity')) !!} @if ($isMyo)
                {!! add_help(__('This will lock the slot into a particular rarity. Leave it blank if you would like to give the user more choices.')) !!}
            @endif
            {!! Form::select('rarity_id', $rarities, old('rarity_id'), ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label(__('Traits')) !!} @if ($isMyo)
                {!! add_help(
                    __('These traits will be listed as required traits for the slot. The user will still be able to add on more traits, but not be able to remove these. This is allowed to conflict with the rarity above; you may add traits above the character\'s specified rarity.'),
                ) !!}
            @endif
            <div><a href="#" class="btn btn-primary mb-2" id="add-feature">{{ __('Add Trait') }}</a></div>
            <div id="featureList">
            </div>
            <div class="feature-row hide mb-2">
                {!! Form::select('feature_id[]', $features, null, ['class' => 'form-control mr-2 feature-select', 'placeholder' => __('Select Trait')]) !!}
                {!! Form::text('feature_data[]', null, ['class' => 'form-control mr-2', 'placeholder' => __('Extra Info (Optional)')]) !!}
                <a href="#" class="remove-feature btn btn-danger mb-2">×</a>
            </div>
        </div>

        <div class="text-right">
            {!! Form::submit($isMyo ? __('Create MYO Slot') : __('Create Character'), ['class' => 'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
    @endif

@endsection

@section('scripts')
    @parent
    @include('widgets._character_create_options_js')
    @include('widgets._image_upload_js')
    @include('widgets._datetimepicker_js')
    @if (!$isMyo)
        @include('widgets._character_code_js')
    @endif

    <script>
        $("#species").change(function() {
            var species = $('#species').val();
            var myo = '<?php echo $isMyo; ?>';
            $.ajax({
                type: "GET",
                url: "{{ url('admin/masterlist/check-subtype') }}?species=" + species + "&myo=" + myo,
                dataType: "text"
            }).done(function(res) {
                $("#subtypes").html(res);
            }).fail(function(jqXHR, textStatus, errorThrown) {
                alert("AJAX call failed: " + textStatus + ", " + errorThrown);
            });
        });
    </script>
@endsection
