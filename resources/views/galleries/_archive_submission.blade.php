@if ($submission)
    {!! Form::open(['url' => 'gallery/archive/' . $submission->id]) !!}

    <p>이 submission <strong>{{ $submission->title }}</strong>을(를) {{ $submission->is_visible ? '보관' : '보관 해제' }}하려고 합니다. 이 작업은 되돌릴 수 있으며, 언제든지 {{ $submission->is_visible ? '보관 해제' : '보관' }}할 수 있습니다. 제출물을 보관하면 다른 사용자에게는 보이지 않지만, 스태프에게는 보입니다.</p>
    <p>{{ $submission->is_visible ? '보관' : '보관 해제' }} 하시겠습니까? <strong>{{ $submission->title }}</strong>?</p>

    <div class="text-right">
        {!! Form::submit(($submission->is_visible ? '보관' : '보관 해제') . ' Submission', ['class' => 'btn btn-warning']) !!}
    </div>

    {!! Form::close() !!}
@else
    잘못된 접근입니다.
@endif
