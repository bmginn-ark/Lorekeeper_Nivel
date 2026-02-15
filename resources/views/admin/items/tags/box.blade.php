<h3>{{ __('Rewards') }}</h3>

<p>{{ __('These are the rewards that will be distributed to the user when they use the box from their inventory. The box will only distribute rewards to the user themselves - character-only currencies should not be added.') }}</p>

@include('widgets._loot_select', ['loots' => $tag->getData(), 'showLootTables' => true, 'showRaffles' => true])
