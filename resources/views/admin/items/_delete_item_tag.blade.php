@if ($tag)
    {!! Form::open(['url' => 'admin/data/items/delete-tag/' . $item->id . '/' . $tag->tag]) !!}

    <p>{{ __('You are about to delete the tag :tag from :item. This is not reversible. If you would like to preserve the tag data without deleting the tag, you may want to set the Active toggle to Off instead.', ['tag' => '<strong>'.$tag->getName().'</strong>', 'item' => $item->name]) }}</p>
    <p>{{ __('Are you sure you want to delete :name?', ['name' => '<strong>'.$tag->getName().'</strong>']) }}</p>

    <div class="text-right">
        {!! Form::submit(__('Delete Tag'), ['class' => 'btn btn-danger']) !!}
    </div>

    {!! Form::close() !!}
@else
    {{ __('Invalid tag selected.') }}
@endif
