@if ($request->user_id == Auth::user()->id)
    @if ($request->status == 'Draft')
        <p>이 요청을 삭제하면 첨부된 모든 아이템 및 재화가 사용자에게 반환됩니다.</p>
        <p>정말로 이 요청을 삭제하시겠습니까?</p>
        {!! Form::open(['url' => 'designs/' . $request->id . '/delete', 'class' => 'text-right']) !!}
        {!! Form::submit('요청 삭제', ['class' => 'btn btn-danger']) !!}
        {!! Form::close() !!}
    @else
        <p class="text-danger">이 요청은 이미 대기열에 제출되었으며 삭제할 수 없습니다.</p>
    @endif
@else
    <div>이 요청을 삭제할 권한이 없습니다.</div>
@endif
