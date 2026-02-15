@extends('admin.layout')

@section('admin-title')
    {{ __('Grant User Currency') }}
@endsection

@section('admin-content')
    {!! breadcrumbs([__('Admin Panel') => 'admin', __('Grant User Currency') => 'admin/grants/user-currency']) !!}

    <h1>{{ __('Grant User Currency') }}</h1>

    {!! Form::open(['url' => 'admin/grants/user-currency']) !!}

    <h3>{{ __('Basic Information') }}</h3>

    <div class="form-group">
        {!! Form::label('names[]', __('Username(s)')) !!} {!! add_help(__('You can select up to 10 users at once.')) !!}
        {!! Form::select('names[]', $users, null, ['id' => 'usernameList', 'class' => 'form-control', 'multiple']) !!}
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('currency_id', __('Currency')) !!}
                {!! Form::select('currency_id', $userCurrencies, null, ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('quantity', __('Quantity')) !!} {!! add_help(__('If the value given is less than 0, this will be deducted from the user(s).')) !!}
                {!! Form::text('quantity', null, ['class' => 'form-control']) !!}
            </div>
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('data', __('Reason (Optional)')) !!} {!! add_help(__('A reason for the grant. This will be noted in the logs.')) !!}
        {!! Form::text('data', null, ['class' => 'form-control']) !!}
    </div>

    <div class="text-right">
        {!! Form::submit(__('Submit'), ['class' => 'btn btn-primary']) !!}
    </div>

    {!! Form::close() !!}

    <script>
        $(document).ready(function() {
            $('#usernameList').selectize({
                maxItems: 10
            });
        });
    </script>
@endsection
