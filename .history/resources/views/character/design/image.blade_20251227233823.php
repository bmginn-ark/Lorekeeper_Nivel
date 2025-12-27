@extends('character.design.layout')

@section('design-title')
    요청 (#{{ $request->id }}) :: 이미지
@endsection

@section('design-content')
    {!! breadcrumbs(['Design Approvals' => 'designs', 'Request (#' . $request->id . ')' => 'designs/' . $request->id, 'Masterlist Image' => 'designs/' . $request->id . '/image']) !!}

    @include('character.design._header', ['request' => $request])

    <h2>마스터리스트 이미지</h2>

    @if ($request->has_image)
        <div class="card mb-3">
            <div class="card-body bg-secondary text-white">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h3 class="text-center">메인 이미지</h3>
                        <div class="text-center">
                            <a href="{{ $request->imageUrl }}?v={{ $request->updated_at->timestamp }}" data-lightbox="entry" data-title="Request #{{ $request->id }}"><img src="{{ $request->imageUrl }}?v={{ $request->updated_at->timestamp }}" class="mw-100"
                                    alt="Request {{ $request->id }}" /></a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h3 class="text-center">썸네일 이미지</h3>
                        <div class="text-center">
                            <a href="{{ $request->thumbnailUrl }}?v={{ $request->updated_at->timestamp }}" data-lightbox="entry" data-title="Request #{{ $request->id }} thumbnail"><img
                                    src="{{ $request->thumbnailUrl }}?v={{ $request->updated_at->timestamp }}" class="mw-100" alt="Thumbnail for request {{ $request->id }}" /></a>
                        </div>
                    </div>
                </div>
            </div>

            @if (!($request->status == 'Draft' && $request->user_id == Auth::user()->id))
                <div class="card-body">
                    <h4 class="mb-3">출처</h4>
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
                            <h5>그림</h5>
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
            <p>마스터리스트에 사용할 이미지와 선택적으로 썸네일을 선택하세요. 허락받은 이미지만 업로드하고, 아티스트에게 출처를 기록할 수 있어야 합니다! 스태프는 업로드한 이미지를 수정할 수 없지만, 재자르거나 다른 썸네일을 업로드할 수 있습니다.</p>
        @else
            <p>스태프로서, 업로드된 이미지의 썸네일이나 출처를 수정할 수 있지만, 이미지는 수정할 수 없습니다. 썸네일을 재자르면 새로고침이 필요할 수 있습니다.</p>
        @endif
        {!! Form::open(['url' => 'designs/' . $request->id . '/image', 'files' => true]) !!}
        @if ($request->status == 'Draft' && $request->user_id == Auth::user()->id)
            <div class="form-group">
                {!! Form::label('Image') !!} {!! add_help('This is the image that will be used on the masterlist. Note that the image is not protected in any way, so take precautions to avoid art/design theft.') !!}
                <div class="custom-file">
                    {!! Form::label('image', '파일 선택...', ['class' => 'custom-file-label']) !!}
                    {!! Form::file('image', ['class' => 'custom-file-input', 'id' => 'mainImage']) !!}
                </div>
            </div>
        @else
            <div class="form-group">
                {!! Form::checkbox('modify_thumbnail', 1, 0, ['class' => 'form-check-input', 'data-toggle' => 'toggle']) !!}
                {!! Form::label('modify_thumbnail', '썸네일 변형', ['class' => 'form-check-label ml-3']) !!} {!! add_help('Toggle this option to modify the thumbnail, otherwise only the credits will be saved.') !!}
            </div>
        @endif
        @if (config('lorekeeper.settings.masterlist_image_automation') === 1)
            @if (config('lorekeeper.settings.masterlist_image_automation_hide_manual_thumbnail') === 0 || Auth::user()->hasPower('manage_characters'))
                <div class="form-group">
                    {!! Form::checkbox('use_cropper', 1, 1, ['class' => 'form-check-input', 'data-toggle' => 'toggle', 'id' => 'useCropper']) !!}
                    {!! Form::label('use_cropper', '자동 썸네일 사용', ['class' => 'form-check-label ml-3']) !!} {!! add_help('A thumbnail is required for the upload (used for the masterlist). You can use the Thumbnail Automation, or upload a custom thumbnail.') !!}
                </div>
            @else
                {!! Form::hidden('use_cropper', 1) !!}
            @endif
            <div class="card mb-3" id="thumbnailCrop">
                <div class="card-body">
                    <div id="cropSelect">이 기능을 사용하면 전체 이미지에서 썸네일이 자동으로 생성됩니다.</div>
                    {!! Form::hidden('x0', 1) !!}
                    {!! Form::hidden('x1', 1) !!}
                    {!! Form::hidden('y0', 1) !!}
                    {!! Form::hidden('y1', 1) !!}
                </div>
            </div>
        @else
            <div class="form-group">
                {!! Form::checkbox('use_cropper', 1, 1, ['class' => 'form-check-input', 'data-toggle' => 'toggle', 'id' => 'useCropper']) !!}
                {!! Form::label('use_cropper', '이미지 크로퍼 사용', ['class' => 'form-check-label ml-3']) !!} {!! add_help('A thumbnail is required for the upload (used for the masterlist). You can use the image cropper (crop dimensions can be adjusted in the site code), or upload a custom thumbnail.') !!}
            </div>
            <div class="card mb-3" id="thumbnailCrop">
                <div class="card-body">
                    <div id="cropSelect">썸네일 자르기를 사용할 이미지 선택.</div>
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
                    {!! Form::label('썸네일 이미지') !!} {!! add_help('This image is shown on the masterlist page.') !!}
                    <div class="custom-file">
                        {!! Form::label('thumbnail', '썸네일 선택...', ['class' => 'custom-file-label']) !!}
                        {!! Form::file('thumbnail', ['class' => 'custom-file-input']) !!}
                    </div>
                    <div class="text-muted">추천 크기: {{ config('lorekeeper.settings.masterlist_thumbnails.width') }}px x {{ config('lorekeeper.settings.masterlist_thumbnails.height') }}px</div>
                </div>
            </div>
        @endif
        <p>
            이 섹션은 이미지 제작자에게 출처를 기록하기 위한 것입니다. 첫 번째 박스는 디자이너나 아티스트의 사이트 내 사용자 이름입니다 (존재하는 경우). 두 번째 박스는 사이트에 계정이 없는 디자이너나 아티스트의 링크입니다.
        </p>
        <div class="form-group">
            {!! Form::label('디자이너') !!}
            <div id="designerList">
                <?php $designerCount = count($request->designers); ?>
                @foreach ($request->designers as $count => $designer)
                    <div class="mb-2 d-flex">
                        {!! Form::select('designer_id[' . $designer->id . ']', $users, $designer->user_id, ['class' => 'form-control mr-2 selectize', 'placeholder' => '디자이너 선택']) !!}
                        {!! Form::text('designer_url[' . $designer->id . ']', $designer->url, ['class' => 'form-control mr-2', 'placeholder' => 'Designer URL']) !!}

                        <a href="#" class="add-designer btn btn-link" data-toggle="tooltip" title="Add another designer" @if ($count != $designerCount - 1) style="visibility: hidden;" @endif>+</a>
                    </div>
                @endforeach
                @if (!count($request->designers))
                    <div class="mb-2 d-flex">
                        {!! Form::select('designer_id[]', $users, null, ['class' => 'form-control mr-2 selectize', 'placeholder' => '디자이너 선택']) !!}
                        {!! Form::text('designer_url[]', null, ['class' => 'form-control mr-2', 'placeholder' => 'Designer URL']) !!}
                        <a href="#" class="add-designer btn btn-link" data-toggle="tooltip" title="Add another designer">+</a>
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
                        {!! Form::text('artist_url[' . $artist->id . ']', $artist->url, ['class' => 'form-control mr-2', 'placeholder' => 'Artist URL']) !!}
                        <a href="#" class="add-artist btn btn-link" data-toggle="tooltip" title="Add another artist" @if ($count != $artistCount - 1) style="visibility: hidden;" @endif>+</a>
                    </div>
                @endforeach
                @if (!count($request->artists))
                    <div class="mb-2 d-flex">
                        {!! Form::select('artist_id[]', $users, null, ['class' => 'form-control mr-2 selectize', 'placeholder' => '아티스트 선택']) !!}
                        {!! Form::text('artist_url[]', null, ['class' => 'form-control mr-2', 'placeholder' => 'Artist URL']) !!}
                        <a href="#" class="add-artist btn btn-link" data-toggle="tooltip" title="Add another artist">+</a>
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
        {!! Form::select('designer_id[]', $users, null, ['class' => 'form-control mr-2 designer-select', 'placeholder' => 'Select a Designer']) !!}
        {!! Form::text('designer_url[]', null, ['class' => 'form-control mr-2', 'placeholder' => 'Designer URL']) !!}
        <a href="#" class="add-designer btn btn-link" data-toggle="tooltip" title="Add another designer">+</a>
    </div>
    <div class="artist-row hide mb-2">
        {!! Form::select('artist_id[]', $users, null, ['class' => 'form-control mr-2 artist-select', 'placeholder' => 'Select an Artist']) !!}
        {!! Form::text('artist_url[]', null, ['class' => 'form-control mr-2', 'placeholder' => 'Artist URL']) !!}
        <a href="#" class="add-artist btn btn-link mb-2" data-toggle="tooltip" title="Add another artist">+</a>
    </div>

@endsection

@section('scripts')
    @include('widgets._image_upload_js', ['useUploaded' => $request->status == 'Pending' && Auth::user()->hasPower('manage_characters')])
@endsection
