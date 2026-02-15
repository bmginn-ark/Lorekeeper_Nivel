<h1>{{ __('MYO Slot Settings') }}</h1>

<h3>{{ __('Basic Information') }}</h3>
<div class="form-group">
    {!! Form::label(__('Name')) !!} {!! add_help(__('Enter a descriptive name for the type of character this slot can create, e.g. Rare MYO Slot. This will be listed on the MYO slot masterlist.')) !!}
    {!! Form::text('name', $tag->getData()['name'], ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label(__('Description (Optional)')) !!}
    @if ($isMyo)
        {!! add_help(__('This section is for making additional notes about the MYO slot. If there are restrictions for the character that can be created by this slot that cannot be expressed with the options below, use this section to describe them.')) !!}
    @else
        {!! add_help(__('This section is for making additional notes about the character and is separate from the character\'s profile (this is not editable by the user).')) !!}
    @endif
    {!! Form::textarea('description', $tag->getData()['description'], ['class' => 'form-control wysiwyg']) !!}
</div>

<div class="form-group">
    {!! Form::checkbox('is_visible', 1, $tag->getData()['is_visible'], ['class' => 'form-check-input', 'data-toggle' => 'toggle']) !!}
    {!! Form::label('is_visible', __('Is Visible'), ['class' => 'form-check-label ml-3']) !!} {!! add_help(
        __('Turn this off to hide the :type. Only mods with the Manage Masterlist power (that\'s you!) can view it - the owner will also not be able to see the :type\'s page.', ['type' => $isMyo ? __('MYO slot') : __('Character')]),
    ) !!}
</div>

<h3>{{ __('Transfer Information') }}</h3>

<div class="alert alert-info">
    {{ __('These are displayed on the MYO slot\'s profile, but don\'t have any effect on site functionality except for the following:') }}
    <ul>
        <li>{{ __('If all switches are off, the MYO slot cannot be transferred by the user (directly or through trades).') }}</li>
        <li>{{ __('If a transfer cooldown is set, the MYO slot also cannot be transferred by the user (directly or through trades) until the cooldown is up.') }}</li>
    </ul>
</div>
<div class="form-group">
    {!! Form::checkbox('is_giftable', 1, $tag->getData()['is_giftable'], ['class' => 'form-check-input', 'data-toggle' => 'toggle']) !!}
    {!! Form::label('is_giftable', __('Is Giftable'), ['class' => 'form-check-label ml-3']) !!}
</div>
<div class="form-group">
    {!! Form::checkbox('is_tradeable', 1, $tag->getData()['is_tradeable'], ['class' => 'form-check-input', 'data-toggle' => 'toggle']) !!}
    {!! Form::label('is_tradeable', __('Is Tradeable'), ['class' => 'form-check-label ml-3']) !!}
</div>
<div class="form-group">
    {!! Form::checkbox('is_sellable', 1, $tag->getData()['is_sellable'], ['class' => 'form-check-input', 'data-toggle' => 'toggle', 'id' => 'resellable']) !!}
    {!! Form::label('is_sellable', __('Is Resellable'), ['class' => 'form-check-label ml-3']) !!}
</div>
<div class="card mb-3" id="resellOptions">
    <div class="card-body">
        {!! Form::label(__('Resale Value')) !!} {!! add_help(__('This value is publicly displayed on the MYO slot\'s page.')) !!}
        {!! Form::text('sale_value', $tag->getData()['sale_value'], ['class' => 'form-control']) !!}
    </div>
</div>

<h3>{{ __('Traits') }}</h3>

<div class="form-group">
    {!! Form::label(__('Species')) !!} {!! add_help(__('This will lock the slot into a particular species. Leave it blank if you would like to give the user a choice.')) !!}
    {!! Form::select('species_id', $specieses, $tag->getData()['species_id'], ['class' => 'form-control', 'id' => 'species']) !!}
</div>

<div class="form-group">
    {!! Form::label(__('Subtype (Optional)')) !!} {!! add_help(
        __('This will lock the slot into a particular subtype. Leave it blank if you would like to give the user a choice, or not select a subtype. The subtype must match the species selected above, and if no species is specified, the subtype will not be applied.'),
    ) !!}
    {!! Form::select('subtype_id', $subtypes, $tag->getData()['subtype_id'], ['class' => 'form-control', 'id' => 'subtype']) !!}
</div>

<div class="form-group">
    {!! Form::label(__('Character Rarity')) !!} {!! add_help(__('This will lock the slot into a particular rarity. Leave it blank if you would like to give the user more choices.')) !!}
    {!! Form::select('rarity_id', $rarities, $tag->getData()['rarity_id'], ['class' => 'form-control']) !!}
</div>

@section('scripts')
    @parent
    @include('widgets._character_create_options_js')
@endsection
