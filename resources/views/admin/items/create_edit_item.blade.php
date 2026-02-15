@extends('admin.layout')

@section('admin-title')
    {{ $item->id ? __('Edit') : __('Create') }} {{ __('Item') }}
@endsection

@section('admin-content')
    {!! breadcrumbs([__('Admin Panel') => 'admin', __('Items') => 'admin/data/items', ($item->id ? __('Edit') : __('Create')) . ' ' . __('Item') => $item->id ? 'admin/data/items/edit/' . $item->id : 'admin/data/items/create']) !!}

    <h1>{{ $item->id ? __('Edit') : __('Create') }} {{ __('Item') }}
        @if ($item->id)
            <a href="#" class="btn btn-outline-danger float-right delete-item-button">{{ __('Delete Item') }}</a>
        @endif
    </h1>

    {!! Form::open(['url' => $item->id ? 'admin/data/items/edit/' . $item->id : 'admin/data/items/create', 'files' => true]) !!}

    <h3>{{ __('Basic Information') }}</h3>

    <div class="form-group">
        {!! Form::label(__('Name')) !!}
        {!! Form::text('name', $item->name, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label(__('World Page Image (Optional)')) !!} {!! add_help(__('This image is used only on the world information pages.')) !!}
        <div class="custom-file">
            {!! Form::label('image', __('Choose file...'), ['class' => 'custom-file-label']) !!}
            {!! Form::file('image', ['class' => 'custom-file-input']) !!}
        </div>
        <div class="text-muted">{{ __('Recommended size: 100px x 100px') }}</div>
        @if ($item->has_image)
            <div class="form-check">
                {!! Form::checkbox('remove_image', 1, false, ['class' => 'form-check-input']) !!}
                {!! Form::label('remove_image', __('Remove current image'), ['class' => 'form-check-label']) !!}
            </div>
        @endif
    </div>

    <div class="row">
        <div class="col-md">
            <div class="form-group">
                {!! Form::label(__('Item Category (Optional)')) !!}
                {!! Form::select('item_category_id', $categories, $item->item_category_id, ['class' => 'form-control']) !!}
            </div>
        </div>
        @if (config('lorekeeper.extensions.item_entry_expansion.extra_fields'))
            <div class="col-md">
                <div class="form-group">
                    {!! Form::label(__('Item Rarity (Optional)')) !!} {!! add_help(__('This should be a number.')) !!}
                    {!! Form::number('rarity', $item && $item->rarity ? $item->rarity : '', ['class' => 'form-control']) !!}
                </div>
            </div>
        @endif
    </div>

    @if (config('lorekeeper.extensions.item_entry_expansion.extra_fields'))
        <div class="row">
            <div class="col-md">
                <div class="form-group">
                    {!! Form::label(__('Reference Link (Optional)')) !!} {!! add_help(__('An optional link to an additional reference')) !!}
                    {!! Form::text('reference_url', $item->reference_url, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="col-md">
                {!! Form::label(__('Item Artist (Optional)')) !!} {!! add_help(__('Provide the artist\'s username if they are on site or, failing that, a link.')) !!}
                <div class="row">
                    <div class="col-md">
                        <div class="form-group">
                            {!! Form::select('artist_id', $userOptions, $item && $item->artist_id ? $item->artist_id : null, ['class' => 'form-control mr-2 selectize', 'placeholder' => __('Select a User')]) !!}
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="form-group">
                            {!! Form::text('artist_url', $item && $item->artist_url ? $item->artist_url : '', ['class' => 'form-control mr-2', 'placeholder' => __('Artist URL')]) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="form-group">
        {!! Form::label(__('Description (Optional)')) !!}
        {!! Form::textarea('description', $item->description, ['class' => 'form-control wysiwyg']) !!}
    </div>

    @if (config('lorekeeper.extensions.item_entry_expansion.extra_fields'))
        <div class="form-group">
            {!! Form::label(__('Uses (Optional)')) !!} {!! add_help(__('A short description of the item\'s use(s). Supports raw HTML if need be, but keep it brief.')) !!}
            {!! Form::text('uses', $item && $item->uses ? $item->uses : '', ['class' => 'form-control']) !!}
        </div>
    @endif

    <div class="row">
        <div class="col-md form-group">
            {!! Form::checkbox('allow_transfer', 1, $item->id ? $item->allow_transfer : 1, ['class' => 'form-check-input', 'data-toggle' => 'toggle']) !!}
            {!! Form::label('allow_transfer', __('Allow User → User Transfer'), ['class' => 'form-check-label ml-3']) !!} {!! add_help(__('If this is off, users will not be able to transfer this item to other users. Non-account-bound items can be account-bound when granted to users directly.')) !!}
        </div>
        @if (config('lorekeeper.extensions.item_entry_expansion.extra_fields'))
            <div class="col-md form-group">
                {!! Form::checkbox('is_released', 1, $item->id ? $item->is_released : 1, ['class' => 'form-check-input', 'data-toggle' => 'toggle']) !!}
                {!! Form::label('is_released', __('Is Released'), ['class' => 'form-check-label ml-3']) !!} {!! add_help(__('If this is off, users will not be able to view information for the item/it will be hidden from view. This is overridden by the item being owned at any point by anyone on the site.')) !!}
            </div>
        @endif
    </div>

    @if (config('lorekeeper.extensions.item_entry_expansion.extra_fields'))
        <h3>{{ __('Availability Information') }}</h3>
        <div class="row">
            <div class="col-md">
                <div class="form-group">
                    {!! Form::label('release', __('Source (Optional)')) !!} {!! add_help(__('The original and/or general source of the item. Should be brief.')) !!}
                    {!! Form::text('release', $item && $item->source ? $item->source : '', ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="col-md">
                <div class="form-group">
                    {!! Form::label('prompts[]', __('Drop Location(s) (Optional)')) !!} {!! add_help(__('You can select up to 10 prompts at once.')) !!}
                    {!! Form::select('prompts[]', $prompts, $item && isset($item->data['prompts']) ? $item->data['prompts'] : '', ['id' => 'promptsList', 'class' => 'form-control', 'multiple']) !!}
                </div>
            </div>
        </div>
    @endif

    @if (config('lorekeeper.extensions.item_entry_expansion.resale_function'))
        <h3>{{ __('Resale Information') }}</h3>
        <p>{{ __('The currency and amount users will be able to sell this item from their inventory for. If quantity is not set, the item will be unable to be sold.') }}</p>
        <div class="row">
            <div class="col-md">
                <div class="form-group">
                    {!! Form::label('currency_id', __('Currency')) !!}
                    {!! Form::select('currency_id', $userCurrencies, isset($item->data['resell']) && App\Models\Currency\Currency::where('id', $item->resell->flip()->pop())->first() ? $item->resell->flip()->pop() : null, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="col-md">
                <div class="form-group">
                    {!! Form::label('currency_quantity', __('Quantity')) !!}
                    {!! Form::text('currency_quantity', isset($item->data['resell']) ? $item->resell->pop() : null, ['class' => 'form-control']) !!}
                </div>
            </div>
        </div>
    @endif

    <div class="text-right">
        {!! Form::submit($item->id ? __('Edit') : __('Create'), ['class' => 'btn btn-primary']) !!}
    </div>

    {!! Form::close() !!}

    @if ($item->id)
        <h3>{{ __('Item Tags') }}</h3>
        <p>{{ __('Item tags indicate extra functionality for the item. Click on the edit button to edit the specific item tag\'s data.') }}</p>
        @if (count($item->tags))
            <table class="table">
                <thead>
                    <tr>
                        <th>{{ __('Tag') }}</th>
                        <th>{{ __('Active?') }}</th>
                        <th></th>
                    </tr>
                </thead>
                @foreach ($item->tags as $tag)
                    <tr>
                        <td>{!! $tag->displayTag !!}</td>
                        <td class="{{ $tag->is_active ? 'text-success' : 'text-danger' }}">{{ $tag->is_active ? __('Yes') : __('No') }}</td>
                        <td class="text-right"><a href="{{ url('admin/data/items/tag/' . $item->id . '/' . $tag->tag) }}" class="btn btn-outline-primary">{{ __('Edit') }}</a></td>
                    </tr>
                @endforeach
            </table>
        @else
            <p>{{ __('No item tags attached to this item.') }}</p>
        @endif
        <div class="text-right">
            <a href="{{ url('admin/data/items/tag/' . $item->id) }}" class="btn btn-outline-primary">{{ __('Add a Tag') }}</a>
        </div>

        <h3>{{ __('Preview') }}</h3>
        <div class="card mb-3">
            <div class="card-body">
                @include('world._item_entry', ['imageUrl' => $item->imageUrl, 'name' => $item->displayName, 'description' => $item->parsed_description, 'searchUrl' => $item->searchUrl])
            </div>
        </div>
    @endif

@endsection

@section('scripts')
    @parent
    <script>
        $(document).ready(function() {
            $('.selectize').selectize();

            $('#promptsList').selectize({
                maxItems: 10
            });

            $('.delete-item-button').on('click', function(e) {
                e.preventDefault();
                loadModal("{{ url('admin/data/items/delete') }}/{{ $item->id }}", '{{ __("Delete Item") }}');
            });
        });
    </script>
@endsection
