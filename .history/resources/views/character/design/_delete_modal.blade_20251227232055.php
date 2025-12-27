@if ($request->user_id == Auth::user()->id)
    @if ($request->status == 'Draft')
        <p>이렇게 하면 요청이 삭제되고 첨부된 모든 항목/통화가 반환됩니다.</p>
        <p>이 요청을 삭제하시겠습니까?</p>
        {!! Form::open(['url' => 'designs/' . $request->id . '/delete', 'class' => 'text-right']) !!}
        {!! Form::submit('Delete Request', ['class' => 'btn btn-danger']) !!}
        {!! Form::close() !!}
    @else
        <p class="text-danger">이 요청은 이미 대기열에 제출되었으며 삭제할 수 없습니다.</p>
    @endif
@else
    <div>이 요청은 삭제할 수 없습니다.</div>
@endif
