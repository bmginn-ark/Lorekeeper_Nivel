@extends('admin.layout')

@section('admin-title')
    {{ __('Raffle Index') }}
@endsection

@section('admin-content')
    {!! breadcrumbs([__('Admin Panel') => 'admin', __('Raffle Index') => 'admin/raffles']) !!}

    <h1>{{ __('Raffle Index') }}</h1>
    <div class="text-right form-group">
        <a class="btn btn-success edit-group" href="#" data-id="">{{ __('Create Raffle Group') }}</a>
        <a class="btn btn-success edit-raffle" href="#" data-id="">{{ __('Create Raffle') }}</a>
    </div>
    <ul class="nav nav-tabs mb-3">
        <li class="nav-item"><a href="{{ url()->current() }}" class="nav-link {{ Request::get('is_active') ? '' : 'active' }}">{{ __('Current Raffles') }}</a></li>
        <li class="nav-item"><a href="{{ url()->current() }}?is_active=1" class="nav-link {{ Request::get('is_active') == 1 ? 'active' : '' }}">{{ __('Open Raffles') }}</a></li>
        <li class="nav-item"><a href="{{ url()->current() }}?is_active=2" class="nav-link {{ Request::get('is_active') == 2 ? 'active' : '' }}">{{ __('Completed Raffles') }}</a></li>
    </ul>
    @if (Request::get('is_active') == 1)
        <p>
            {{ __('This is the list of raffles that are visible to users and have not been rolled.') }}
        </p>
    @elseif(Request::get('is_active') == 2)
        <p>
            {{ __('This is the list of raffles that are complete (have been rolled). These will always be visible to users.') }}
        </p>
    @elseif(!Request::get('is_active'))
        <p>
            {{ __('This is the list of raffles that have not been rolled, including hidden raffles.') }}
        </p>
    @endif

    <?php $prevGroup = null; ?>
    <ul class="list-group mb-3">
        @foreach ($raffles as $raffle)
            @if ($prevGroup != $raffle->group_id)
    </ul>
    @if ($prevGroup)
        </div>
    @endif
    <div class="card mb-3">
        <div class="card-header">
            <h3 class="d-inline">{{ $groups[$raffle->group_id]->name }} <span class="badge badge-xs {{ $groups[$raffle->group_id]->is_active ? 'badge-success' : 'badge-danger' }}">{{ $groups[$raffle->group_id]->is_active ? __('Visible') : __('Hidden') }}</span>
            </h3>

            @if ($raffle->is_active < 2)
                <div class="float-right">
                    <a href="#" class="roll-group btn btn-outline-danger btn-sm" data-id="{{ $groups[$raffle->group_id]->id }}">{{ __('Roll Group') }}</a>
                    <a href="#" class="edit-group btn btn-outline-primary btn-sm" data-id="{{ $groups[$raffle->group_id]->id }}">{{ __('Edit Group') }}</a>
                </div>
            @endif
        </div>
        <ul class="list-group list-group-flush">
            @endif

            <li class="list-group-item">
                <i class="fas {{ $raffle->is_active ? 'fa-eye' : 'fa-eye-slash' }} mr-2"></i>
                <a href="{{ url('admin/raffles/view/' . $raffle->id) }}">{{ $raffle->name }}</a>
                @if ($raffle->is_active < 2)
                    <div class="float-right">
                        @if (!$raffle->group_id)
                            <a href="#" class="roll-raffle btn btn-outline-danger btn-xs p-2" data-id="{{ $raffle->id }}">{{ __('Roll Raffle') }}</a>
                        @endif
                        <a href="#" class="edit-raffle btn btn-xs btn-outline-primary p-2" data-id="{{ $raffle->id }}">
                            {{ __('Edit Raffle') }}
                        </a>
                    </div>
                @endif
            </li>
            <?php $prevGroup = $raffle->group_id; ?>
            @endforeach
        @endsection
        @section('scripts')
            @parent
            <script>
                $('.edit-group').on('click', function(e) {
                    e.preventDefault();
                    loadModal("{{ url('/admin/raffles/edit/group/') }}/" + $(this).data('id'), '{{ __("Edit Raffle Group") }}');
                });
                $('.edit-raffle').on('click', function(e) {
                    e.preventDefault();
                    loadModal("{{ url('/admin/raffles/edit/raffle/') }}/" + $(this).data('id'), '{{ __("Edit Raffle") }}');
                });
                $('.roll-raffle').on('click', function(e) {
                    e.preventDefault();
                    loadModal("{{ url('/admin/raffles/roll/raffle/') }}/" + $(this).data('id'), '{{ __("Roll Raffle") }}');
                });
                $('.roll-group').on('click', function(e) {
                    e.preventDefault();
                    loadModal("{{ url('/admin/raffles/roll/group/') }}/" + $(this).data('id'), '{{ __("Roll Raffle Group") }}');
                });
            </script>
        @endsection
