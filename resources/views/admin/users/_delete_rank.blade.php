@if ($rank)
    {!! Form::open(['url' => 'admin/users/ranks/delete/' . $rank->id]) !!}

    <p>{{ __('You are about to delete the rank :name. This is not reversible and you will only be able to delete it if there are no users with this rank.', ['name' => $rank->name]) }}</p>
    <p>{{ __('Are you sure you want to delete :name?', ['name' => $rank->name]) }}</p>

    <div class="text-right">
        {!! Form::submit(__('Delete Rank'), ['class' => 'btn btn-danger']) !!}
    </div>

    {!! Form::close() !!}
@else
    {{ __('Invalid rank selected.') }}
@endif
