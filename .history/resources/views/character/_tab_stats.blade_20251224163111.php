<div class="row no-gutters">
    <div class="col-lg-3 col-5">
        <h5>오너</h5>
    </div>
    <div class="col-lg-9 col-7">{!! $character->displayOwner !!}</div>
</div>
@if (!$character->is_myo_slot)
    <div class="row no-gutters">
        <div class="col-lg-3 col-5">
            <h5>카테고리</h5>
        </div>
        <div class="col-lg-9 col-7">{!! $character->category->displayName !!}</div>
    </div>
@endif
<div class="row no-gutters">
    <div class="col-lg-3 col-5">
        <h5 class="mb-0">생성일</h5>
    </div>
    <div class="col-lg-9 col-7">{!! format_date($character->created_at) !!}</div>
</div>

<hr />


<h5>
    <i class="text-{{ $character->is_giftable ? 'success far fa-circle' : 'danger fas fa-times' }} fa-fw mr-2"></i> 선물 {{ $character->is_giftable ? '가능' : '불가능' }}
</h5>
<h5>
    <i class="text-{{ $character->is_tradeable ? 'success far fa-circle' : 'danger fas fa-times' }} fa-fw mr-2"></i> 재분양 {{ $character->is_tradeable ? '가능' : '불가능' }}
</h5>
<h5>
    <i class="text-{{ $character->is_sellable ? 'success far fa-circle' : 'danger fas fa-times' }} fa-fw mr-2"></i> 재판매 {{ $character->is_sellable ? '가능' : '불가능' }}
</h5>
@if ($character->sale_value > 0)
    <div class="row no-gutters">
        <div class="col-lg-3 col-5">
            <h5>판매 가치</h5>
        </div>
        <div class="col-lg-9 col-7 pl-1">
            {{ Config::get('lorekeeper.settings.currency_symbol') }}{{ $character->sale_value }}
        </div>
    </div>
@endif
@if ($character->transferrable_at && $character->transferrable_at->isFuture())
    <div class="row no-gutters">
        <div class="col-lg-3 col-5">
            <h5>쿨다운</h5>
        </div>
        <div class="col-lg-9 col-7 pl-1">{!! format_date($character->transferrable_at) !!}전 까지 거래할 수 없습니다.</div>
    </div>
@endif
@if (Auth::check() && Auth::user()->hasPower('manage_characters'))
    <div class="mt-3">
        <a href="#" class="btn btn-outline-info btn-sm edit-stats" data-{{ $character->is_myo_slot ? 'id' : 'slug' }}="{{ $character->is_myo_slot ? $character->id : $character->slug }}"><i class="fas fa-cog"></i> 수정</a>
    </div>
@endif
