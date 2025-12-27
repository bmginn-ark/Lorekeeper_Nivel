@extends('home.layout')

@section('home-title')
    거래
@endsection

@section('home-content')
    {!! breadcrumbs(['Trades' => 'trades/open', 'New Trade' => 'trades/create']) !!}

    <h1>
        새 거래
    </h1>

    <p>
        새 거래를 만듭니다. 거래 생성 후 거래 첨부 파일을 수정할 수 있습니다. 이는 거래를 설정하는 것이므로 처음부터 모든 것이 준비되어 있어야 할 필요가 없습니다. 수신자는 새 거래에 대해 알림을 받고 첨부 파일을 수정할 수 있습니다. 각 사용자는 한 거래에 최대 <strong>{{ config('lorekeeper.settings.trade_asset_limit') }}개의 항목만 추가할 수 있습니다 - 필요한 경우 새 거래를 만들어 추가하세요.</strong>
    </p>

    {!! Form::open(['url' => 'trades/create']) !!}

    <div class="form-group">
        {!! Form::label('recipient_id', '받는 이') !!}
        {!! Form::select('recipient_id', $userOptions, old('recipient_id'), ['class' => 'form-control user-select', 'placeholder' => '유저 선택']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('comments', '코멘트 (옵션)') !!} {!! add_help('이 댓글은 거래란에 표시됩니다. 예를 들어 거래 목적을 기록하기 위해 여기에 유용한 메모를 작성할 수 있습니다.') !!}
        {!! Form::textarea('comments', null, ['class' => 'form-control']) !!}
    </div>
    @include('widgets._inventory_select', ['user' => Auth::user(), 'inventory' => $inventory, 'categories' => $categories, 'selected' => [], 'page' => $page])
    @include('widgets._my_character_select', ['readOnly' => true, 'categories' => $characterCategories])
    @include('widgets._bank_select', ['owner' => Auth::user(), 'selected' => null, 'isTransferrable' => true])
    <div class="text-right">{!! Form::submit('Create Trade', ['class' => 'btn btn-primary']) !!}</div>
    {!! Form::close() !!}
@endsection
@section('scripts')
    @parent
    @include('widgets._bank_select_row', ['owners' => [Auth::user()], 'isTransferrable' => true])
    @include('widgets._bank_select_js', [])
    @include('widgets._inventory_select_js', ['readOnly' => true])
    @include('widgets._my_character_select_js', ['readOnly' => true])
    <script>
        $('.user-select').selectize();
    </script>
@endsection
