@if ($request->user_id == Auth::user()->id)
    @if ($request->status == 'Draft')
        <p>이렇게 하면 요청이 삭제되고 첨부된 모든 항목/통화가 반환됩니다.</p>
        <p>이 요청을 삭제하시겠습니까?</p>
        {!! Form::open(['url' => 'designs/' . $request->id . '/delete', 'class' => 'text-right']) !!}
        {!! Form::submit('Delete Request', ['class' => 'btn btn-danger']) !!}
        {!! Form::close() !!}
    @else
        <p class="text-danger">This request has already been submitted to the queue and cannot be deleted.</p>
    @endif
@else
    <div>You cannot delete this request.</div>
@endif
