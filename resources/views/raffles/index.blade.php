@extends('layouts.app')

@section('title')
    추첨
@endsection

@section('content')
    {!! breadcrumbs(['Raffles' => 'raffles']) !!}
    <h1>추첨</h1>
    <p>추첨 이름을 클릭하여 티켓을 확인할 수 있으며, 완료된 추첨의 경우 당첨자가 됩니다. 제목이 있는 그룹의 추첨은 상단부터 연속적으로 진행되며 중복 당첨자는 추첨하지 않습니다.</p>
    <ul class="nav nav-tabs mb-3">
        <li class="nav-item"><a href="{{ url()->current() }}" class="nav-link {{ Request::get('view') ? '' : 'active' }}">진행중인 추첨</a></li>
        <li class="nav-item"><a href="{{ url()->current() }}?view=completed" class="nav-link {{ Request::get('view') == 'completed' ? 'active' : '' }}">완료된 추첨</a></li>
    </ul>

    @if (count($raffles))
        <?php $prevGroup = null; ?>
        <ul class="list-group mb-3">
            @foreach ($raffles as $raffle)
                @if ($prevGroup != $raffle->group_id)
        </ul>
        @if ($prevGroup)
            </div>
        @endif
        <div class="card mb-3">
            <div class="card-header h3">{{ $groups[$raffle->group_id]->name }}</div>
            <ul class="list-group list-group-flush">
    @endif

    <li class="list-group-item">
        <x-admin-edit title="Raffle" :object="$raffle" />
        <a href="{{ url('raffles/view/' . $raffle->id) }}">{{ $raffle->name }}</a>
    </li>
    <?php $prevGroup = $raffle->group_id; ?>
    @endforeach
@else
    <p>추첨이 없습니다.</p>
    @endif
@endsection
@section('scripts')
    @parent
@endsection
