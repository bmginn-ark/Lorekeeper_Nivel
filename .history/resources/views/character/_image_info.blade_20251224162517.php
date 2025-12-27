{{-- Image Data --}}
<div class="col-md-5 d-flex">
    <div class="card character-bio w-100">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link active" id="infoTab-{{ $image->id }}" data-toggle="tab" href="#info-{{ $image->id }}" role="tab">정보</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="notesTab-{{ $image->id }}" data-toggle="tab" href="#notes-{{ $image->id }}" role="tab">주석</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="creditsTab-{{ $image->id }}" data-toggle="tab" href="#credits-{{ $image->id }}" role="tab">출처</a>
                </li>
                @if (isset($showMention) && $showMention)
                    <li class="nav-item">
                        <a class="nav-link" id="mentionTab-{{ $image->id }}" data-toggle="tab" href="#mention-{{ $image->id }}" role="tab">언급</a>
                    </li>
                @endif
                @if (Auth::check() && Auth::user()->hasPower('manage_characters'))
                    <li class="nav-item">
                        <a class="nav-link" id="settingsTab-{{ $image->id }}" data-toggle="tab" href="#settings-{{ $image->id }}" role="tab"><i class="fas fa-cog"></i></a>
                    </li>
                @endif
            </ul>
        </div>
        <div class="card-body tab-content">
            <div class="text-right mb-1">
                <div class="badge badge-primary">Image #{{ $image->id }}</div>
            </div>
            @if (!$image->character->is_myo_slot && !$image->is_valid)
                <div class="alert alert-danger">
                    이 캐릭터의 이 버전은 구식이며, 기록 보관 목적으로만 여기에 기록되어 있습니다. 공식적인 참고 자료로 사용하지 마세요.
                </div>
            @endif

            {{-- Basic info --}}
            <div class="tab-pane fade show active" id="info-{{ $image->id }}">
                <div class="row no-gutters">
                    <div class="col-lg-4 col-5">
                        <h5>종</h5>
                    </div>
                    <div class="col-lg-8 col-7 pl-1">{!! $image->species_id ? $image->species->displayName : 'None' !!}</div>
                </div>
                @if ($image->subtype_id)
                    <div class="row no-gutters">
                        <div class="col-lg-4 col-5">
                            <h5>분류</h5>
                        </div>
                        <div class="col-lg-8 col-7 pl-1">{!! $image->subtype_id ? $image->subtype->displayName : 'None' !!}</div>
                    </div>
                @endif
                <div class="row no-gutters">
                    <div class="col-lg-4 col-5">
                        <h5>희귀도</h5>
                    </div>
                    <div class="col-lg-8 col-7 pl-1">{!! $image->rarity_id ? $image->rarity->displayName : 'None' !!}</div>
                </div>

                <div class="mb-3">
                    <div>
                        <h5>특성</h5>
                    </div>
                    @if (config('lorekeeper.extensions.traits_by_category'))
                        <div>
                            @php
                                $traitgroup = $image
                                    ->features()
                                    ->get()
                                    ->groupBy('feature_category_id');
                            @endphp
                            @if ($image->features()->count())
                                @foreach ($traitgroup as $key => $group)
                                    <div class="mb-2">
                                        @if ($key)
                                            <strong>{!! $group->first()->feature->category->displayName !!}:</strong>
                                        @else
                                            <strong>기타:</strong>
                                        @endif
                                        @foreach ($group as $feature)
                                            <div class="ml-md-2">{!! $feature->feature->displayName !!} @if ($feature->data)
                                                    ({{ $feature->data }})
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            @else
                                <div>특성 없음.</div>
                            @endif
                        </div>
                    @else
                        <div>
                            <?php $features = $image
                                ->features()
                                ->with('feature.category')
                                ->get(); ?>
                            @if ($features->count())
                                @foreach ($features as $feature)
                                    <div>
                                        @if ($feature->feature->feature_category_id)
                                            <strong>{!! $feature->feature->category->displayName !!}:</strong>
                                            @endif {!! $feature->feature->displayName !!} @if ($feature->data)
                                                ({{ $feature->data }})
                                            @endif
                                    </div>
                                @endforeach
                            @else
                                <div>특성 없음.</div>
                            @endif
                        </div>
                    @endif
                </div>
                <div>
                    <strong>업로드:</strong> {!! pretty_date($image->created_at) !!}
                </div>
                <div>
                    <strong>마지막 수정:</strong> {!! pretty_date($image->updated_at) !!}
                </div>

                @if (Auth::check() && Auth::user()->hasPower('manage_characters'))
                    <div class="mt-3">
                        <a href="#" class="btn btn-outline-info btn-sm edit-features" data-id="{{ $image->id }}"><i class="fas fa-cog"></i> 수정</a>
                    </div>
                @endif
            </div>

            {{-- Image notes --}}
            <div class="tab-pane fade" id="notes-{{ $image->id }}">
                @if ($image->parsed_description)
                    <div class="parsed-text imagenoteseditingparse">{!! $image->parsed_description !!}</div>
                @else
                    <div class="imagenoteseditingparse">추가적인 주석이 없습니다.</div>
                @endif
                @if (Auth::check() && Auth::user()->hasPower('manage_characters'))
                    <div class="mt-3">
                        <a href="#" class="btn btn-outline-info btn-sm edit-notes" data-id="{{ $image->id }}"><i class="fas fa-cog"></i> 수정</a>
                    </div>
                @endif
            </div>

            {{-- Image credits --}}
            <div class="tab-pane fade" id="credits-{{ $image->id }}">

                <div class="row no-gutters mb-2">
                    <div class="col-lg-4 col-4">
                        <h5>디자인</h5>
                    </div>
                    <div class="col-lg-8 col-8">
                        @foreach ($image->designers as $designer)
                            <div>{!! $designer->displayLink() !!}</div>
                        @endforeach
                    </div>
                </div>
                <div class="row no-gutters">
                    <div class="col-lg-4 col-4">
                        <h5>그림</h5>
                    </div>
                    <div class="col-lg-8 col-8">
                        @foreach ($image->artists as $artist)
                            <div>{!! $artist->displayLink() !!}</div>
                        @endforeach
                    </div>
                </div>

                @if (Auth::check() && Auth::user()->hasPower('manage_characters'))
                    <div class="mt-3">
                        <a href="#" class="btn btn-outline-info btn-sm edit-credits" data-id="{{ $image->id }}"><i class="fas fa-cog"></i> 수정</a>
                    </div>
                @endif
            </div>

            @if (isset($showMention) && $showMention)
                {{-- Mention This tab --}}
                <div class="tab-pane fade" id="mention-{{ $image->id }}">
                    Rich text editor에서:
                    <div class="alert alert-secondary">
                        [character={{ $character->slug }}]
                    </div>
                    @if (!config('lorekeeper.settings.wysiwyg_comments'))
                        덧글에서:
                        <div class="alert alert-secondary">
                            [{{ $character->fullName }}]({{ $character->url }})
                        </div>
                    @endif
                    <hr>
                    <div class="my-2">
                        <strong>썸네일:</strong>
                    </div>
                    Rich text editor에서:
                    <div class="alert alert-secondary">
                        [charthumb={{ $character->slug }}]
                    </div>
                    @if (!config('lorekeeper.settings.wysiwyg_comments'))
                        덧글에서:
                        <div class="alert alert-secondary">
                            [![Thumbnail of {{ $character->fullName }}]({{ $character->image->thumbnailUrl }})]({{ $character->url }})
                        </div>
                    @endif
                </div>
            @endif

            @if (Auth::check() && Auth::user()->hasPower('manage_characters'))
                <div class="tab-pane fade" id="settings-{{ $image->id }}">
                    {!! Form::open(['url' => 'admin/character/image/' . $image->id . '/settings']) !!}
                    <div class="form-group">
                        {!! Form::checkbox('is_visible', 1, $image->is_visible, ['class' => 'form-check-input', 'data-toggle' => 'toggle']) !!}
                        {!! Form::label('is_visible', '공개', ['class' => 'form-check-label ml-3']) !!} {!! add_help('이 기능을 끄면 마스터리스트 관리 권한이 없는 사람은 이미지를 볼 수 없습니다.') !!}
                    </div>
                    <div class="form-group">
                        {!! Form::checkbox('is_valid', 1, $image->is_valid, ['class' => 'form-check-input', 'data-toggle' => 'toggle']) !!}
                        {!! Form::label('is_valid', '유효', ['class' => 'form-check-label ml-3']) !!} {!! add_help('이 기능을 끄면 이미지는 여전히 표시되지만, 이미지가 유효한 참조가 아님을 나타내는 메시지와 함께 표시됩니다.') !!}
                    </div>
                    <div class="text-right">
                        {!! Form::submit('Edit', ['class' => 'btn btn-primary']) !!}
                    </div>
                    {!! Form::close() !!}
                    <hr />
                    <div class="text-right">
                        @if ($character->character_image_id != $image->id)
                            <a href="#" class="btn btn-outline-info btn-sm active-image" data-id="{{ $image->id }}">활성화</a>
                        @endif <a href="#" class="btn btn-outline-info btn-sm reupload-image" data-id="{{ $image->id }}">이미지 재업로드</a> <a href="#" class="btn btn-outline-danger btn-sm delete-image"
                            data-id="{{ $image->id }}">삭제</a>
                    </div>
                </div>
            @endif
        </div>
    </div>

</div>
