@if ($raffle->is_active < 2)
    <div class="text-center">
        <p>{{ __('This will roll :count winner(s) for the raffle :name.', ['count' => $raffle->winner_count, 'name' => '<b>'.$raffle->name.'</b>']) }}</p>
        {!! Form::open(['url' => 'admin/raffles/roll/raffle/' . $raffle->id]) !!}
        {!! Form::submit(__('Roll!'), ['class' => 'btn btn-primary']) !!}
        {!! Form::close() !!}
    </div>
@else
    <div class="text-center">{{ __('This raffle has already been completed.') }}</div>
@endif
