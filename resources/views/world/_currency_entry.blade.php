<div class="row world-entry">
    @if ($currency->has_image)
        <div class="col-md-3 world-entry-image"><a href="{{ $currency->currencyImageUrl }}" data-lightbox="entry" data-title="{{ $currency->name }}"><img src="{{ $currency->currencyImageUrl }}" class="world-entry-image" alt="{{ $currency->name }}" /></a>
        </div>
    @endif
    <div class="{{ $currency->has_image ? 'col-md-9' : 'col-12' }}">
        <x-admin-edit title="Currency" :object="$currency" />
        <h3>{{ $currency->name }} @if ($currency->abbreviation)
                ({{ $currency->abbreviation }})
            @endif
        </h3>
        <div><strong>표시:</strong> {!! $currency->display(0) !!}</div>
        <div><strong>소유 가능:</strong> <?php echo ucfirst(implode(' 와 ', ($currency->is_user_owned ? ['유저'] : []) + ($currency->is_character_owned ? ['캐릭터'] : []))); ?></div>
        <div class="world-entry-text parsed-text">
            {!! $currency->parsed_description !!}
        </div>
    </div>
</div>
