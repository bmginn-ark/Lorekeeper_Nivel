@if ($trade)
    @if ($trade->sender_id == Auth::user()->id)
        @if (!$trade->is_sender_confirmed)
            <p>
                제안을 승인합니다. @if (!$trade->is_recipient_confirmed)
                    상대방이 제안을 확인한 후에는 전체 거래를 승인할 수 있습니다.
                @endif
            </p>
        @else
            <p>
                제안을 승인합니다. @if ($trade->is_sender_trade_confirmed || $trade->is_recipient_trade_confirmed)
                   거래는 제안을 재확인한 후 양측에서 다시 확인해야 합니다.
                @endif
            </p>
        @endif
        {!! Form::open(['url' => 'trades/' . $trade->id . '/confirm-offer']) !!}
        <div class="text-right">
            {!! Form::submit($trade->is_sender_confirmed ? 'Unconfirm' : 'Confirm', ['class' => 'btn btn-' . ($trade->is_sender_confirmed ? 'danger' : 'primary')]) !!}
        </div>
        {!! Form::close() !!}
    @else
        @if (!$trade->is_recipient_confirmed)
            <p>
                제안을 승인합니다. @if (!$trade->is_sender_confirmed)
                    상대방이 제안을 확인한 후에는 전체 거래를 승인할 수 있습니다.
                @endif
            </p>
        @else
            <p>
                제안을 승인합니다. @if ($trade->is_recipient_trade_confirmed || $trade->is_sender_trade_confirmed)
                    거래는 제안을 재확인한 후 양측에서 다시 확인해야 합니다.
                @endif
            </p>
        @endif
        {!! Form::open(['url' => 'trades/' . $trade->id . '/confirm-offer']) !!}
        <div class="text-right">
            {!! Form::submit($trade->is_recipient_confirmed ? 'Unconfirm' : 'Confirm', ['class' => 'btn btn-' . ($trade->is_recipient_confirmed ? 'danger' : 'primary')]) !!}
        </div>
        {!! Form::close() !!}
    @endif
@else
@endif
