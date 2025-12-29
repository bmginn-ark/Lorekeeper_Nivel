@if (!$alias)
    <p>잘못된 SNS 계정 선택</p>
@elseif($alias->is_primary)
    <p>이미 대표 SNS 계정입니다.</p>
@elseif(!$alias->canMakePrimary)
    <p>대표 계정으로 설정할 수 없습니다.</p>
@else
    <p>이것은 <strong>{!! $alias->displayAlias !!}</strong>을(를) 대표 계정으로 설정합니다. 정말로 하시겠습니까?</p>
    @if (!$alias->is_visible)
        <p class="text-danger">이 계정은 현재 공개되지 않습니다. 대표 계정으로 설정하면 모든 사람이 볼 수 있게 됩니다!</p>
    @endif
    {!! Form::open(['url' => 'account/make-primary/' . $alias->id, 'class' => 'text-right']) !!}
    {!! Form::submit('대표 계정으로 설정', ['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}
@endif
