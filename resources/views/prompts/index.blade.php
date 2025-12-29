@extends('prompts.layout')

@section('prompts-title')
    홈
@endsection

@section('content')
    {!! breadcrumbs(['Prompts' => 'prompts']) !!}

    <h1>프롬프트</h1>
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <img src="{{ asset('images/inventory.png') }}" alt="Prompts" />
                    <h5 class="card-title">프롬프트</h5>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><a href="{{ url('prompts/prompt-categories') }}">프롬프트 카테고리</a></li>
                    <li class="list-group-item"><a href="{{ url('prompts/prompts') }}">모든 프롬프트</a></li>
                </ul>
            </div>
        </div>
    </div>
@endsection
