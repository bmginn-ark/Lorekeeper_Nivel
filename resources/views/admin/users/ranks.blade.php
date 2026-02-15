@extends('admin.layout')

@section('admin-title')
    {{ __('User Ranks') }}
@endsection

@section('admin-content')
    {!! breadcrumbs([__('Admin Panel') => 'admin', __('User Ranks') => 'admin/users/ranks']) !!}

    <h1>{{ __('User Ranks') }}</h1>

    <p>{{ __('You can create and edit ranks to assign to users here. Ranks can have powers attached, which allows users with the rank to view and edit data on certain parts of the site. To assign a rank to a user, find their admin page from the') }} <a href="{{ url('admin/users') }}">{{ __('User Index') }}</a> {{ __('and change their rank there.') }}</p>

    <div class="text-right mb-3"><a class="btn btn-primary create-rank-button" href="#"><i class="fas fa-plus"></i> {{ __('Add New Rank') }}</a></div>
    <table class="table table-sm ranks-table">
        <thead>
            <tr>
                <th></th>
                <th>{{ __('Rank') }}</th>
                <th>{{ __('Description') }}</th>
                <th>{{ __('Powers') }}</th>
                <th></th>
            </tr>
        </thead>
        <tbody id="sortable" class="sortable">
            @foreach ($ranks as $rank)
                <tr {{ !$rank->isAdmin ? 'class=sort-item' : '' }} data-id="{{ $rank->id }}">
                    <td>
                        @if (!$rank->isAdmin)
                            <a class="fas fa-arrows-alt-v handle" href="#"></a>
                        @endif
                    </td>
                    <td><i class="{!! $rank->icon ? $rank->icon . ' mr-2' : '' !!} "></i>{!! $rank->displayName !!}</td>
                    <td>{!! $rank->parsed_description !!}</td>
                    <td>
                        @foreach ($rank->getPowers() as $power)
                            <div>{{ $power['name'] }}</div>
                        @endforeach
                    </td>
                    <td>
                        <a href="#" class="btn btn-primary edit-rank-button" data-id="{{ $rank->id }}">{{ __('Edit') }}</a>
                        @if (!$rank->isAdmin)
                            <a href="#" class="btn btn-danger delete-rank-button" data-id="{{ $rank->id }}">{{ __('Delete') }}</a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>
    <div>
        {!! Form::open(['url' => 'admin/users/ranks/sort']) !!}
        {!! Form::hidden('sort', '', ['id' => 'sortableOrder']) !!}
        {!! Form::submit(__('Save Order'), ['class' => 'btn btn-primary']) !!}
        {!! add_help(__('This order is reflected in the sort order on the users list. Additionally, users with the Edit User Info power cannot edit users with a rank higher than their own.')) !!}
        {!! Form::close() !!}
    </div>
@endsection

@section('scripts')
    @parent
    <script>
        $(document).ready(function() {
            $('.create-rank-button').on('click', function(e) {
                e.preventDefault();
                loadModal("{{ url('admin/users/ranks/create') }}", '{{ __('Create Rank') }}');
            });
            $('.edit-rank-button').on('click', function(e) {
                e.preventDefault();
                loadModal("{{ url('admin/users/ranks/edit') }}" + '/' + $(this).data('id'), '{{ __('Edit Rank') }}');
            });
            $('.delete-rank-button').on('click', function(e) {
                e.preventDefault();
                loadModal("{{ url('admin/users/ranks/delete') }}" + '/' + $(this).data('id'), '{{ __('Delete Rank') }}');
            });
            $('.handle').on('click', function(e) {
                e.preventDefault();
            });
            $("#sortable").sortable({
                items: '.sort-item',
                handle: ".handle",
                placeholder: "sortable-placeholder",
                stop: function(event, ui) {
                    $('#sortableOrder').val($(this).sortable("toArray", {
                        attribute: "data-id"
                    }));
                },
                create: function() {
                    $('#sortableOrder').val($(this).sortable("toArray", {
                        attribute: "data-id"
                    }));
                }
            });
            $("#sortable").disableSelection();
        });
    </script>
@endsection
