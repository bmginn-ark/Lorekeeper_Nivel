@extends('character.design.layout')

@section('design-title')
    요청 (#{{ $request->id }}) :: 추가
@endsection

@section('design-content')
    {!! breadcrumbs(['Design Approvals' => 'designs', 'Request (#' . $request->id . ')' => 'designs/' . $request->id, 'Add-ons' => 'designs/' . $request->id . '/addons']) !!}

    @include('character.design._header', ['request' => $request])

    <h2>추가</h2>

    @if ($request->status == 'Draft' && $request->user_id == Auth::user()->id && $request->character)
        <p>요청에 추가할 항목 및/또는 재화를 선택하세요. 이 항목들은 귀하의 인벤토리에서 제거될 것입니다. 그러나 요청이 거부되거나 삭제되면 환불됩니다. 
            항목/재화화를 첨부할 의도가 없는 경우 저장 버튼을 한 번 클릭하여 이 섹션을 완료한 것으로 표시하세요.</p>
        {!! Form::open(['url' => 'designs/' . $request->id . '/addons']) !!}
        @include('widgets._inventory_select', ['user' => Auth::user(), 'inventory' => $inventory, 'categories' => $categories, 'selected' => $request->inventory])
        @include('widgets._bank_select', ['owner' => Auth::user(), 'selected' => $request->userBank])

        @if (!$request->character->is_myo_slot)
            @include('widgets._bank_select', ['owner' => $request->character, 'selected' => $request->characterBank])
        @endif

        <div class="text-right">
            {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
    @else
        <p>나열된 항목 및/또는 재화화는 보유자에서 제거되며 요청이 거부되면 환불됩니다.</p>
        @if ($inventory && count($inventory))
            <h3>{!! $request->user->displayName !!}의 인벤토리</h3>
            <div class="card mb-3">
                <div class="card-body">
                    <table class="table table-sm">
                        <thead class="thead-light">
                            <tr class="d-flex">
                                <th class="col-2">아이템</th>
                                <th class="col-4">출처</th>
                                <th class="col-4">정보</th>
                                <th class="col-2">수량</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($inventory['user_items'] as $itemRow)
                                <tr class="d-flex">
                                    <td class="col-2">
                                        @if (isset($itemRow['asset']) && isset($items[$itemRow['asset']->item_id]->image_url))
                                            <img class="small-icon" src="{{ $items[$itemRow['asset']->item_id]->image_url }}" alt=" {{ $items[$itemRow['asset']->item_id]->name }} ">
                                        @endif {!! isset($itemRow['asset']) ? $items[$itemRow['asset']->item_id]->name : '<i>Deleted User Item</i>' !!}
                                    <td class="col-4">{!! isset($itemRow['asset']) && array_key_exists('data', $itemRow['asset']->data) ? ($itemRow['asset']->data['data'] ? $itemRow['asset']->data['data'] : 'N/A') : 'N/A' !!}</td>
                                    <td class="col-4">{!! isset($itemRow['asset']) && array_key_exists('notes', $itemRow['asset']->data) ? ($itemRow['asset']->data['notes'] ? $itemRow['asset']->data['notes'] : 'N/A') : 'N/A' !!}</td>
                                    <td class="col-2">{!! $itemRow['quantity'] !!}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
        @if (count($request->userBank))
            <h3>{!! $request->user->displayName !!}의 은행</h3>
            <table class="table table-sm mb-3">
                <thead>
                    <tr>
                        <th width="70%">재화</th>
                        <th width="30%">수량</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($request->getBank('user') as $currency)
                        <tr>
                            <td>{!! $currency->displayName !!}</td>
                            <td>{{ $currency->quantity }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
        @if ($request->character && count($request->characterBank))
            <h3>{!! $request->character->displayName !!}의 은행</h3>
            <table class="table table-sm mb-3">
                <thead>
                    <tr>
                        <th width="70%">재화</th>
                        <th width="30%">수량</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($request->getBank('character') as $currency)
                        <tr>
                            <td>{!! $currency->displayName !!}</td>
                            <td>{{ $currency->quantity }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    @endif

@endsection

@section('scripts')
    @include('widgets._bank_select_row', ['owners' => [Auth::user(), $request->character]])
    @include('widgets._inventory_select_js', ['readOnly' => true])
    @include('widgets._bank_select_js', [])
@endsection
