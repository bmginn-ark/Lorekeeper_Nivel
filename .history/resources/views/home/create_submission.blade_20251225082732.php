@extends('home.layout')

@section('home-title')
    새 제출
@endsection

@section('home-content')
    @if ($isClaim)
        {!! breadcrumbs(['Claims' => 'claims', 'New Claim' => 'claims/new']) !!}
    @else
        {!! breadcrumbs(['Prompt Submissions' => 'submissions', 'New Submission' => 'submissions/new']) !!}
    @endif

    <h1>
        @if ($isClaim)
            새 수령
        @else
            새 제출
        @endif
    </h1>

    @if ($closed)
        <div class="alert alert-danger">
            {{ $isClaim ? '수령' : '제출' }} 대기열은 현제 닫혀있습니다. {{ $isClaim ? '수령' : '제출' }} 초안을 이 시점에서 편집할 수 없습니다.
        </div>
    @else
        @include('home._submission_form', ['submission' => $submission])
        <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">

                <div class="modal-content hide" id="confirmContent">
                    <div class="modal-header">
                        <span class="modal-title h5 mb-0">Confirm {{ $isClaim ? 'Claim' : 'Submission' }}</span>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p>
                            {{ $isClaim ? '수령' : '제출' }} 폼을 제출하고 승인 대기열에 추가합니다.
                            {{ $isClaim ? '수령' : '제출' }}이 작성된 후에는 내용을 편집할 수 없습니다.
                            준비가 되었는지 확실하지 않다면 초안으로 저장하는 것을 고려하세요.
                            확인 버튼을 클릭하여 {{ $isClaim ? '수령' : '제출' }}을 완료합니다.
                        </p>
                        <div class="text-right">
                            <a href="#" id="confirmSubmit" class="btn btn-primary">확인</a>
                        </div>
                    </div>
                </div>

                <div class="modal-content hide" id="draftContent">
                    <div class="modal-header">
                        <span class="modal-title h5 mb-0">초안 저장</span>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p>
                            This will place the {{ $submission->prompt_id ? 'submission' : 'claim' }} into your drafts.
                            Items and other attachments will be held, similar to in design update drafts.
                        </p>
                        <div class="text-right">
                            <a href="#" id="draftSubmit" class="btn btn-success">Save as Draft</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('scripts')
    @parent
    @if (!$closed)
        @if ($isClaim)
            @include('js._loot_js', ['showLootTables' => false, 'showRaffles' => true])
        @else
            @include('js._loot_js', ['showLootTables' => false, 'showRaffles' => false])
        @endif
        @include('js._character_select_js')
        @include('widgets._inventory_select_js', ['readOnly' => true])
        @include('widgets._bank_select_row', ['owners' => [Auth::user()]])
        @include('widgets._bank_select_js', [])

        <script>
            $(document).ready(function() {
                var $confirmationModal = $('#confirmationModal');
                var $submissionForm = $('#submissionForm');

                var $confirmButton = $('#confirmButton');
                var $confirmContent = $('#confirmContent');
                var $confirmSubmit = $('#confirmSubmit');

                var $draftButton = $('#draftButton');
                var $draftContent = $('#draftContent');
                var $draftSubmit = $('#draftSubmit');

                @if (!$isClaim)
                    var $prompt = $('#prompt');
                    var $rewards = $('#rewards');

                    $prompt.selectize();
                    $prompt.on('change', function(e) {
                        $rewards.load('{{ url('submissions/new/prompt') }}/' + $(this).val());
                    });
                @endif

                $confirmButton.on('click', function(e) {
                    e.preventDefault();
                    $confirmContent.removeClass('hide');
                    $draftContent.addClass('hide');
                    $confirmationModal.modal('show');
                });

                $confirmSubmit.on('click', function(e) {
                    e.preventDefault();
                    $submissionForm.attr('action', '{{ url()->current() }}');
                    $submissionForm.submit();
                });

                $draftButton.on('click', function(e) {
                    e.preventDefault();
                    $draftContent.removeClass('hide');
                    $confirmContent.addClass('hide');
                    $confirmationModal.modal('show');
                });

                $draftSubmit.on('click', function(e) {
                    e.preventDefault();
                    $submissionForm.attr('action', '{{ url()->current() }}/draft');
                    $submissionForm.submit();
                });
            });
        </script>
    @endif
@endsection
