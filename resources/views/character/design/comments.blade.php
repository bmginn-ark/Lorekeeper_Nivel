@extends('character.design.layout')

@section('design-title')
    요청 (#{{ $request->id }}) :: 코멘트
@endsection

@section('design-content')
    {!! breadcrumbs(['Design Approvals' => 'designs', 'Request (#' . $request->id . ')' => 'designs/' . $request->id, 'Comments' => 'designs/' . $request->id . '/comments']) !!}

    @include('character.design._header', ['request' => $request])

    <h2>코멘트</h2>

    @if ($request->status == 'Draft' && $request->user_id == Auth::user()->id)
        <p>요청에 대한 선택적 코멘트를 입력하세요 (예: 계산). 스태프는 요청을 검토할 때 이 코멘트를 고려합니다. 코멘트가 없는 경우 저장 버튼을 한 번 클릭하여 이 섹션을 완료로 표시하세요.</p>
        {!! Form::open(['url' => 'designs/' . $request->id . '/comments']) !!}
        <div class="form-group">
            {!! Form::label('코멘트 (옵션)') !!}
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
