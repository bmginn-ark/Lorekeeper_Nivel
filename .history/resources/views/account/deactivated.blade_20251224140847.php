@extends('layouts.app')

@section('title')
    비활성화
@endsection

@section('content')
    {!! breadcrumbs(['Deactivated' => 'banned']) !!}

    <h1>비활성화</h1>

    <p>계정이 {!! format_date(Auth::user()->settings->deactivated_at) !!}에 비활성화되었습니다. {{ Auth::user()->settings->deactivate_reason ? '다음 사유가 주어졌습니다:' : '' }}</p>

    @if (Auth::user()->settings->deactivate_reason)
        <div class="alert alert-danger">
            <div class="alert-header">{!! Auth::user()->deactivater->displayName !!}:</div>
            {!! nl2br(htmlentities(Auth::user()->settings->deactivate_reason)) !!}
        </div>
    @endif

    <p>사이트 기능을 계속 사용할 수 없습니다. 계정에 연결된 항목, 통화, 문자 및 기타 자산은 다른 사용자에게 이전할 수 없으며, 다른 사용자가 계정으로 자산을 이전할 수도 없습니다. 보류 중인 모든 항목 제출물도 제출 대기열에서 삭제되었습니다.
    </p>

    @if (Auth::user()->is_deactivated)
        <div class="text-right">
            <a href="#" class="btn btn-outline-danger reactivate-button">Reactivate Account</a>
        </div>
    @endif
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('.reactivate-button').on('click', function(e) {
                e.preventDefault();
                loadModal("{{ url('reactivate') }}", 'Reactivate Account');
            });
        });
    </script>
@endsection
