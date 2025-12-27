@extends('character.design.layout')

@section('design-title')
    요청 (#{{ $request->id }}) :: 애드온
@endsection

@section('design-content')
    {!! breadcrumbs(['디자인 승인' => 'designs', '요청 (#' . $request->id . ')' => 'designs/' . $request->id, '애드온' => 'designs/' . $request->id . '/addons']) !!}

    @include('character.design._header', ['request' => $request])

    <h2>애드온</h2>

    @if ($request->status == 'Draft' && $request->user_id == Auth::user()->id && $request->character)
        <p>
            요청에 추가할 아이템 및/또는 재화를 선택하세요.
            선택한 아이템은 인벤토리{{ $request->character->is_myo_slot ? '' : ' 및/또는 캐릭터' }}에서 차감되지만,
            요청에서 제거되거나 요청이 거절 또는 삭제될 경우 환불됩니다.
            아이템이나 재화를 첨부하지 않을 경우에도, 이 섹션을 완료 처리하기 위해 저장 버튼을 한 번 눌러주세요.
        </p>

        {!! Form::open(['url' => 'designs/' . $request->id . '/addons']) !!}
        @include('widgets._inventory_select', ['user' => Auth::user(), 'inventory' => $inventory, 'categories' => $categories, 'selected' => $request->inventory])
        @include('widgets._bank_select', ['owner' => Auth::user(), 'selected' => $request->userBank])

        @if (!$request->character->is_myo_slot)
            @include('widgets._bank_select', ['owner' => $request->character, 'selected' => $request->characterBank])
        @endif

        <div class="text-right">
            {!! Form::submit('저장', ['class' => 'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
    @else
        <p>
            아래에 나열된 아이템 및/또는 재화는 이미 소유자에게서 차감되었으며,
            요청이 거절될 경우 환불됩니다.
        </p>

        @if ($inventory && count($inventory))
            <h3>{!! $request->user->displayName !!}의 인벤토리</h3>
            <div class="card mb-3">
                <div class="card-body">
                    <table class="table table-sm">
                        <thead class="thead-light">
                            <tr class="d-flex">
                                <th class="col-2">아이템</th>
                                <th class="col-4">출처</th>
                                <th class="col-4">메모</th>
                                <th class="col-2">수량</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($inventory['user_items'] as $itemRow)
                                <tr class="d-flex">
                                    <td class="col-2">
                                        @if (isset($itemRow['asset']) && isset($items[$itemRow['asset']->item_id]->image_url))
                                            <img class="small-icon" src="{{ $items[$itemRow['asset']->item_id]->image_url }}" alt="{{ $items[$itemRow['asset']->item_id]->name }}">
                                        @endif
                                        {!! isset($itemRow['asset']) ? $items[$itemRow['asset']->item_id]->name : '<i>삭제된 사용자 아이템</i>' !!}
                                    </td>
                                    <td class="col-4">
                                        {!! isset($itemRow['asset']) && array_key_exists('data', $itemRow['asset']->data)
                                            ? ($itemRow['asset']->data['data'] ? $itemRow['asset']->data['data'] : '없음')
                                            : '없음' !!}
                                    </td>
                                    <td class="col-4">
                                        {!! isset($itemRow['asset']) && array_key_exists('notes', $itemRow['asset']->data)
                                            ? ($itemRow['asset']->data['notes'] ? $itemRow['asset']->data['notes'] : '없음')
                                            : '없음' !!}
                                    </td>
                                    <td class="col-2">{!! $itemRow['quantity'] !!}</td>
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
