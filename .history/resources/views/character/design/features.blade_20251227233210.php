@extends('character.design.layout')

@section('design-title')
    요청 (#{{ $request->id }}) :: 특성
@endsection

@section('design-content')
    {!! breadcrumbs(['Design Approvals' => 'designs', 'Request (#' . $request->id . ')' => 'designs/' . $request->id, 'Traits' => 'designs/' . $request->id . '/traits']) !!}

    @include('character.design._header', ['request' => $request])

    <h2>
        특성</h2>

    @if ($request->status == 'Draft' && $request->user_id == Auth::user()->id)
        <p>캐릭터 {{ $request->character->is_myo_slot ? '생성' : '수정' }}에 필요한 특성을 선택하세요. @if ($request->character->is_myo_slot)
                어떤 특성들은 당신에게 제한되었을 수도 있습니다 - 그것들을 바꿀 수는 없습니다.
            @endif 승인 중에는 스태프가 특성을 수정할 수 없으므로, 의심스러운 경우 사전에 소통하여 귀하의 디자인이 수용 가능한지 확인하시기 바랍니다.</p>
        {!! Form::open(['url' => 'designs/' . $request->id . '/traits']) !!}
        <div class="form-group">
            {!! Form::label('species_id', 'Species') !!}
            @if ($request->character->is_myo_slot && $request->character->image->species_id)
                <div class="alert alert-secondary">{!! $request->character->image->species->displayName !!}</div>
            @else
                {!! Form::select('species_id', $specieses, $request->species_id, ['class' => 'form-control', 'id' => 'species']) !!}
            @endif

        </div>

        <div class="form-group">
            {!! Form::label('subtype_id', 'Species Subtype') !!}
            @if ($request->character->is_myo_slot && $request->character->image->subtype_id)
                <div class="alert alert-secondary">{!! $request->character->image->subtype->displayName !!}</div>
            @else
                <div id="subtypes">
                    {!! Form::select('subtype_id', $subtypes, $request->subtype_id, ['class' => 'form-control', 'id' => 'subtype']) !!}
                </div>
            @endif

        </div>

        <div class="form-group">
            {!! Form::label('rarity_id', 'Character Rarity') !!}
            @if ($request->character->is_myo_slot && $request->character->image->rarity_id)
                <div class="alert alert-secondary">{!! $request->character->image->rarity->displayName !!}</div>
            @else
                {!! Form::select('rarity_id', $rarities, $request->rarity_id, ['class' => 'form-control', 'id' => 'rarity']) !!}
            @endif
        </div>

        <div class="form-group">
            {!! Form::label('Traits') !!}
            <div><a href="#" class="btn btn-primary mb-2" id="add-feature">Add Trait</a></div>
            <div id="featureList">
                {{-- Add in the compulsory traits for MYO slots --}}
                @if ($request->character->is_myo_slot && $request->character->image->features)
                    @foreach ($request->character->image->features as $feature)
                        <div class="mb-2 d-flex align-items-center">
                            {!! Form::text('', $feature->name, ['class' => 'form-control mr-2', 'disabled']) !!}
                            {!! Form::text('', $feature->data, ['class' => 'form-control mr-2', 'disabled']) !!}
                            <div>{!! add_help('This trait is required.') !!}</div>
                        </div>
                    @endforeach
                @endif

                {{-- Add in the ones that currently exist --}}
                @if ($request->features)
                    @foreach ($request->features as $feature)
                        <div class="mb-2 d-flex">
                            {!! Form::select('feature_id[]', $features, $feature->feature_id, ['class' => 'form-control mr-2 initial feature-select', 'placeholder' => 'Select Trait']) !!}
                            {!! Form::text('feature_data[]', $feature->data, ['class' => 'form-control mr-2', 'placeholder' => 'Extra Info (Optional)']) !!}
                            <a href="#" class="remove-feature btn btn-danger mb-2">×</a>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="feature-row hide mb-2">
                {!! Form::select('feature_id[]', $features, null, ['class' => 'form-control mr-2 feature-select', 'placeholder' => 'Select Trait']) !!}
                {!! Form::text('feature_data[]', null, ['class' => 'form-control mr-2', 'placeholder' => 'Extra Info (Optional)']) !!}
                <a href="#" class="remove-feature btn btn-danger mb-2">×</a>
            </div>
        </div>
        <div class="text-right">
            {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
    @else
        <div class="mb-1">
            <div class="row">
                <div class="col-md-2 col-4">
                    <h5>Species</h5>
                </div>
                <div class="col-md-10 col-8">{!! $request->species ? $request->species->displayName : 'None Selected' !!}</div>
            </div>
            @if ($request->subtype_id)
                <div class="row">
                    <div class="col-md-2 col-4">
                        <h5>Subtype</h5>
                    </div>
                    <div class="col-md-10 col-8">
                        @if ($request->character->is_myo_slot && $request->character->image->subtype_id)
                            {!! $request->character->image->subtype->displayName !!}
                        @else
                            {!! $request->subtype_id ? $request->subtype->displayName : 'None Selected' !!}
                        @endif
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-md-2 col-4">
                    <h5>Rarity</h5>
                </div>
                <div class="col-md-10 col-8">{!! $request->rarity ? $request->rarity->displayName : 'None Selected' !!}</div>
            </div>
        </div>
        <h5>Traits</h5>
        <div>
            @if ($request->character && $request->character->is_myo_slot && $request->character->image->features)
                @foreach ($request->character->image->features as $feature)
                    <div>
                        @if ($feature->feature->feature_category_id)
                            <strong>{!! $feature->feature->category->displayName !!}:</strong>
                            @endif {!! $feature->feature->displayName !!} @if ($feature->data)
                                ({{ $feature->data }})
                            @endif <span class="text-danger">*Required</span>
                    </div>
                @endforeach
            @endif
            @foreach ($request->features as $feature)
                <div>
                    @if ($feature->feature->feature_category_id)
                        <strong>{!! $feature->feature->category->displayName !!}:</strong>
                        @endif {!! $feature->feature->displayName !!} @if ($feature->data)
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
                alert("AJAX call failed: " + textStatus + ", " + errorThrown);
            });

        });
    </script>
@endsection
