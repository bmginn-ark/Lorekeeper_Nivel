@if ($request->user_id == Auth::user()->id)
    @if ($request->isComplete)
        <p>이렇게 하면 디자인 승인 요청이 제출됩니다. 요청이 대기열에 있는 동안에는 <u>를 편집할 수 없습니다. </p>
        <p>이 요청을 제출하시겠습니까?</p>
        {!! Form::open(['url' => 'designs/' . $request->id . '/submit', 'class' => 'text-right']) !!}
        {!! Form::submit('Submit Request', ['class' => 'btn btn-primary']) !!}
        {!! Form::close() !!}
    @else
        <p class="text-danger">모든 섹션이 아직 완료되지 않았습니다. 정보 수정이 필요하지 않더라도 필요한 탭을 방문하여 저장을 클릭하여 업데이트하세요.</p>
        <div class="text-right">
            <button class="btn btn-primary" disabled>요청 제출</button>
        </div>
    @endif
@else
    <div>You cannot submit this request.</div>
@endif
