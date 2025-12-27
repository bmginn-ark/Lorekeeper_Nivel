@if ($request->user_id == Auth::user()->id)
    @if ($request->isComplete)
        <p>
            이 디자인 승인 요청을 제출합니다. 요청이 대기열에 있는 동안에는
            <u>더 이상 수정할 수 없습니다</u>.
        </p>
        <p>정말로 이 요청을 제출하시겠습니까?</p>
        {!! Form::open(['url' => 'designs/' . $request->id . '/submit', 'class' => 'text-right']) !!}
        {!! Form::submit('요청 제출', ['class' => 'btn btn-primary']) !!}
        {!! Form::close() !!}
    @else
        <p class="text-danger">
            아직 모든 섹션이 완료되지 않았습니다.
            필요한 탭으로 이동하여, 정보 수정 여부와 관계없이 한 번씩 저장해 주세요.
        </p>
        <div class="text-right">
            <button class="btn btn-primary" disabled>요청 제출</button>
        </div>
    @endif
@else
    <div>이 요청을 제출할 권한이 없습니다.</div>
@endif
