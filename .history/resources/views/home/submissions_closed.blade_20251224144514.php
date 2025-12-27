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
            제출 닫힘
        @else
            {!! breadcrumbs(['Prompt Submissions' => 'submissions', 'New Submission' => 'submissions/new']) !!}
        @endif
    </h1>

    {!! Form::open(['url' => $isClaim ? 'claims/new' : 'submissions/new', 'id' => 'submissionForm']) !!}
    @if (!$isClaim)
        <div class="form-group">
            {!! Form::label('prompt_id', '프롬프트') !!}
            {!! Form::select('prompt_id', $prompts, null, ['class' => 'form-control selectize', 'id' => 'prompt', 'placeholder' => '']) !!}
        </div>
    @endif
    <div class="form-group">
        {!! Form::label('url', $isClaim ? 'URL' : '제출 URL') !!}
        @if ($isClaim)
            {!! add_help('Enter a URL relevant to your claim (for example, a comment proving you may make this claim). This field cannot be left blank.') !!}
        @else
            {!! add_help('Enter the URL of your submission (whether uploaded to dA or some other hosting service). This field cannot be left blank.') !!}
        @endif
        {!! Form::text('url', null, ['class' => 'form-control', 'required']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('comments', '코멘트 (옵션)') !!} {!! add_help('Enter a comment for your ' . ($isClaim ? 'claim' : 'submission') . ' (no HTML). This will be viewed by the mods when reviewing your ' . ($isClaim ? 'claim' : 'submission') . '.') !!}
        {!! Form::textarea('comments', null, ['class' => 'form-control']) !!}
    </div>

    <h2>보상</h2>
    @if ($isClaim)
        <p>청구하고자 하는 보상을 선택합니다.</p>
    @else
        <p>여기에 추가된 보상은 기본 프롬프트 보상 외에도 추가됩니다. 추가 보상이 필요하지 않은 경우 이 항목을 비워둘 수 있습니다.</p>
    @endif
    @include('widgets._loot_select', ['loots' => null, 'showLootTables' => false])
    @if (!$isClaim)
        <div id="rewards" class="mb-3"></div>
    @endif

    <h2>캐릭터</h2>
    @if ($isClaim)
        <p>캐릭터별 보상을 청구하고 싶은 경우 여기에 첨부하세요. 그렇지 않으면 이 섹션을 비워둘 수 있습니다.</p>
    @endif
    <div id="characters" class="mb-3">
    </div>
    <div class="text-right mb-3">
        <a href="#" class="btn btn-outline-info" id="addCharacter">캐릭터 추가</a>
    </div>

    <div class="text-right">
        <a href="#" class="btn btn-primary" id="submitButton">제출</a>
    </div>
    {!! Form::close() !!}

    @include('widgets._character_select', [
        'characterCurrencies' => \App\Models\Currency\Currency::where('is_character_owned', 1)->orderBy('sort_character', 'DESC')->pluck('name', 'id'),
    ])
    @include('widgets._loot_select_row', ['showLootTables' => false])


    <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="modal-title h5 mb-0">{{ $isClaim ? '수령' : '제출' }} 승인</span>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p>이 폼을 제출하고 {{ $isClaim ? '수령' : '제출' }} 승인 대기열에 넣습니다. {{ $isClaim ? '수령' : '제출' }}이 생성된 후에는 내용을 편집할 수 없습니다. 확인 버튼을 클릭하여 {{ $isClaim ? 'claim' : 'submission' }}을 완료하세요.</p>
                    <div class="text-right">
                        <a href="#" id="formSubmit" class="btn btn-primary">Confirm</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
