@if ($characters->count())
    <div class="row">
        @foreach ($characters as $character)
            <div class="col-md-3 col-6 text-center mb-2">
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
                    {!! $character->image->species_id ? $character->image->species->displayName : '종 없음' !!} ・ {!! $character->image->rarity_id ? $character->image->rarity->displayName : '희귀도 없음' !!}
                </div>
            </div>
        @endforeach
    </div>
@else
    <p>{{ $myo ? 'MYO 슬롯이' : '캐릭터가' }} 없습니다.</p>
@endif
