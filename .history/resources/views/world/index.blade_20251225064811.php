@extends('world.layout')

@section('world-title')
    홈
@endsection

@section('content')
    {!! breadcrumbs(['Encyclopedia' => 'world']) !!}

    <h1>World</h1>
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <img src="{{ asset('images/characters.png') }}" alt="Characters" />
                    <h5 class="card-title">Characters</h5>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><a href="{{ url('world/species') }}">종</a></li>
                    <li class="list-group-item"><a href="{{ url('world/subtypes') }}">분류</a></li>
                    <li class="list-group-item"><a href="{{ url('world/rarities') }}">희귀도</a></li>
                    <li class="list-group-item"><a href="{{ url('world/trait-categories') }}">특성 카테고리</a></li>
                    <li class="list-group-item"><a href="{{ url('world/traits') }}">모든 특성</a></li>
                    <li class="list-group-item"><a href="{{ url('world/character-categories') }}">캐릭터 카테고리</a></li>
                </ul>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <img src="{{ asset('images/inventory.png') }}" alt="Items" />
                    <h5 class="card-title">아이템</h5>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><a href="{{ url('world/item-categories') }}">아이템 카테고리</a></li>
                    <li class="list-group-item"><a href="{{ url('world/items') }}">모든 아이템</a></li>
                    <li class="list-group-item"><a href="{{ url('world/currencies') }}">재화</a></li>
                </ul>
            </div>
        </div>
    </div>
@endsection
