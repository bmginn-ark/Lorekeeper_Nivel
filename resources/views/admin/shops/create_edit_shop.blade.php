@extends('admin.layout')

@section('admin-title')
    {{ $shop->id ? __('Edit') : __('Create') }} {{ __('Shop') }}
@endsection

@section('admin-content')
    {!! breadcrumbs([__('Admin Panel') => 'admin', __('Shops') => 'admin/data/shops', ($shop->id ? __('Edit') : __('Create')) . ' ' . __('Shop') => $shop->id ? 'admin/data/shops/edit/' . $shop->id : 'admin/data/shops/create']) !!}

    <h1>{{ $shop->id ? __('Edit') : __('Create') }} {{ __('Shop') }}
        @if ($shop->id)
            ({!! $shop->displayName !!})
            <a href="#" class="btn btn-danger float-right delete-shop-button">{{ __('Delete Shop') }}</a>
        @endif
    </h1>

    {!! Form::open(['url' => $shop->id ? 'admin/data/shops/edit/' . $shop->id : 'admin/data/shops/create', 'files' => true]) !!}

    <h3>{{ __('Basic Information') }}</h3>

    <div class="form-group">
        {!! Form::label(__('Name')) !!}
        {!! Form::text('name', $shop->name, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label(__('Shop Image (Optional)')) !!} {!! add_help(__('This image is used on the shop index and on the shop page as a header.')) !!}
        <div class="custom-file">
            {!! Form::label('image', __('Choose file...'), ['class' => 'custom-file-label']) !!}
            {!! Form::file('image', ['class' => 'custom-file-input']) !!}
        </div>
        <div class="text-muted">{{ __('Recommended size: None (Choose a standard size for all shop images)') }}</div>
        @if ($shop->has_image)
            <div class="form-check">
                {!! Form::checkbox('remove_image', 1, false, ['class' => 'form-check-input']) !!}
                {!! Form::label('remove_image', __('Remove current image'), ['class' => 'form-check-label']) !!}
            </div>
        @endif
    </div>

    <div class="form-group">
        {!! Form::label(__('Description (Optional)')) !!}
        {!! Form::textarea('description', $shop->description, ['class' => 'form-control wysiwyg']) !!}
    </div>

    <div class="form-group">
        {!! Form::checkbox('is_active', 1, $shop->id ? $shop->is_active : 1, ['class' => 'form-check-input', 'data-toggle' => 'toggle']) !!}
        {!! Form::label('is_active', __('Set Active'), ['class' => 'form-check-label ml-3']) !!} {!! add_help(__('If turned off, the shop will not be visible to regular users.')) !!}
    </div>

    <div class="text-right">
        {!! Form::submit($shop->id ? __('Edit') : __('Create'), ['class' => 'btn btn-primary']) !!}
    </div>

    {!! Form::close() !!}

    @if ($shop->id)
        <h3>{{ __('Shop Stock') }}</h3>
        {!! Form::open(['url' => 'admin/data/shops/stock/' . $shop->id]) !!}
        <div class="text-right mb-3">
            <a href="#" class="add-stock-button btn btn-outline-primary">{{ __('Add Stock') }}</a>
        </div>
        <div id="shopStock">
            @foreach ($shop->stock as $key => $stock)
                @include('admin.shops._stock', ['stock' => $stock, 'key' => $key])
            @endforeach
        </div>
        <div class="text-right">
            {!! Form::submit(__('Edit'), ['class' => 'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
        <div class="" id="shopStockData">
            @include('admin.shops._stock', ['stock' => null, 'key' => 0])
        </div>
    @endif

@endsection

@section('scripts')
    @parent
    <script>
        $(document).ready(function() {
            var $shopStock = $('#shopStock');
            var $stock = $('#shopStockData').find('.stock');

            $('.delete-shop-button').on('click', function(e) {
                e.preventDefault();
                loadModal("{{ url('admin/data/shops/delete') }}/{{ $shop->id }}", '{{ __('Delete Shop') }}');
            });
            $('.add-stock-button').on('click', function(e) {
                e.preventDefault();

                var clone = $stock.clone();
                $shopStock.append(clone);
                clone.removeClass('hide');
                attachStockListeners(clone);
                refreshStockFieldNames();
            });

            attachStockListeners($('#shopStock .stock'));

            function attachStockListeners(stock) {
                stock.find('.stock-toggle').bootstrapToggle();
                stock.find('.stock-limited').on('change', function(e) {
                    var $this = $(this);
                    if ($this.is(':checked')) {
                        $this.parent().parent().parent().parent().find('.stock-limited-quantity').removeClass('hide');
                    } else {
                        $this.parent().parent().parent().parent().find('.stock-limited-quantity').addClass('hide');
                    }
                });
                stock.find('.remove-stock-button').on('click', function(e) {
                    e.preventDefault();
                    $(this).parent().parent().parent().remove();
                    refreshStockFieldNames();
                });
                stock.find('.card-body [data-toggle=tooltip]').tooltip({
                    html: true
                });
            }

            function refreshStockFieldNames() {
                $('.stock').each(function(index) {
                    var $this = $(this);
                    var key = index;
                    $this.find('.stock-field').each(function() {
                        $(this).attr('name', $(this).data('name') + '[' + key + ']');
                    });
                });
            }
        });
    </script>
@endsection
