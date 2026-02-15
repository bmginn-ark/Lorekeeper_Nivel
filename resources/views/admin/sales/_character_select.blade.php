@php
    $characters = \App\Models\Character\Character::visible(Auth::check() ? Auth::user() : null)
        ->myo(0)
        ->orderBy('slug', 'DESC')
        ->get()
        ->pluck('fullName', 'slug')
        ->toArray();
@endphp

<div id="characterComponents" class="hide">
    <div class="sales-character mb-3 card">
        <div class="card-body">
            <div class="text-right"><a href="#" class="remove-character text-muted"><i class="fas fa-times"></i></a></div>
            <div class="row">
                <div class="col-md-2 align-items-stretch d-flex">
                    <div class="d-flex text-center align-items-center">
                        <div class="character-image-blank">{{ __('Enter character code.') }}</div>
                        <div class="character-image-loaded hide"></div>
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="form-group">
                        {!! Form::label('slug', __('Character Code')) !!}
                        {!! Form::select('slug[]', $characters, null, ['class' => 'form-control character-code', 'placeholder' => __('Select Character')]) !!}
                    </div>
                    <div class="character-details hide">
                        <h4>{{ __('Sale Details') }}</h4>

                        <div class="form-group mb-2">
                            {!! Form::label(__('Type')) !!}
                            {!! Form::select('sale_type[]', ['flatsale' => __('Flatsale'), 'auction' => __('Auction'), 'ota' => __('OTA'), 'xta' => __('XTA'), 'raffle' => __('Raffle'), 'flaffle' => __('Flatsale Raffle'), 'pwyw' => __('Pay What You Want')], null, [
                                'class' => 'form-control character-sale-type',
                                'placeholder' => __('Select Sale Type'),
                            ]) !!}
                        </div>

                        <div class="saleType">
                            <div class="mb-3 hide flatOptions">
                                <div class="form-group">
                                    {!! Form::label(__('Price')) !!}
                                    {!! Form::number('price[]', null, ['class' => 'form-control', 'placeholder' => __('Enter a Cost')]) !!}
                                </div>
                            </div>

                            <div class="mb-3 hide auctionOptions">
                                <div class="form-group">
                                    {!! Form::label(__('Starting Bid')) !!}
                                    {!! Form::number('starting_bid[]', null, ['class' => 'form-control', 'placeholder' => __('Enter a Starting Bid')]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label(__('Minimum Increment')) !!}
                                    {!! Form::number('min_increment[]', null, ['class' => 'form-control', 'placeholder' => __('Enter a Minimum Increment')]) !!}
                                </div>
                            </div>

                            <div class="mb-3 hide xtaOptions">
                                <div class="form-group">
                                    {!! Form::label(__('Autobuy (Optional)')) !!}
                                    {!! Form::number('autobuy[]', null, ['class' => 'form-control', 'placeholder' => __('Enter an Autobuy')]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label(__('End Point (Optional)')) !!}
                                    {!! Form::text('end_point[]', null, ['class' => 'form-control', 'placeholder' => __('Provide information about when bids/offers close')]) !!}
                                </div>
                            </div>

                            <div class="mb-3 hide pwywOptions">
                                <div class="form-group">
                                    {!! Form::label(__('Minimum Offer (Optional)')) !!}
                                    {!! Form::number('minimum[]', null, ['class' => 'form-control', 'placeholder' => __('Enter a Minimum')]) !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group my-2">
                            {!! Form::label(__('Notes (Optional)')) !!}
                            {!! Form::text('description[]', null, ['class' => 'form-control', 'placeholder' => __('Provide any additional notes necessary')]) !!}
                        </div>

                        <div class="form-group mb-4">
                            {!! Form::label(__('Link (Optional)')) !!} {!! add_help(__('The URL for where to buy, bid, etc. on the character.')) !!}
                            {!! Form::text('link[]', null, ['class' => 'form-control', 'placeholder' => __('URL')]) !!}
                        </div>

                        {!! Form::hidden('new_entry[]', 1) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
