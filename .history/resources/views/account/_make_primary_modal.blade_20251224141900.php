@if (!$alias)
    <p>잘못된 SNS 계정 선택</p>
@elseif($alias->is_primary)
    <p>이미 대표 SNS 계정입니다.</p>
@elseif(!$alias->canMakePrimary)
    <p>대표 계정으로 설정할 수 없습니다.</p>
@else
    <p>This will make <strong>{!! $alias->displayAlias !!}</strong> your primary alias. Are you sure?</p>
    @if (!$alias->is_visible)
        <p class="text-danger">This alias is currently hidden from the public. Setting it as your primary alias will make it visible to everyone!</p>
    @endif
    {!! Form::open(['url' => 'account/make-primary/' . $alias->id, 'class' => 'text-right']) !!}
    {!! Form::submit('Make Primary Alias', ['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}
@endif
