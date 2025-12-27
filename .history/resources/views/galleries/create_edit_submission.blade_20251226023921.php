@extends('galleries.layout')

@section('gallery-title')
    {{ $submission->id ? '편집' : '생성' }} 제출물
@endsection

@section('gallery-content')
    {!! breadcrumbs([
        '갤러리' => 'gallery',
        $gallery->name => 'gallery/' . $gallery->id,
        ($submission->id ? '편집' : '생성') . ' 제출물' => $submission->id ? 'gallery/submissions/edit/' . $submission->id : 'gallery/submit/' . $gallery->id,
    ]) !!}

    <h1>
        {{ $submission->id ? '제출물 편집 (#' . $submission->id . ', "' . $submission->displayTitle . '")' : $gallery->name . '에 제출' }}
        @if ($submission->id)
            <div class="float-right">
                @if ($submission->status == 'Accepted')
                    <a href="#" class="btn btn-warning archive-submission-button">{{ $submission->isVisible ? '보관' : '보관 해제' }}</a>
                @endif
                <a href="/gallery/view/{{ $submission->id }}" class="btn btn-outline-primary">제출물 보기</a>
            </div>
        @endif
    </h1>

    @if (!$submission->id && ($closed || !$gallery->canSubmit(Settings::get('gallery_submissions_open'), Auth::user())))
        <div class="alert alert-danger">
            @if ($closed)
                현재 갤러리 제출이 마감되었습니다.
            @else
                이 갤러리에 제출할 수 없습니다.
            @endif
        </div>
    @else
        {!! Form::open(['url' => $submission->id ? 'gallery/edit/' . $submission->id : 'gallery/submit', 'id' => 'gallerySubmissionForm', 'files' => true]) !!}

        <h2>메인 콘텐츠</h2>
        <p>
            제출물의 콘텐츠로 이미지 및/또는 텍스트를 업로드하세요.
            이미지와 텍스트를 함께 업로드하는 것도 <strong>가능</strong>합니다.
        </p>

        <div class="form-group">
            {!! Form::label('이미지') !!}
            @if ($submission->id && isset($submission->hash) && $submission->hash)
                <div class="card mb-2" id="existingImage">
                    <div class="card-body text-center">
                        <img src="{{ $submission->imageUrl }}" style="max-width:100%; max-height:60vh;" alt="이미지 제출물" />
                    </div>
                </div>
            @endif
            <div class="card mb-2 hide" id="imageContainer">
                <div class="card-body text-center">
                    <img src="#" id="image" style="max-width:100%; max-height:60vh;" alt="이미지 제출물" />
                </div>
            </div>
            <div class="card p-2">
                <div class="custom-file">
                    {!! Form::label('image', '파일 선택...', ['class' => 'custom-file-label']) !!}
                    {!! Form::file('image', ['class' => 'custom-file-input', 'id' => 'mainImage']) !!}
                </div>
                <small>이미지는 PNG, GIF, JPG, WebP 형식이며 최대 3MB까지 가능합니다.</small>
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('텍스트') !!}
            {!! Form::textarea('text', $submission->text ?? old('text'), ['class' => 'form-control wysiwyg']) !!}
        </div>

        <div class="row">
            <div class="col-md">
                <h3>기본 정보</h3>

                <div class="form-group">
                    {!! Form::label('제목') !!}
                    {!! add_help('작품이 교환, 선물, 프롬프트용인지 등을 제목에 따로 적을 필요는 없습니다. 해당 정보는 이 양식의 다른 입력값에 따라 자동으로 표시됩니다.') !!}
                    {!! Form::text('title', $submission->title ?? old('title'), ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('설명 (선택 사항)') !!}
                    {!! Form::textarea('description', $submission->description ?? old('description'), ['class' => 'form-control wysiwyg']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('콘텐츠 워닝 (선택 사항)') !!}
                    {!! add_help(
                        '필요한 경우 간단한 콘텐츠 경고를 작성하세요. 경고가 있을 경우 썸네일은 기본 이미지로 대체되며, 경고 문구가 표시됩니다. 제출물 페이지에서는 전체 콘텐츠가 표시됩니다.'
                    ) !!}
                    {!! Form::text('content_warning', $submission->content_warning ?? old('content_warning'), ['class' => 'form-control']) !!}
                </div>

                @if ($gallery->prompt_selection == 1 && (!$submission->id || Auth::user()->hasPower('manage_submissions')))
                    <div class="form-group">
                        {!! Form::label(
                            'prompt_id',
                            ($submission->id && Auth::user()->hasPower('manage_submissions') ? '[관리자] ' : '') . '프롬프트 (선택 사항)'
                        ) !!}
                        {!! add_help(
                            '여기서 프롬프트를 선택해도 자동으로 해당 프롬프트에 제출되지는 않습니다. 별도로 제출해야 합니다. 선택한 프롬프트는 참고용으로 제출물 페이지에 표시되며, 생성 후에는 수정할 수 없습니다.'
                        ) !!}
                        {!! Form::select('prompt_id', $prompts, $submission->prompt_id ?? old('prompt_id'), ['class' => 'form-control selectize', 'id' => 'prompt', 'placeholder' => '프롬프트 선택']) !!}
                    </div>
                @else
                    {!! $submission->prompt_id ? '<p><strong>프롬프트:</strong> ' . $submission->prompt->displayName . '</p>' : '' !!}
                @endif

                @if ($submission->id && Auth::user()->hasPower('manage_submissions'))
                    <div class="form-group">
                        {!! Form::label('gallery_id', '[관리자] 갤러리 변경 / 제출물 이동') !!}
                        {!! add_help(
                            '제출물을 다른 갤러리로 이동해야 할 경우 사용하세요. 비워두면 현재 갤러리에 유지됩니다.'
                        ) !!}
                        {!! Form::select('gallery_id', $galleryOptions, null, ['class' => 'form-control selectize gallery-select original', 'id' => 'gallery', 'placeholder' => '']) !!}
                    </div>
                @endif

                @if (!$submission->id)
                    {!! Form::hidden('gallery_id', $gallery->id) !!}
                @endif

                <h3>캐릭터</h3>
                <p>
                    이 작품에 등장하는 캐릭터를 추가하세요.
                    @if (Settings::get('gallery_submissions_reward_currency'))
                        이는 스태프가 {{ $currency->displayName }} 보상을 지급하는 데 도움이 됩니다.
                    @endif
                </p>

                <div class="text-right mb-3">
                    <a href="#" class="btn btn-outline-info" id="addCharacter">캐릭터 추가</a>
                </div>
            </div>
        </div>

        <div class="text-right">
            <a href="#" class="btn btn-primary" id="submitButton">제출</a>
        </div>
        {!! Form::close() !!}
    @endif
@endsection
