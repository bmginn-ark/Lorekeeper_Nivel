<h2>
    {!! $user->displayName !!}의 제안
    <span class="float-right">
        @if (Auth::user()->id == $user->id && $trade->status == 'Open')
            @if ($trade->{'is_' . $type . '_confirmed'})
                <a href="#" class="btn btn-sm btn-outline-danger" id="confirmOfferButton" data-toggle="tooltip"
                    title="This will unconfirm your offer and allow you to edit it. You will need to reconfirm your offer after you have edited it to proceed.">미승인</a>
            @else
                <a href="{{ url('trades/' . $trade->id . '/edit') }}" class="btn btn-sm btn-primary">Edit</a> <a href="#" class="btn btn-sm btn-outline-primary" id="confirmOfferButton">승인</a>
            @endif
        @else
            @if ($trade->{'is_' . $type . '_confirmed'})
                @if ($trade->{'is_' . $type . '_trade_confirmed'})
                    <small class="text-success">{!! add_help($user->name . ' has reviewed your offer and confirmed the trade.') !!} 거래 승인됨</small>
                @else
                    <small class="text-primary">{!! add_help('This offer has been confirmed.') !!} 제안 승인됨</small>
                @endif
            @else
                <small class="text-muted">{!! add_help('This offer has yet to be confirmed.') !!} 대기중</small>
            @endif
        @endif
    </span>
</h2>
<div class="card mb-3 trade-offer
        @if ($trade->{'is_' . $type . '_confirmed'}) @if ($trade->{'is_' . $type . '_trade_confirmed'})
                border-success
            @else
                border-primary @endif
        @endif
">
    @if ($data)
        @if ($data['user_items'])
            <div class="card-header">
                아이템
            </div>
            <div class="card-body user-items">
                <table class="table table-sm">
                    <thead class="thead-light">
                        <tr class="d-flex">
                            <th class="col-2">아이템</th>
                            <th class="col-4">출처</th>
                            <th class="col-4">설명</th>
                            <th class="col-2">개수</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data['user_items'] as $itemRow)
                            <tr class="d-flex">
                                <td class="col-2">
                                    @if (isset($items[$itemRow['asset']->item_id]->image_url))
                                        <img class="small-icon" src="{{ $items[$itemRow['asset']->item_id]->image_url }}" alt="{{ $items[$itemRow['asset']->item_id]->name }}">
                                    @endif {!! $items[$itemRow['asset']->item_id]->name !!}
                                <td class="col-4">{!! array_key_exists('data', $itemRow['asset']->data) ? ($itemRow['asset']->data['data'] ? $itemRow['asset']->data['data'] : 'N/A') : 'N/A' !!}</td>
                                <td class="col-4">{!! array_key_exists('notes', $itemRow['asset']->data) ? ($itemRow['asset']->data['notes'] ? $itemRow['asset']->data['notes'] : 'N/A') : 'N/A' !!}</td>
                                <td class="col-2">{!! $itemRow['quantity'] !!}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
        @if ($data['characters'])
            <div class="card-header border-top">
                캐릭터
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach ($data['characters'] as $character)
                        <div class="col-lg-2 col-sm-3 col-6 mb-3">
                            <div class="text-center inventory-item">
                                <div class="mb-1">
                                    <a class="inventory-stack"><img src="{{ $character['asset']->image->thumbnailUrl }}" class="img-thumbnail" alt="Thumbnail for {{ $character['asset']->fullName }}" /></a>
                                </div>
                                <div>
                                    <a class="inventory-stack inventory-stack-name">{!! $character['asset']->displayName !!}</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
        @if ($data['currencies'])
            <div class="card-header border-top border-bottom-0">
                재화
            </div>
            <ul class="list-group list-group-flush">
                @foreach ($data['currencies'] as $currency)
                    <li class="list-group-item border-bottom-0 border-top currency-item">
                        {!! $currency['asset']->display($currency['quantity']) !!}
                    </li>
                @endforeach
            </ul>
        @endif
        @if (!$data['user_items'] && !$data['currencies'] && !$data['characters'])
            <div class="card-body">{!! $user->displayName !!}은 거래에 아무것도 제안하지 않았습니다.</div>
        @endif
    @else
        <div class="card-body">{!! $user->displayName !!}}은 거래에 아무것도 제안하지 않았습니다.</div>
    @endif
</div>
