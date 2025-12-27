@if ($submission)
    {!! Form::open(['url' => 'gallery/archive/' . $submission->id]) !!}

    <p>
        당신은 제출물 <strong>{{ $submission->title }}</strong>을(를)
        {{ $submission->is_visible ? '보관 처리' : '보관 해제' }}하려고 합니다.
        이 작업은 언제든지 되돌릴 수 있으며,
        이후에도 해당 제출물을 {{ $submission->is_visible ? '보관 해제' : '보관 처리' }}할 수 있습니다.
        제출물을 보관 처리하면 다른 사용자에게는 보이지 않게 되지만,
        스태프에게는 계속 표시됩니다.
    </p>

    <p>
        정말로 <strong>{{ $submission->title }}</strong>을(를)
        {{ $submission->is_visible ? '보관 처리' : '보관 해제' }}하시겠습니까?
    </p>

    <div class="text-right">
        {!! Form::submit(($submission->is_visible ? '제출물 보관' : '제출물 보관 해제'), ['class' => 'btn btn-warning']) !!}
    </div>

    {!! Form::close() !!}
@else
    잘못된 제출물이 선택되었습니다.
@endif
