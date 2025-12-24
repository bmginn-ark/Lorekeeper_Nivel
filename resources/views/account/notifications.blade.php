@extends('account.layout')

@section('account-title')
    알림
@endsection

@section('account-content')
    {!! breadcrumbs(['My Account' => Auth::user()->url, 'Notifications' => 'notifications']) !!}

    <h1>알림</h1>

    <div class="text-right mb-3">
        {!! Form::open(['url' => 'notifications/clear', 'id' => 'clearForm']) !!}
        <a href="#" class="btn btn-primary" id="clearButton">모두 지우기</a>
        {!! Form::close() !!}
    </div>
    {!! $notifications->render() !!}

    @foreach ($notifications->pluck('notification_type_id')->unique() as $type)
        <div class="card mb-4">
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <span class="float-right h5 mb-2">
                        {!! Form::open(['url' => 'notifications/clear/' . $type]) !!}
                        <span class="badge badge-primary">
                            {{ $notifications->where('notification_type_id', $type)->count() }}
                        </span>
                        {!! Form::submit('x clear', ['class' => 'badge btn-primary', 'style' => 'display:inline; border: 0;']) !!}
                        {!! Form::close() !!}
                    </span>
                    <a class="card-title h5 collapse-title mb-2" href="#{{ str_replace(' ', '_', config('lorekeeper.notifications.' . $type . '.name')) }}" data-toggle="collapse">{{ config('lorekeeper.notifications.' . $type . '.name') }}
                    </a>
                    <div id="{{ str_replace(' ', '_', config('lorekeeper.notifications.' . $type . '.name')) }}" class="collapse {{ $notifications->where('notification_type_id', $type)->count() < 5 ? 'show' : '' }} mt-2">
                        <table class="table notifications-table">
                            <thead>
                                <tr>
                                    <th>메시지</th>
                                    <th>날짜</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($notifications->where('notification_type_id', $type) as $notification)
                                    <tr class="{{ $notification->is_unread ? 'unread' : '' }}">
                                        <td>{!! $notification->message !!}</td>
                                        <td>{!! format_date($notification->created_at) !!}</td>
                                        <td class="text-right"><a href="#" data-id="{{ $notification->id }}" class="clear-notification"><i class="fas fa-times" aria-hidden="true"></i></a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </li>
            </ul>
        </div>
    @endforeach
    @if (!count($notifications))
        <div class="text-center">알림이 없습니다.</div>
    @endif

    {!! $notifications->render() !!}

    <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="modal-title h5 mb-0">모든 알림 지우기</span>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p>이 작업은 <strong>모든</strong> 알림을 지웁니다. 정말로 진행하시겠습니까?</p>
                    <div class="text-right">
                        <a href="#" id="clearSubmit" class="btn btn-primary">모두 지우기</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
    <script>
        $(document).ready(function() {

            var $confirmationModal = $('#confirmationModal');
            var $clearButton = $('#clearButton');
            var $clearSubmit = $('#clearSubmit');
            var $clearForm = $('#clearForm');

            $clearButton.on('click', function(e) {
                e.preventDefault();
                $confirmationModal.modal('show');
            });

            $clearSubmit.on('click', function(e) {
                e.preventDefault();
                $clearForm.submit();
            });

            $('.clear-notification').on('click', function(e) {
                e.preventDefault();
                var $row = $(this).parent().parent();
                $.get("{{ url('notifications/delete') }}/" + $(this).data('id'), function(data) {
                    console.log($(this));
                    $row.fadeOut(300, function() {
                        $(this).remove();
                    });
                });
            });

        });
    </script>
@endsection
