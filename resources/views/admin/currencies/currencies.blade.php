@extends('admin.layout')

@section('admin-title')
    {{ __('Currencies') }}
@endsection

@section('admin-content')
    {!! breadcrumbs([__('Admin Panel') => 'admin', __('Currencies') => 'admin/data/currencies']) !!}

    <h1>{{ __('Currencies') }}</h1>

    <p>{{ __('This is a list of currencies that can be earned by users and/or characters. While they\'re collectively called "currencies", they can be used to track activity counts, event-only reward points, etc. and are not necessarily transferrable and/or can be spent. More information can be found on the creating/editing pages.') }}</p>

    <p>{!! __('The order of currencies as displayed on user and character profiles can be edited from the :link page.', ['link' => '<strong><a href="' . url('admin/data/currencies/sort') . '">' . __('Sort Currencies') . '</a></strong>']) !!}</p>

    <div class="text-right mb-3"><a class="btn btn-primary" href="{{ url('admin/data/currencies/create') }}"><i class="fas fa-plus"></i> {{ __('Create New Currency') }}</a></div>
    {!! $currencies->render() !!}
    <div class="mb-4 logs-table">
        <div class="logs-table-header">
            <div class="row">
                <div class="col-12 col-md-4">
                    <div class="logs-table-cell">{{ __('Name') }}</div>
                </div>
                <div class="col-4 col-md-4">
                    <div class="logs-table-cell">{{ __('Displays As') }}</div>
                </div>
                <div class="col-4 col-md-3">
                    <div class="logs-table-cell">{{ __('Attaches To') }}</div>
                </div>
            </div>
        </div>
        <div class="logs-table-body">
            @foreach ($currencies as $currency)
                <div class="logs-table-row">
                    <div class="row flex-wrap">
                        <div class="col-12 col-md-4 ">
                            <div class="logs-table-cell">{{ $currency->name }} @if ($currency->abbreviation)
                                    ({{ $currency->abbreviation }})
                                @endif
                            </div>
                        </div>
                        <div class="col-4 col-md-4">
                            <div class="logs-table-cell">{!! $currency->display(100) !!}</div>
                        </div>
                        <div class="col-4 col-md-3">
                            <div class="logs-table-cell">{{ $currency->is_user_owned ? __('User') : '' }} {{ $currency->is_character_owned && $currency->is_user_owned ? '+' : '' }} {{ $currency->is_character_owned ? __('Character') : '' }}</div>
                        </div>
                        <div class="col-4 col-md-1">
                            <div class="logs-table-cell"><a href="{{ url('admin/data/currencies/edit/' . $currency->id) }}" class="btn btn-primary">{{ __('Edit') }}</a></div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    {!! $currencies->render() !!}
    <div class="text-center mt-4 small text-muted">{{ $currencies->total() }} {{ $currencies->total() == 1 ? __('result') : __('results') }} {{ __('found.') }}</div>
@endsection
