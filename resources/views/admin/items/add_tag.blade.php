@extends('admin.layout')

@section('admin-title')
    {{ __('Add Item Tag') }}
@endsection

@section('admin-content')
    {!! breadcrumbs([__('Admin Panel') => 'admin', __('Items') => 'admin/data/items', __('Edit Item') => 'admin/data/items/edit/' . $item->id, __('Add Item Tag') => 'admin/data/items/tag/' . $item->id]) !!}

    <h1>{{ __('Add Item Tag') }}</h1>

    <p>{{ __('Select an item tag to add to the item. You cannot add duplicate tags to the same item (they are removed from the selection). You will be taken to the parameter editing page after adding the tag.') }}</p>

    {!! Form::open(['url' => 'admin/data/items/tag/' . $item->id]) !!}

    <div class="form-group">
        {!! Form::label('tag', __('Tag')) !!}
        {!! Form::select('tag', [0 => __('Select a Tag')] + $tags, null, ['class' => 'form-control']) !!}
    </div>

    <div class="text-right">
        {!! Form::submit(__('Add Tag'), ['class' => 'btn btn-primary']) !!}
    </div>

    {!! Form::close() !!}
@endsection
