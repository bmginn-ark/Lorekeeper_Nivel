@extends('admin.layout')

@section('admin-title')
    {{ __('Deactivate User') }}: {{ $user->name }}
@endsection

@section('admin-content')
    {!! breadcrumbs([__('Admin Panel') => 'admin', __('User Index') => 'admin/users', $user->name => 'admin/users/' . $user->name . '/edit', __('Deactivate User') => 'admin/users/' . $user->name . '/deactivate']) !!}

    <h1>{{ __('User') }}: {!! $user->displayName !!}</h1>
    <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <a class="nav-link" href="{{ $user->adminUrl }}">{{ __('Account') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('admin/users/' . $user->name . '/updates') }}">{{ __('Account Updates') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('admin/users/' . $user->name . '/ban') }}">{{ __('Ban') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="{{ url('admin/users/' . $user->name . '/deactivate') }}">{{ __('Deactivate') }}</a>
        </li>
    </ul>

    <h3>{{ $user->is_deactivated ? __('Edit Deactivation') : __('Deactivate') }}</h3>
    <p>{{ __('Deactivating the user will remove their rank, cancel all of their queued submissions and transfers, and prevent them from using any other site features. The deactivate reason will be displayed on the blacklist.') }}</p>

    {!! Form::open(['url' => 'admin/users/' . $user->name . '/deactivate', 'id' => 'deactivateForm']) !!}
    <div class="form-group">
        {!! Form::label(__('Reason (Optional; no HTML)')) !!}
        {!! Form::textarea('deactivate_reason', $user->settings->deactivate_reason, ['class' => 'form-control']) !!}
    </div>
    <div class="text-right">
        {!! Form::submit($user->is_deactivated ? __('Edit') : __('Deactivate'), ['class' => 'btn btn' . ($user->is_deactivated ? '' : '-outline') . '-danger deactivate-button']) !!}
    </div>
    {!! Form::close() !!}

    @if ($user->is_deactivated)
        <h3>{{ __('Reactivate') }}</h3>
        <p>{{ __('Reactivating the user will grant them access to site features again. However, if they had a rank before being deactivated, it will not be restored.') }}</p>
        <div class="text-right">
            <a href="#" class="btn btn-outline-danger reactivate-button">{{ __('Reactivate') }}</a>
        </div>
    @endif
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            @if (!$user->is_deactivated)
                $('.deactivate-button').on('click', function(e) {
                    e.preventDefault();
                    loadModal("{{ url('admin/users/' . $user->name . '/deactivate-confirm') }}", '{{ __('Deactivate User') }}');
                });
            @else
                $('.reactivate-button').on('click', function(e) {
                    e.preventDefault();
                    loadModal("{{ url('admin/users/' . $user->name . '/reactivate-confirm') }}", '{{ __('Reactivate User') }}');
                });
            @endif
        });
    </script>
@endsection
