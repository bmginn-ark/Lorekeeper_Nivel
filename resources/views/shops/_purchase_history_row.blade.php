<div class="row flex-wrap">
    <div class="col-12 col-md-2">
        <div class="logs-table-cell">{!! $log->item ? $log->item->displayName : '(삭제된 아이템)' !!}</div>
    </div>
    <div class="col-12 col-md-2">
        <div class="logs-table-cell">{!! $log->quantity !!}</div>
    </div>
    <div class="col-12 col-md-2">
        <div class="logs-table-cell">{!! $log->shop ? $log->shop->displayName : '(삭제된 상점)' !!}</div>
    </div>
    <div class="col-12 col-md-2">
        <div class="logs-table-cell">{!! $log->character_id ? $log->character->displayName : '' !!}</div>
    </div>
    <div class="col-12 col-md-2">
        <div class="logs-table-cell">{!! $log->currency ? $log->currency->display($log->cost) : $log->cost . ' (삭제된 재화)' !!}</div>
    </div>
    <div class="col-12 col-md-2">
        <div class="logs-table-cell">{!! pretty_date($log->created_at) !!}</div>
    </div>
</div>
