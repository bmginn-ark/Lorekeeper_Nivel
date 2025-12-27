@extends('character.design.layout')

@section('design-title')
    요청 (#{{ $request->id }}) :: 코멘트
@endsection

@section('design-content')
    {!! breadcrumbs(['디자인 승인' => 'designs', '요청 (#' . $request->id . ')' => 'designs/' . $request->id, '코멘트' => 'designs/' . $request->id . '/comments']) !!}

    @include('character.design._header', ['request' => $request])

    <h2>코멘트</h2>

    @if ($request->status == 'Draft' && $request->user_id == Auth::user()->id)
        <p>
            제출 내용에 대해 스태프가 검토 시 참고할 수 있는 선택적 코멘트(예: 계산 방식 등)를 입력하세요.
            코멘트가 없다면, 이 섹션을 완료 처리하기 위해 저장 버튼을 한 번 눌러주시면 됩니다.
        </p>

        {!! Form::open(['url' => 'designs/' . $request->id . '/comments']) !!}
        <div class="form-group">
            {!! Form::label('코멘트 (선택)') !!}
            {!! Form::textarea('comments', $request->comments, ['class' => 'form-control']) !!}
        </div>
        <div class="text-right">
            {!! Form::submit('저장', ['class' => 'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
    @else
        <div class="card">
            <div class="card-body">
                {!! nl2br(htmlentities($request->comments)) !!}
            </div>
        </div>
    @endif
@endsection
