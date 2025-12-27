@extends('character.design.layout')

@section('design-title')
    요청 (#{{ $request->id }})
@endsection

@section('design-content')
    {!! breadcrumbs(['Design Approvals' => 'designs', 'Request (#' . $request->id . ')' => 'designs/' . $request->id]) !!}

    @include('character.design._header', ['request' => $request])

    @if ($request->status == 'Draft')
        <p>
            이 요청은 아직 승인 대기열에 제출되지 않았습니다.
            @if ($request->user_id == Auth::user()->id)
                스태프 멤버는 직접 링크가 제공되면 이 페이지를 볼 수 있습니다. 탭을 클릭하여 섹션을 편집하세요.
            @else
                마스터리스트를 편집할 수 있는 스태프 멤버로서, 탭을 클릭하여 요청의 세부 정보를 볼 수 있습니다.
            @endif
        </p>
        @if ($request->user_id == Auth::user()->id)
            @if ($request->isComplete)
                <div class="text-right">
                    <button class="btn btn-outline-danger delete-button">요청 삭제</button>
                    <a href="#" class="btn btn-outline-primary submit-button">요청 제출</a>
                </div>
            @else
                <p class="text-danger">모든 섹션이 아직 완료되지 않았습니다. 정보 수정이 필요하지 않더라도 필요한 탭을 방문하여 저장을 클릭하여 업데이트하세요.</p>
                <div class="text-right">
                    <button class="btn btn-outline-danger delete-button">요청 삭제</button>
                    <button class="btn btn-outline-primary" disabled>요청 제출</button>
                </div>
            @endif
        @endif
    @elseif($request->status == 'Pending')
        <p>
            이 요청은 승인 대기열에 있습니다.
            @if (!Auth::user()->hasPower('manage_characters'))
                처리될 때까지 기다려 주세요.
            @else
                마스터리스트를 편집할 수 있는 스태프 멤버로서, 요청의 세부 정보를 볼 수 있지만 일부만 편집할 수 있습니다.
            @endif
        </p>
        @if (Auth::user()->hasPower('manage_characters'))
            <div class="card mb-3">
                <div class="card-body">
                    <a href="#" class="btn btn-outline-secondary process-button btn-sm float-right" data-action="cancel">취소</a>
                    <strong class="text-secondary">취소</strong> 요청하면 초안 상태로 반환되어 사용자가 추가 편집을 할 수 있습니다.
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-body">
                    <a href="#" class="btn btn-outline-success process-button btn-sm float-right" data-action="approve">승인</a>
                    <strong class="text-success">승인</strong> 요청이 업데이트를 생성합니다.
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <a href="#" class="btn btn-outline-danger process-button btn-sm float-right" data-action="reject">거절</a>
                    <strong class="text-danger">거절</strong> 요청하면 첨부된 모든 항목이 반환되고 사용자는 더 이상 편집할 수 없습니다.
                </div>
            </div>
        @endif
    @elseif($request->status == 'Approved')
        <p>이 요청은 승인되었습니다. 데이터는 이 제출의 기록으로 보존됩니다.</p>
    @endif

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            @if ($request->user_id == Auth::user()->id && $request->status == 'Draft')
                $('.submit-button').on('click', function(e) {
                    e.preventDefault();
                    loadModal("{{ url('designs/' . $request->id . '/confirm/') }}", 'Confirm Submission');
                });
                $('.delete-button').on('click', function(e) {
                    e.preventDefault();
                    loadModal("{{ url('designs/' . $request->id . '/delete/') }}", 'Delete Submission');
                });
            @endif

            @if (Auth::user()->hasPower('manage_characters'))
                $('.process-button').on('click', function(e) {
                    e.preventDefault();
                    loadModal("{{ url('admin/designs/edit/' . $request->id) }}/" + $(this).data('action'), 'Confirm Action');
                });
            @endif
        });
    </script>
@endsection
