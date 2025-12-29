<div class="card mb-3">
    <div class="card-header">
        <h2 class="mb-0"><span
                class="float-right badge badge-{{ $trade->status == 'Pending' || $trade->status == 'Open' || $trade->status == 'Canceled' ? 'secondary' : ($trade->status == 'Completed' ? 'success' : 'danger') }}">{{ $trade->status }}</span><a
                href="{{ $trade->url }} ">거래 (#{{ $trade->id }})</a></h2>
    </div>
    <div class="card-body">
        @if ($trade->comments)
            <div>{!! nl2br(htmlentities($trade->comments)) !!}</div>
            <hr />
        @endif
        <div class="row">
            <div class="col-md-6">
                <h3 class="card-heading">
                    {!! $trade->sender->id == Auth::user()->id ? 'Your Offer' : $trade->sender->displayName . '의 제안' !!}
                    <span class="float-right">
                        @if ($trade->{'is_sender_confirmed'})
                            @if ($trade->{'is_sender_trade_confirmed'})
                                <small class="text-success">거래 승인됨</small>
                            @else
                                <small class="text-primary">제안 승인됨</small>
                            @endif
                        @else
                            <small class="text-muted">대기중</small>
                        @endif
                    </span>
                </h3>
                @include('home.trades._offer_summary', [
                    'user' => $trade->sender,
                    'data' => isset($trade->data['sender']) ? parseAssetData($trade->data['sender']) : null,
                    'trade' => $trade,
                    'stacks' => isset($stacks[$trade->id]['sender']) ? $stacks[$trade->id]['sender'] : null,
                ])
            </div>
            <div class="col-md-6">
                <h3 class="card-heading">
                    {!! $trade->recipient->id == Auth::user()->id ? 'Your Offer' : $trade->recipient->displayName . '\'s Offer' !!}
                    <span class="float-right">
                        @if ($trade->{'is_recipient_confirmed'})
                            @if ($trade->{'is_recipient_trade_confirmed'})
                                <small class="text-success">거래 승인됨</small>
                            @else
                                <small class="text-primary">제안 승인됨</small>
                            @endif
                        @else
                            <small class="text-muted">대기중</small>
                        @endif
                    </span>
                </h3>
                @include('home.trades._offer_summary', [
                    'user' => $trade->recipient,
                    'data' => isset($trade->data['recipient']) ? parseAssetData($trade->data['recipient']) : null,
                    'trade' => $trade,
                    'stacks' => isset($stacks[$trade->id]['recipient']) ? $stacks[$trade->id]['recipient'] : null,
                ])
            </div>
        </div>
        <hr />
        <div class="text-right">
            <a href="{{ $trade->url }}" class="btn btn-outline-primary">자세히 보기</a>
            @if (isset($queueView) && $trade->status == 'Pending')
                @if (!$trade->is_approved)
                    <a href="#" class="btn btn-outline-success trade-action-button" data-id="{{ $trade->id }}" data-action="approve">승인</a>
                    <a href="#" class="btn btn-outline-danger trade-action-button" data-id="{{ $trade->id }}" data-action="reject">거절</a>
                @else
                    현재 스태프의 승인을 기다리고 있습니다
                @endif
            @endif
        </div>
    </div>
</div>
