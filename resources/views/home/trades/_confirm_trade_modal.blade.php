@if ($trade)
    @if ($trade->sender_id == Auth::user()->id)
        @if (!$trade->is_sender_trade_confirmed)
            <p>
                거래를 승인합니다. @if (!$trade->is_recipient_trade_confirmed)
                상대방이 거래를 확인한 후에는 이 거래의 내용을 더 이상 편집할 수 없습니다.
                @else
                    이 거래의 내용을 더 이상 편집할 수 없습니다.
                @endif
            </p>
            {!! Form::open(['url' => 'trades/' . $trade->id . '/confirm-trade']) !!}
            <div class="text-right">
                {!! Form::submit('Confirm', ['class' => 'btn btn-primary']) !!}
            </div>
            {!! Form::close() !!}
        @else
            <p>
                이미 이 거래를 승인했습니다. @if (!$trade->is_recipient_trade_confirmed)
                    거래를 확인하려면 {!! $trade->recipient->displayName !!}를 기다려 주세요.
                @endif
            </p>
        @endif
    @else
        @if (!$trade->is_recipient_trade_confirmed)
            <p>
                거래를 승인합니다. @if (!$trade->is_recipient_trade_confirmed)
                    상대방이 거래를 확인한 후에는 이 거래의 내용을 더 이상 편집할 수 없습니다.
                @else
                    이 거래의 내용을 더 이상 편집할 수 없습니다.
                @endif
            </p>
            {!! Form::open(['url' => 'trades/' . $trade->id . '/confirm-trade']) !!}
            <div class="text-right">
                {!! Form::submit('승인', ['class' => 'btn btn-primary']) !!}
            </div>
            {!! Form::close() !!}
        @else
            <p>
                이미 이 거래를 승인했습니다. @if (!$trade->is_sender_trade_confirmed)
                    거래를 확인하려면 {!! $trade->sender->displayName !!}를 기다려 주세요.
                @endif
            </p>
        @endif
    @endif
@else
@endif
