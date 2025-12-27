@extends('account.layout')

@section('account-title')
    설정
@endsection

@section('account-content')
    {!! breadcrumbs(['My Account' => Auth::user()->url, 'Deactivate Account' => 'account/deactivate']) !!}

    <h1>계정 비활성화</h1>

    <p>
        계정을 비활성화하려는 경우 여기에서 할 수 있습니다. 이 작업은 계정을 완전히 삭제하지 않지만 공개 정보를 숨깁니다.
        웹사이트의 구조상 이는 계정 삭제에 가장 가까운 방법입니다. 언제든지 계정을 재활성화할 수 있습니다.
    </p>
    <p>
        이 작업은 계정과 관련된 보류 중인 모든 디자인 업데이트, 제출 및 거래를 자동으로 취소합니다.
    </p>

    <div class="card p-3 mb-2">
        <h3>계정 비활성화</h3>
        {!! Form::open(['url' => 'account/deactivate', 'id' => 'deactivateForm']) !!}
        <div class="form-group">
            {!! Form::label('Reason (Optional; no HTML)') !!}
            {!! Form::textarea('deactivate_reason', Auth::user()->settings->deactivate_reason, ['class' => 'form-control']) !!}
        </div>
        <div class="text-right">
            {!! Form::submit(Auth::user()->is_deactivated ? 'Edit' : 'Deactivate', ['class' => 'btn btn' . (Auth::user()->is_deactivated ? '' : '-outline') . '-danger deactivate-button']) !!}
        </div>
        {!! Form::close() !!}
    </div>
@endsection
