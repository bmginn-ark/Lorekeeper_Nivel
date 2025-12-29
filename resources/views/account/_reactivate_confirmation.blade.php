@if (Auth::user()->is_deactivated)
    <p>이것은 귀하의 계정을 재활성화하여 사이트 기능을 다시 사용할 수 있게 합니다. 정말로 하시겠습니까?</p>
    {!! Form::open(['url' => 'reactivate']) !!}
    <div class="text-right">
        {!! Form::submit('Reactivate', ['class' => 'btn btn-success']) !!}
    </div>
    {!! Form::close() !!}
@else
    <p>귀하의 계정은 비활성화되어 있지 않습니다.</p>
@endif
