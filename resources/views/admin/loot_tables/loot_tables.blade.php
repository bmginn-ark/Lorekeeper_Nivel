@extends('admin.layout')

@section('admin-title')
    {{ __('Loot Tables') }}
@endsection

@section('admin-content')
    {!! breadcrumbs([__('Admin Panel') => 'admin', __('Loot Tables') => 'admin/data/loot-tables']) !!}

    <h1>{{ __('Loot Tables') }}</h1>

    <p>{{ __('Loot tables can be attached to prompts as a reward for doing the prompt. This will roll a random reward from the contents of the table. Tables can be chained as well.') }}</p>

    <div class="text-right mb-3"><a class="btn btn-primary" href="{{ url('admin/data/loot-tables/create') }}"><i class="fas fa-plus"></i> {{ __('Create New Loot Table') }}</a></div>
    @if (!count($tables))
        <p>{{ __('No loot tables found.') }}</p>
    @else
        {!! $tables->render() !!}
        <div class="mb-4 logs-table">
            <div class="logs-table-header">
                <div class="row">
                    <div class="col-3 col-md-2">
                        <div class="logs-table-cell">{{ __('ID') }}</div>
                    </div>
                    <div class="col-3 col-md-4">
                        <div class="logs-table-cell">{{ __('Name') }}</div>
                    </div>
                    <div class="col-6 col-md-5">
                        <div class="logs-table-cell">{{ __('Display Name') }}</div>
                    </div>
                </div>
            </div>
            <div class="logs-table-body">
                @foreach ($tables as $table)
                    <div class="logs-table-row">
                        <div class="row flex-wrap">
                            <div class="col-3 col-md-2">
                                <div class="logs-table-cell">#{{ $table->id }}</div>
                            </div>
                            <div class="col-3 col-md-4">
                                <div class="logs-table-cell">{{ $table->name }}</div>
                            </div>
                            <div class="col-3 col-md-5">
                                <div class="logs-table-cell">{!! $table->display_name !!}</div>
                            </div>
                            <div class="col-3 col-md-1 text-right">
                                <div class="logs-table-cell"><a href="{{ url('admin/data/loot-tables/edit/' . $table->id) }}" class="btn btn-primary py-0 px-2">{{ __('Edit') }}</a></div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        {!! $tables->render() !!}
        <div class="text-center mt-4 small text-muted">{{ $tables->total() }} {{ $tables->total() == 1 ? __('result') : __('results') }} {{ __('found.') }}</div>
    @endif

@endsection
