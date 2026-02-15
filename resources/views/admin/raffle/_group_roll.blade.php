@if ($group->is_active < 2)
    <div class="text-center">
        <p>{{ __('This will roll all the raffles in the group :name. Winners of raffles that come first will be excluded from later raffles.', ['name' => '<strong>'.$group->name.'</strong>']) }}</p>
        {!! Form::open(['url' => 'admin/raffles/roll/group/' . $group->id]) !!}
        {!! Form::submit(__('Roll!'), ['class' => 'btn btn-primary']) !!}
        {!! Form::close() !!}
    </div>
@else
    <div class="text-center">{{ __('This set of raffles has already been completed.') }}</div>
@endif
