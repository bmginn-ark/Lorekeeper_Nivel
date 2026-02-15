@extends('admin.layout')

@section('admin-title')
    {{ __('Grant Items') }}
@endsection

@section('admin-content')
    {!! breadcrumbs([__('Admin Panel') => 'admin', __('Grant Items') => 'admin/grants/items']) !!}

    <h1>{{ __('Grant Items') }}</h1>

    {!! Form::open(['url' => 'admin/grants/items']) !!}

    <h3>{{ __('Basic Information') }}</h3>

    <div class="form-group">
        {!! Form::label('names[]', __('Username(s)')) !!} {!! add_help(__('You can select up to 10 users at once.')) !!}
        {!! Form::select('names[]', $users, null, ['id' => 'usernameList', 'class' => 'form-control', 'multiple']) !!}
    </div>

    <div class="form-group">
        {!! Form::label(__('Item(s)')) !!} {!! add_help(__('Must have at least 1 item and Quantity must be at least 1.')) !!}
        <div id="itemList">
            <div class="d-flex mb-2">
                {!! Form::select('item_ids[]', $items, null, ['class' => 'form-control mr-2 default item-select', 'placeholder' => __('Select an Item')]) !!}
                {!! Form::text('quantities[]', 1, ['class' => 'form-control mr-2', 'placeholder' => __('Quantity')]) !!}
                <a href="#" class="remove-item btn btn-danger mb-2 disabled">×</a>
            </div>
        </div>
        <div><a href="#" class="btn btn-primary" id="add-item">{{ __('Add Item') }}</a></div>
        <div class="item-row hide mb-2">
            {!! Form::select('item_ids[]', $items, null, ['class' => 'form-control mr-2 item-select', 'placeholder' => __('Select an Item')]) !!}
            {!! Form::text('quantities[]', 1, ['class' => 'form-control mr-2', 'placeholder' => __('Quantity')]) !!}
            <a href="#" class="remove-item btn btn-danger mb-2">×</a>
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('data', __('Reason (Optional)')) !!} {!! add_help(__('A reason for the grant. This will be noted in the logs and in the inventory description.')) !!}
        {!! Form::text('data', null, ['class' => 'form-control', 'maxlength' => 400]) !!}
    </div>

    <h3>{{ __('Additional Data') }}</h3>

    <div class="form-group">
        {!! Form::label('notes', __('Notes (Optional)')) !!} {!! add_help(__('Additional notes for the item. This will appear in the item\'s description, but not in the logs.')) !!}
        {!! Form::text('notes', null, ['class' => 'form-control', 'maxlength' => 400]) !!}
    </div>

    <div class="form-group">
        {!! Form::checkbox('disallow_transfer', 1, 0, ['class' => 'form-check-input', 'data-toggle' => 'toggle']) !!}
        {!! Form::label('disallow_transfer', __('Account-bound'), ['class' => 'form-check-label ml-3']) !!} {!! add_help(__('If this is on, the recipient(s) will not be able to transfer this item to other users. Items that disallow transfers by default will still not be transferrable.')) !!}
    </div>

    <div class="text-right">
        {!! Form::submit(__('Submit'), ['class' => 'btn btn-primary']) !!}
    </div>

    {!! Form::close() !!}

    <script>
        $(document).ready(function() {
            $('#usernameList').selectize({
                maxItems: 10
            });
            $('.default.item-select').selectize();
            $('#add-item').on('click', function(e) {
                e.preventDefault();
                addItemRow();
            });
            $('.remove-item').on('click', function(e) {
                e.preventDefault();
                removeItemRow($(this));
            })

            function addItemRow() {
                var $rows = $("#itemList > div")
                if ($rows.length === 1) {
                    $rows.find('.remove-item').removeClass('disabled')
                }
                var $clone = $('.item-row').clone();
                $('#itemList').append($clone);
                $clone.removeClass('hide item-row');
                $clone.addClass('d-flex');
                $clone.find('.remove-item').on('click', function(e) {
                    e.preventDefault();
                    removeItemRow($(this));
                })
                $clone.find('.item-select').selectize();
            }

            function removeItemRow($trigger) {
                $trigger.parent().remove();
                var $rows = $("#itemList > div")
                if ($rows.length === 1) {
                    $rows.find('.remove-item').addClass('disabled')
                }
            }
        });
    </script>
@endsection
