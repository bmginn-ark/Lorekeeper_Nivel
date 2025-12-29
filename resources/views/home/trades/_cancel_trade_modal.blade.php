@if ($trade && $trade->status == 'Open')
    <p>이 거래를 취소하면 모든 첨부 아이템이 소유자에게 반환됩니다. 정말로 진행하시겠습니까?</p>
    {!! Form::open(['url' => 'trades/' . $trade->id . '/cancel-trade']) !!}
    <div class="text-right">
        {!! Form::submit('취소', ['class' => 'btn btn-danger']) !!}
    </div>
    {!! Form::close() !!}
@else
    <p>잘못된 거래가 선택되었습니다.</p>
@endif
