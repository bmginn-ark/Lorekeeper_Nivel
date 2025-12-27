@extends('character.design.layout')

@section('design-title')
    요청 (#{{ $request->id }})
@endsection

@section('design-content')
    {!! breadcrumbs(['디자인 승인' => 'designs', '요청 (#' . $request->id . ')' => 'designs/' . $request->id]) !!}

    @include('character.design._header', ['request' => $request])

    @if ($request->status == 'Draft')
        <p>
            이 요청은 아직 승인 대기열에 제출되지 않았습니다.
            @if ($request->user_id == Auth::user()->id)
                스태프는 직접 링크가 제공된 경우 이 페이지를 볼 수 있습니다. 각 탭을 클릭하여 해당 섹션을 수정할 수 있습니다.
            @else
                마스터리스트를 수정할 수 있는 권한을 가진 스태프로서, 탭을 클릭하여 요청의 세부 내용을 확인할 수 있습니다.
            @endif
        </p>
        @if ($request->user_id == Auth::user()->id)
            @if ($request->isComplete)
                <div class="text-right">
                    <button class="btn btn-outline-danger delete-button">요청 삭제</button>
                    <a href="#" class="btn btn-outline-primary submit-button">요청 제출</a>
                </div>
            @else
                <p class="text-danger">아직 모든 섹션이 완료되지 않았습니다. 수정할 내용이 없더라도 필요한 탭으로 이동하여 저장을 눌러 정보를 갱신해 주세요.</p>
                <div class="text-right">
                    <button class="btn btn-outline-danger delete-button">요청 삭제</button>
                    <button class="btn btn-outline-primary" disabled>요청 제출</button>
                </div>
            @endif
        @endif
    @elseif($request->status == 'Pending')
        <p>
            이 요청은 현재 승인 대기열에 있습니다.
            @if (!Auth::user()->hasPower('manage_characters'))
                처리될 때까지 기다려 주세요.
            @else
                마스터리스트를 수정할 수 있는 권한을 가진 스태프로서, 요청의 세부 내용을 확인할 수 있지만 일부 항목만 수정할 수 있습니다.
            @endif
        </p>
        @if (Auth::user()->hasPower('manage_characters'))
            <div class="card mb-3">
                <div class="card-body">
                    <a href="#" class="btn btn-outline-secondary process-button btn-sm float-right" data-action="cancel">취소</a>
                    요청을 <strong class="text-secondary">취소</strong>하면 초안 상태로 돌아가며, 사용자가 다시 수정할 수 있습니다.
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-body">
                    <a href="#" class="btn btn-outline-success process-button btn-sm float-right" data-action="approve">승인</a>
                    요청을 <strong class="text-success">승인</strong>하면 업데이트가 생성됩니다.
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <a href="#" class="btn btn-outline-danger process-button btn-sm float-right" data-action="reject">반려</a>
                    요청을 <strong class="text-danger">반려</strong>하면 첨부된 아이템이 반환되며, 사용자는 더 이상 수정할 수 없습니다.
                </div>
            </div>
        @endif
    @elseif($request->status == 'Approved')
        <p>이 요청은 승인되었습니다. 제출 기록으로 데이터가 보존됩니다.</p>
    @endif

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            @if ($request->user_id == Auth::user()->id && $request->status == 'Draft')
                $('.submit-button').on('click', function(e) {
                    e.preventDefault();
                    loadModal("{{ url('designs/' . $request->id . '/confirm/') }}", '제출 확인');
                });
                $('.delete-button').on('click', function(e) {
                    e.preventDefault();
                    loadModal("{{ url('designs/' . $request->id . '/delete/') }}", '요청 삭제');
                });
            @endif

            @if (Auth::user()->hasPower('manage_characters'))
                $('.process-button').on('click', function(e) {
                    e.preventDefault();
                    loadModal("{{ url('admin/designs/edit/' . $request->id) }}/" + $(this).data('action'), '작업 확인');
                });
            @endif
        });
    </script>
@endsection
