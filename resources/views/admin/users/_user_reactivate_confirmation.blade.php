@if ($user->is_deactivated)
    <p>{{ __('This will reactivate the user, allowing them to use the site features again. Are you sure you want to do this?') }}</p>
    {!! Form::open(['url' => 'admin/users/' . $user->name . '/reactivate']) !!}
    <div class="text-right">
        {!! Form::submit(__('Reactivate'), ['class' => 'btn btn-danger']) !!}
    </div>
    {!! Form::close() !!}
@else
    <p>{{ __('This user is not deactivated.') }}</p>
@endif
