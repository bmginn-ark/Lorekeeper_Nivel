@extends('character.design.layout')

@section('design-title')
    요청 (#{{ $request->id }}) :: 특성
@endsection

@section('design-content')
    {!! breadcrumbs(['디자인 승인' => 'designs', '요청 (#' . $request->id . ')' => 'designs/' . $request->id, '특성' => 'designs/' . $request->id . '/traits']) !!}

    @include('character.design._header', ['request' => $request])

    <h2>
        특성
    </h2>

    @if ($request->status == 'Draft' && $request->user_id == Auth::user()->id)
        <p>
            {{ $request->character->is_myo_slot ? '생성된' : '업데이트된' }} 캐릭터의 특성을 선택하세요.
            @if ($request->character->is_myo_slot)
                일부 특성은 제한되어 있을 수 있으며, 변경할 수 없습니다.
            @endif
            스태프는 승인 과정 중 이 특성들을 대신 수정해줄 수 없으므로,
            확실하지 않은 부분이 있다면 사전에 스태프와 소통하여 디자인이 승인 가능한지 확인해 주세요.
        </p>

        {!! Form::open(['url' => 'designs/' . $request->id . '/traits']) !!}

        <div class="form-group">
            {!! Form::label('species_id', '종족') !!}
            @if ($request->character->is_myo_slot && $request->character->image->species_id)
                <div class="alert alert-secondary">{!! $request->character->image->species->displayName !!}</div>
            @else
                {!! Form::select('species_id', $specieses, $request->species_id, ['class' => 'form-control', 'id' => 'species']) !!}
            @endif
        </div>

        <div class="form-group">
            {!! Form::label('subtype_id', '종족 하위 분류') !!}
            @if ($request->character->is_myo_slot && $request->character->image->subtype_id)
                <div class="alert alert-secondary">{!! $request->character->image->subtype->displayName !!}</div>
            @else
                <div id="subtypes">
                    {!! Form::select('subtype_id', $subtypes, $request->subtype_id, ['class' => 'form-control', 'id' => 'subtype']) !!}
                </div>
            @endif
        </div>

        <div class="form-group">
            {!! Form::label('rarity_id', '캐릭터 희귀도') !!}
            @if ($request->character->is_myo_slot && $request->character->image->rarity_id)
                <div class="alert alert-secondary">{!! $request->character->image->rarity->displayName !!}</div>
            @else
                {!! Form::select('rarity_id', $rarities, $request->rarity_id, ['class' => 'form-control', 'id' => 'rarity']) !!}
            @endif
        </div>

        <div class="form-group">
            {!! Form::label('특성') !!}
            <div>
                <a href="#" class="btn btn-primary mb-2" id="add-feature">특성 추가</a>
            </div>
            <div id="featureList">
                {{-- MYO 슬롯의 필수 특성 --}}
                @if ($request->character->is_myo_slot && $request->character->image->features)
                    @foreach ($request->character->image->features as $feature)
                        <div class="mb-2 d-flex align-items-center">
                            {!! Form::text('', $feature->name, ['class' => 'form-control mr-2', 'disabled']) !!}
                            {!! Form::text('', $feature->data, ['class' => 'form-control mr-2', 'disabled']) !!}
                            <div>{!! add_help('이 특성은 필수입니다.') !!}</div>
                        </div>
                    @endforeach
                @endif

                {{-- 현재 설정된 특성 --}}
                @if ($request->features)
                    @foreach ($request->features as $feature)
                        <div class="mb-2 d-flex">
                            {!! Form::select('feature_id[]', $features, $feature->feature_id, ['class' => 'form-control mr-2 initial feature-select', 'placeholder' => '특성 선택']) !!}
                            {!! Form::text('feature_data[]', $feature->data, ['class' => 'form-control mr-2', 'placeholder' => '추가 정보 (선택)']) !!}
                            <a href="#" class="remove-feature btn btn-danger mb-2">×</a>
                        </div>
                    @endforeach
                @endif
            </div>

            <div class="feature-row hide mb-2">
                {!! Form::select('feature_id[]', $features, null, ['class' => 'form-control mr-2 feature-select', 'placeholder' => '특성 선택']) !!}
                {!! Form::text('feature_data[]', null, ['class' => 'form-control mr-2', 'placeholder' => '추가 정보 (선택)']) !!}
                <a href="#" class="remove-feature btn btn-danger mb-2">×</a>
            </div>
        </div>

        <div class="text-right">
            {!! Form::submit('저장', ['class' => 'btn btn-primary']) !!}
        </div>

        {!! Form::close() !!}
    @else
        <div class="mb-1">
            <div class="row">
                <div class="col-md-2 col-4">
                    <h5>종족</h5>
                </div>
                <div class="col-md-10 col-8">
                    {!! $request->species ? $request->species->displayName : '선택되지 않음' !!}
                </div>
            </div>

            @if ($request->subtype_id)
                <div class="row">
                    <div class="col-md-2 col-4">
                        <h5>하위 분류</h5>
                    </div>
                    <div class="col-md-10 col-8">
                        @if ($request->character->is_myo_slot && $request->character->image->subtype_id)
                            {!! $request->character->image->subtype->displayName !!}
                        @else
                            {!! $request->subtype_id ? $request->subtype->displayName : '선택되지 않음' !!}
                        @endif
                    </div>
                </div>
            @endif

            <div class="row">
                <div class="col-md-2 col-4">
                    <h5>희귀도</h5>
                </div>
                <div class="col-md-10 col-8">
                    {!! $request->rarity ? $request->rarity->displayName : '선택되지 않음' !!}
                </div>
            </div>
        </div>

        <h5>특성</h5>
        <div>
            @if ($request->character && $request->character->is_myo_slot && $request->character->image->features)
                @foreach ($request->character->image->features as $feature)
                    <div>
                        @if ($feature->feature->feature_category_id)
                            <strong>{!! $feature->feature->category->displayName !!}:</strong>
                        @endif
                        {!! $feature->feature->displayName !!}
                        @if ($feature->data)
                            ({{ $feature->data }})
                        @endif
                        <span class="text-danger">*필수</span>
                    </div>
                @endforeach
            @endif

            @foreach ($request->features as $feature)
                <div>
                    @if ($feature->feature->feature_category_id)
                        <strong>{!! $feature->feature->category->displayName !!}:</strong>
                    @endif
                    {!! $feature->feature->displayName !!}
                    @if ($feature->data)
                        ({{ $feature->data }})
                    @endif
                </div>
            @endforeach
        </div>
    @endif

@endsection

@section('scripts')
    @include('widgets._image_upload_js')

    <script>
        $("#species").change(function() {
            var species = $('#species').val();
            var id = '<?php echo $request->id; ?>';
            $.ajax({
                type: "GET",
                url: "{{ url('designs/traits/subtype') }}?species=" + species + "&id=" + id,
                dataType: "text"
            }).done(function(res) {
                $("#subtypes").html(res);
            }).fail(function(jqXHR, textStatus, errorThrown) {
                alert("AJAX 호출 실패: " + textStatus + ", " + errorThrown);
            });
        });
    </script>
@endsection
