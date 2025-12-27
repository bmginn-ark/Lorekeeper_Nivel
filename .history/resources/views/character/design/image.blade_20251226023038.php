@extends('character.design.layout')

@section('design-title')
    요청 (#{{ $request->id }}) :: 이미지
@endsection

@section('design-content')
    {!! breadcrumbs(['디자인 승인' => 'designs', '요청 (#' . $request->id . ')' => 'designs/' . $request->id, '마스터리스트 이미지' => 'designs/' . $request->id . '/image']) !!}

    @include('character.design._header', ['request' => $request])

    <h2>마스터리스트 이미지</h2>

    @if ($request->has_image)
        <div class="card mb-3">
            <div class="card-body bg-secondary text-white">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h3 class="text-center">메인 이미지</h3>
                        <div class="text-center">
                            <a href="{{ $request->imageUrl }}?v={{ $request->updated_at->timestamp }}" data-lightbox="entry" data-title="요청 #{{ $request->id }}">
                                <img src="{{ $request->imageUrl }}?v={{ $request->updated_at->timestamp }}" class="mw-100"
                                    alt="요청 {{ $request->id }}" />
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h3 class="text-center">썸네일 이미지</h3>
                        <div class="text-center">
                            <a href="{{ $request->thumbnailUrl }}?v={{ $request->updated_at->timestamp }}" data-lightbox="entry" data-title="요청 #{{ $request->id }} 썸네일">
                                <img src="{{ $request->thumbnailUrl }}?v={{ $request->updated_at->timestamp }}" class="mw-100" alt="요청 {{ $request->id }}의 썸네일" />
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            @if (!($request->status == 'Draft' && $request->user_id == Auth::user()->id))
                <div class="card-body">
                    <h4 class="mb-3">크레딧</h4>
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-4">
                            <h5>디자인</h5>
                        </div>
                        <div class="col-lg-8 col-md-6 col-8">
                            @foreach ($request->designers as $designer)
                                <div>{!! $designer->displayLink() !!}</div>
                            @endforeach
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-4">
                            <h5>아트</h5>
                        </div>
                        <div class="col-lg-8 col-md-6 col-8">
                            @foreach ($request->artists as $artist)
                                <div>{!! $artist->displayLink() !!}</div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    @endif

    @if (($request->status == 'Draft' && $request->user_id == Auth::user()->id) || ($request->status == 'Pending' && Auth::user()->hasPower('manage_characters')))
        @if ($request->status == 'Draft' && $request->user_id == Auth::user()->id)
            <p>
                마스터리스트에 사용할 이미지와 선택적으로 썸네일 이미지를 선택해 주세요.
                반드시 사용 및 크레딧 표기가 가능한 이미지 만 업로드해 주세요!
                스태프는 업로드된 이미지를 직접 수정할 수는 없지만,
                썸네일을 다시 크롭하거나 다른 썸네일을 업로드할 수 있습니다.
            </p>
        @else
            <p>
                스태프로서 업로드된 이미지 자체는 수정할 수 없지만,
                썸네일 및 크레딧은 수정할 수 있습니다.
                썸네일을 다시 크롭한 경우 변경 사항을 확인하려면 강력 새로고침이 필요할 수 있습니다.
            </p>
        @endif

        {!! Form::open(['url' => 'designs/' . $request->id . '/image', 'files' => true]) !!}

        @if ($request->status == 'Draft' && $request->user_id == Auth::user()->id)
            <div class="form-group">
                {!! Form::label('이미지') !!}
                {!! add_help('이 이미지는 마스터리스트에 사용됩니다. 이미지에는 어떠한 보호도 적용되지 않으므로, 도용을 방지하기 위한 대비를 권장합니다.') !!}
                <div class="custom-file">
                    {!! Form::label('image', '파일 선택...', ['class' => 'custom-file-label']) !!}
                    {!! Form::file('image', ['class' => 'custom-file-input', 'id' => 'mainImage']) !!}
                </div>
            </div>
        @else
            <div class="form-group">
                {!! Form::checkbox('modify_thumbnail', 1, 0, ['class' => 'form-check-input', 'data-toggle' => 'toggle']) !!}
                {!! Form::label('modify_thumbnail', '썸네일 수정', ['class' => 'form-check-label ml-3']) !!}
                {!! add_help('이 옵션을 켜면 썸네일을 수정할 수 있으며, 끄면 크레딧만 저장됩니다.') !!}
            </div>
        @endif

        @if (config('lorekeeper.settings.masterlist_image_automation') === 1)
            @if (config('lorekeeper.settings.masterlist_image_automation_hide_manual_thumbnail') === 0 || Auth::user()->hasPower('manage_characters'))
                <div class="form-group">
                    {!! Form::checkbox('use_cropper', 1, 1, ['class' => 'form-check-input', 'data-toggle' => 'toggle', 'id' => 'useCropper']) !!}
                    {!! Form::label('use_cropper', '썸네일 자동 생성 사용', ['class' => 'form-check-label ml-3']) !!}
                    {!! add_help('썸네일은 필수입니다. 자동 썸네일 생성을 사용하거나, 직접 썸네일을 업로드할 수 있습니다.') !!}
                </div>
            @else
                {!! Form::hidden('use_cropper', 1) !!}
            @endif
            <div class="card mb-3" id="thumbnailCrop">
                <div class="card-body">
                    <div id="cropSelect">이 기능을 사용하면 전체 이미지에서 자동으로 썸네일이 생성됩니다.</div>
                    {!! Form::hidden('x0', 1) !!}
                    {!! Form::hidden('x1', 1) !!}
                    {!! Form::hidden('y0', 1) !!}
                    {!! Form::hidden('y1', 1) !!}
                </div>
            </div>
        @else
            <div class="form-group">
                {!! Form::checkbox('use_cropper', 1, 1, ['class' => 'form-check-input', 'data-toggle' => 'toggle', 'id' => 'useCropper']) !!}
                {!! Form::label('use_cropper', '이미지 크롭 사용', ['class' => 'form-check-label ml-3']) !!}
                {!! add_help('썸네일은 필수입니다. 이미지 크로퍼를 사용하거나 직접 썸네일을 업로드할 수 있습니다.') !!}
            </div>
            <div class="card mb-3" id="thumbnailCrop">
                <div class="card-body">
                    <div id="cropSelect">썸네일 크롭을 사용할 이미지를 선택하세요.</div>
                    <img src="{{ $request->imageUrl }}" id="cropper" class="hide" alt="" />
                    {!! Form::hidden('x0', null, ['id' => 'cropX0']) !!}
                    {!! Form::hidden('x1', null, ['id' => 'cropX1']) !!}
                    {!! Form::hidden('y0', null, ['id' => 'cropY0']) !!}
                    {!! Form::hidden('y1', null, ['id' => 'cropY1']) !!}
                </div>
            </div>
        @endif

        @if (config('lorekeeper.settings.masterlist_image_automation') === 0 || config('lorekeeper.settings.masterlist_image_automation_hide_manual_thumbnail') === 0 || Auth::user()->hasPower('manage_characters'))
            <div class="card mb-3" id="thumbnailUpload">
                <div class="card-body">
                    {!! Form::label('썸네일 이미지') !!}
                    {!! add_help('이 이미지는 마스터리스트 목록 페이지에 표시됩니다.') !!}
                    <div class="custom-file">
                        {!! Form::label('thumbnail', '썸네일 선택...', ['class' => 'custom-file-label']) !!}
                        {!! Form::file('thumbnail', ['class' => 'custom-file-input']) !!}
                    </div>
                    <div class="text-muted">
                        권장 크기: {{ config('lorekeeper.settings.masterlist_thumbnails.width') }}px x {{ config('lorekeeper.settings.masterlist_thumbnails.height') }}px
                    </div>
                </div>
            </div>
        @endif

        <p>
            이 섹션은 이미지 제작자 크레딧을 위한 영역입니다.
            첫 번째 입력란은 사이트 내 사용자 이름(있는 경우),
            두 번째 입력란은 계정이 없는 경우 외부 링크를 입력합니다.
        </p>

        <div class="form-group">
            {!! Form::label('디자이너') !!}
            <div id="designerList">
                <?php $designerCount = count($request->designers); ?>
                @foreach ($request->designers as $count => $designer)
                    <div class="mb-2 d-flex">
                        {!! Form::select('designer_id[' . $designer->id . ']', $users, $designer->user_id, ['class' => 'form-control mr-2 selectize', 'placeholder' => '디자이너 선택']) !!}
                        {!! Form::text('designer_url[' . $designer->id . ']', $designer->url, ['class' => 'form-control mr-2', 'placeholder' => '디자이너 URL']) !!}
                        <a href="#" class="add-designer btn btn-link" data-toggle="tooltip" title="디자이너 추가" @if ($count != $designerCount - 1) style="visibility: hidden;" @endif>+</a>
                    </div>
                @endforeach
                @if (!count($request->designers))
                    <div class="mb-2 d-flex">
                        {!! Form::select('designer_id[]', $users, null, ['class' => 'form-control mr-2 selectize', 'placeholder' => '디자이너 선택']) !!}
                        {!! Form::text('designer_url[]', null, ['class' => 'form-control mr-2', 'placeholder' => '디자이너 URL']) !!}
                        <a href="#" class="add-designer btn btn-link" data-toggle="tooltip" title="디자이너 추가">+</a>
                    </div>
                @endif
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('아티스트') !!}
            <div id="artistList">
                <?php $artistCount = count($request->artists); ?>
                @foreach ($request->artists as $count => $artist)
                    <div class="mb-2 d-flex">
                        {!! Form::select('artist_id[' . $artist->id . ']', $users, $artist->user_id, ['class' => 'form-control mr-2 selectize', 'placeholder' => '아티스트 선택']) !!}
                        {!! Form::text('artist_url[' . $artist->id . ']', $artist->url, ['class' => 'form-control mr-2', 'placeholder' => '아티스트 URL']) !!}
                        <a href="#" class="add-artist btn btn-link" data-toggle="tooltip" title="아티스트 추가" @if ($count != $artistCount - 1) style="visibility: hidden;" @endif>+</a>
                    </div>
                @endforeach
                @if (!count($request->artists))
                    <div class="mb-2 d-flex">
                        {!! Form::select('artist_id[]', $users, null, ['class' => 'form-control mr-2 selectize', 'placeholder' => '아티스트 선택']) !!}
                        {!! Form::text('artist_url[]', null, ['class' => 'form-control mr-2', 'placeholder' => '아티스트 URL']) !!}
                        <a href="#" class="add-artist btn btn-link" data-toggle="tooltip" title="아티스트 추가">+</a>
                    </div>
                @endif
            </div>
        </div>

        <div class="text-right">
            {!! Form::submit('저장', ['class' => 'btn btn-primary']) !!}
        </div>

        {!! Form::close() !!}
    @endif

    <div class="designer-row hide mb-2">
        {!! Form::select('designer_id[]', $users, null, ['class' => 'form-control mr-2 designer-select', 'placeholder' => '디자이너 선택']) !!}
        {!! Form::text('designer_url[]', null, ['class' => 'form-control mr-2', 'placeholder' => '디자이너 URL']) !!}
        <a href="#" class="add-designer btn btn-link" data-toggle="tooltip" title="디자이너 추가">+</a>
    </div>

    <div class="artist-row hide mb-2">
        {!! Form::select('artist_id[]', $users, null, ['class' => 'form-control mr-2 artist-select', 'placeholder' => '아티스트 선택']) !!}
        {!! Form::text('artist_url[]', null, ['class' => 'form-control mr-2', 'placeholder' => '아티스트 URL']) !!}
        <a href="#" class="add-artist btn btn-link mb-2" data-toggle="tooltip" title="아티스트 추가">+</a>
    </div>

@endsection

@section('scripts')
    @include('widgets._image_upload_js', ['useUploaded' => $request->status == 'Pending' && Auth::user()->hasPower('manage_characters')])
@endsection
