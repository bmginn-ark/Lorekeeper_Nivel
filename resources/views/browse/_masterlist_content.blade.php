<div>
    {!! Form::open(['method' => 'GET']) !!}
    <div class="form-inline justify-content-end">
        <div class="form-group mr-3 mb-3">
            {!! Form::label('name', '캐릭터 이름/코드: ', ['class' => 'mr-2']) !!}
            {!! Form::text('name', Request::get('name'), ['class' => 'form-control']) !!}
        </div>
        <div class="form-group mb-3 mr-1">
            {!! Form::select('rarity_id', $rarities, Request::get('rarity_id'), ['class' => 'form-control mr-2']) !!}
        </div>
        <div class="form-group mb-3">
            {!! Form::select('species_id', $specieses, Request::get('species_id'), ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="text-right mb-3"><a href="#advancedSearch" class="btn btn-sm btn-outline-info" data-toggle="collapse">고급 검색 옵션 표시 <i class="fas fa-caret-down"></i></a></div>
    <div class="card bg-light mb-3 collapse" id="advancedSearch">
        <div class="card-body masterlist-advanced-search">
            @if (!$isMyo)
                <div class="masterlist-search-field">
                    {!! Form::label('character_category_id', '카테고리: ') !!}
                    {!! Form::select('character_category_id', $categories, Request::get('character_category_id'), ['class' => 'form-control mr-2', 'style' => 'width: 250px']) !!}
                </div>
                <div class="masterlist-search-field">
                    {!! Form::label('subtype_id', '종류 하위 카테고리: ') !!}
                    {!! Form::select('subtype_id', $subtypes, Request::get('subtype_id'), ['class' => 'form-control mr-2', 'style' => 'width: 250px']) !!}
                </div>
                <hr />
            @endif
            <div class="masterlist-search-field">
                {!! Form::label('owner', '오너 닉네임: ') !!}
                {!! Form::select('owner', $userOptions, Request::get('owner'), ['class' => 'form-control mr-2 userselectize', 'style' => 'width: 250px', 'placeholder' => __('Select a User')]) !!}
            </div>
            <div class="masterlist-search-field">
                {!! Form::label('artist', '아티스트: ') !!}
                {!! Form::select('artist', $userOptions, Request::get('artist'), ['class' => 'form-control mr-2 userselectize', 'style' => 'width: 250px', 'placeholder' => __('Select a User')]) !!}
            </div>
            <div class="masterlist-search-field">
                {!! Form::label('designer', '디자이너: ') !!}
                {!! Form::select('designer', $userOptions, Request::get('designer'), ['class' => 'form-control mr-2 userselectize', 'style' => 'width: 250px', 'placeholder' => __('Select a User')]) !!}
            </div>
            <hr />
            <div class="masterlist-search-field">
                {!! Form::label('owner_url', '오너 URL / 닉네임: ') !!} {!! add_help('Example: https://deviantart.com/username OR username') !!}
                {!! Form::text('owner_url', Request::get('owner_url'), ['class' => 'form-control mr-2', 'style' => 'width: 250px', 'placeholder' => __('Type a Username')]) !!}
            </div>
            <div class="masterlist-search-field">
                {!! Form::label('artist_url', '아티스트 URL / 닉네임: ') !!} {!! add_help('Example: https://deviantart.com/username OR username') !!}
                {!! Form::text('artist_url', Request::get('artist_url'), ['class' => 'form-control mr-2', 'style' => 'width: 250px', 'placeholder' => __('Type a Username')]) !!}
            </div>
            <div class="masterlist-search-field">
                {!! Form::label('designer_url', '디자이너 URL / 닉네임: ') !!} {!! add_help('Example: https://deviantart.com/username OR username') !!}
                {!! Form::text('designer_url', Request::get('designer_url'), ['class' => 'form-control mr-2', 'style' => 'width: 250px', 'placeholder' => __('Type a Username')]) !!}
            </div>
            <hr />
            <div class="masterlist-search-field">
                {!! Form::label('sale_value_min', '재판매 최소값 (₩): ') !!}
                {!! Form::text('sale_value_min', Request::get('sale_value_min'), ['class' => 'form-control mr-2', 'style' => 'width: 250px']) !!}
            </div>
            <div class="masterlist-search-field">
                {!! Form::label('sale_value_max', '재판매 최대값 (₩): ') !!}
                {!! Form::text('sale_value_max', Request::get('sale_value_max'), ['class' => 'form-control mr-2', 'style' => 'width: 250px']) !!}
            </div>
            @if (!$isMyo)
                <div class="masterlist-search-field">
                    {!! Form::label('is_gift_art_allowed', '그림 선물 상태: ') !!}
                    {!! Form::select('is_gift_art_allowed', [0 => '아무나', 2 => '먼저 묻기', 1 => '가능', 3 => '가능하거나 먼저 묻기'], Request::get('is_gift_art_allowed'), ['class' => 'form-control', 'style' => 'width: 250px']) !!}
                </div>
                <div class="masterlist-search-field">
                    {!! Form::label('is_gift_writing_allowed', '글 선물 상태: ') !!}
                    {!! Form::select('is_gift_writing_allowed', [0 => '아무나', 2 => '먼저 묻기', 1 => '가능', 3 => '가능하거나 먼저 묻기'], Request::get('is_gift_writing_allowed'), ['class' => 'form-control', 'style' => 'width: 250px']) !!}
                </div>
            @endif
            <br />
            {{-- Setting the width and height on the toggles as they don't seem to calculate correctly if the div is collapsed. --}}
            <div class="masterlist-search-field">
                {!! Form::checkbox('is_trading', 1, Request::get('is_trading'), ['class' => 'form-check-input', 'data-toggle' => 'toggle', 'data-on' => '거래 받는 중', 'data-off' => '아무 거래 상태', 'data-width' => '200', 'data-height' => '46']) !!}
            </div>
            <div class="masterlist-search-field">
                {!! Form::checkbox('is_sellable', 1, Request::get('is_sellable'), ['class' => 'form-check-input', 'data-toggle' => 'toggle', 'data-on' => '재판매 가능', 'data-off' => '아무 재판매 상태', 'data-width' => '204', 'data-height' => '46']) !!}
            </div>
            <div class="masterlist-search-field">
                {!! Form::checkbox('is_tradeable', 1, Request::get('is_tradeable'), ['class' => 'form-check-input', 'data-toggle' => 'toggle', 'data-on' => '재분양 가능', 'data-off' => '아무 재분양 상태', 'data-width' => '220', 'data-height' => '46']) !!}
            </div>
            <div class="masterlist-search-field">
                {!! Form::checkbox('is_giftable', 1, Request::get('is_giftable'), ['class' => 'form-check-input', 'data-toggle' => 'toggle', 'data-on' => '선물 가능', 'data-off' => '아무 선물 상태', 'data-width' => '202', 'data-height' => '46']) !!}
            </div>
            <hr />
            <a href="#" class="float-right btn btn-sm btn-outline-primary add-feature-button">특성 추가</a>
            {!! Form::label('소유 특성: ') !!} {!! add_help('This will narrow the search to characters that have ALL of the selected traits at the same time.') !!}
            <div id="featureBody" class="row w-100">
                @if (Request::get('feature_id'))
                    @foreach (Request::get('feature_id') as $featureId)
                        <div class="feature-block col-md-4 col-sm-6 mt-3 p-1">
                            <div class="card">
                                <div class="card-body d-flex">
                                    {!! Form::select('feature_id[]', $features, $featureId, ['class' => 'form-control feature-select selectize', 'placeholder' => __('Select Trait')]) !!}
                                    <a href="#" class="btn feature-remove ml-2"><i class="fas fa-times"></i></a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <hr />
            <div class="masterlist-search-field">
                {!! Form::checkbox('search_images', 1, Request::get('search_images'), ['class' => 'form-check-input mr-3', 'data-toggle' => 'toggle']) !!}
                <span class="ml-2">모든 캐릭터 이미지 포함 {!! add_help(
                    '각 캐릭터는 업데이트된 버전의 캐릭터마다 여러 이미지를 가질 수 있으며, 이는 해당 시점의 캐릭터 특성을 포착합니다. 기본적으로 검색은 최신 이미지만 검색하지만, 이 옵션은 오래된 이미지의 기준과 일치하는 캐릭터를 검색하여 오래된 결과를 얻을 수 있습니다.',
                ) !!}</span>
            </div>

        </div>

    </div>
    <div class="form-inline justify-content-end mb-3">
        <div class="form-group mr-3">
            {!! Form::label('sort', __('Sort').': ', ['class' => 'mr-2']) !!}
            @if (!$isMyo)
                {!! Form::select(
                    'sort',
                    [
                        'number_desc' => __('Number Descending'),
                        'number_asc' => __('Number Ascending'),
                        'id_desc' => __('Newest First'),
                        'id_asc' => __('Oldest First'),
                        'sale_value_desc' => __('Highest Sale Value'),
                        'sale_value_asc' => __('Lowest Sale Value'),
                    ],
                    Request::get('sort'),
                    ['class' => 'form-control'],
                ) !!}
            @else
                {!! Form::select('sort', [
                    'id_desc' => __('Newest First'),
                    'id_asc' => __('Oldest First'),
                    'sale_value_desc' => __('Highest Sale Value'),
                    'sale_value_asc' => __('Lowest Sale Value'),
                ], Request::get('sort'), ['class' => 'form-control']) !!}
            @endif
        </div>
        {!! Form::submit(__('Search'), ['class' => 'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}
</div>
<div class="hide" id="featureContent">
    <div class="feature-block col-md-4 col-sm-6 mt-3 p-1">
        <div class="card">
            <div class="card-body d-flex">
                {!! Form::select('feature_id[]', $features, null, ['class' => 'form-control feature-select selectize', 'placeholder' => __('Select Trait')]) !!}
                <a href="#" class="btn feature-remove ml-2"><i class="fas fa-times"></i></a>
            </div>
        </div>
    </div>
</div>
<div class="text-right mb-3">
    <div class="btn-group">
        <button type="button" class="btn btn-secondary active grid-view-button" data-toggle="tooltip" title="{{ __('Grid View') }}" alt="{{ __('Grid View') }}"><i class="fas fa-th"></i></button>
        <button type="button" class="btn btn-secondary list-view-button" data-toggle="tooltip" title="{{ __('List View') }}" alt="{{ __('List View') }}"><i class="fas fa-bars"></i></button>
    </div>
</div>

{!! $characters->render() !!}
<div id="gridView" class="hide">
    @foreach ($characters->chunk(4) as $chunk)
        <div class="row">
            @foreach ($chunk as $character)
                <div class="col-md-3 col-6 text-center">
                    <div>
                        <a href="{{ $character->url }}"><img src="{{ $character->image->thumbnailUrl }}" class="img-thumbnail" alt="Thumbnail for {{ $character->fullName }}" /></a>
                    </div>
                    <div class="mt-1">
                        <a href="{{ $character->url }}" class="h5 mb-0">
                            @if (!$character->is_visible)
                                <i class="fas fa-eye-slash"></i>
                            @endif {{ Illuminate\Support\Str::limit($character->fullName, 20, $end = '...') }}
                        </a>
                    </div>
                    <div class="small">
                        {!! $character->image->species_id ? $character->image->species->displayName : 'No Species' !!} ・ {!! $character->image->rarity_id ? $character->image->rarity->displayName : 'No Rarity' !!} ・ {!! $character->displayOwner !!}
                    </div>
                </div>
            @endforeach
        </div>
    @endforeach
</div>
<div id="listView" class="hide">
    <table class="table table-sm">
        <thead>
            <tr>
                <th>오너</th>
                <th>이름</th>
                <th>희귀도</th>
                <th>종</th>
                <th>생성일</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($characters as $character)
                <tr>
                    <td>{!! $character->displayOwner !!}</td>
                    <td>
                        @if (!$character->is_visible)
                            <i class="fas fa-eye-slash"></i>
                        @endif {!! $character->displayName !!}
                    </td>
                    <td>{!! $character->image->rarity_id ? $character->image->rarity->displayName : 'None' !!}</td>
                    <td>{!! $character->image->species_id ? $character->image->species->displayName : 'None' !!}</td>
                    <td>{!! format_date($character->created_at) !!}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
{!! $characters->render() !!}

<div class="text-center mt-4 small text-muted">{{ $characters->total() }} result{{ $characters->total() == 1 ? '' : 's' }} found.</div>
