@if ($character)
    <div class="character-info" data-id="{{ $character->id }}"><img src="{{ $character->image->thumbnailUrl }}" class="mw-100" alt="Thumbnail for {{ $character->fullName }}" /></div>
    <div class="text-center"><a href="{{ $character->url }}">{{ $character->slug }}</a></div>
    @if (!$character->is_visible && Auth::check() && Auth::user()->isStaff)
        <div class="text-danger character-info" data-id="0"><i class="fas fa-eye-slash mr-1"></i> 캐릭터가 숨겨져 있습니다.</div>
    @endif
@else
    <div class="text-danger character-info" data-id="0">캐릭터를 찾을 수 없습니다.</div>
@endif
