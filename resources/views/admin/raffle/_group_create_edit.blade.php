@if (!$group->id)
    <p>
        {{ __('Raffle groups allow you to create sets of raffles that can be rolled in sequence. Users that have won something in a previous raffle will be removed from later raffles (so users will not be able to win more than once in a group).') }}
    </p>
@endif
{!! Form::open(['url' => 'admin/raffles/edit/group/' . ($group->id ?: '')]) !!}
<div class="form-group">
    {!! Form::label('name', __('Group Name')) !!} {!! add_help(__('This is the name of the raffle group (does not have to be unique), e.g. July Monthly Raffles, Event Guest Sales')) !!}
    {!! Form::text('name', $group->name, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    <label class="control-label">
        {!! Form::checkbox('is_active', 1, $group->is_active, ['class' => 'form-check-input mr-2', 'data-toggle' => 'toggle']) !!}
        {!! Form::label('is_active', __('Active (visible to users)'), ['class' => 'form-check-label ml-3']) !!} {!! add_help(__('This setting will cascade to any raffles in this group (setting the group to active will set the raffles within it to active and vice versa). Not retroactive.')) !!}
    </label>
</div>
<div class="text-right">
    {!! Form::submit(__('Confirm'), ['class' => 'btn btn-primary']) !!}
</div>
{!! Form::close() !!}
