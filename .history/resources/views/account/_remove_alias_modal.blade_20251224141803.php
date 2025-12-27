@if (!$alias)
    <p>잘못된 계정 선택.</p>
@elseif($alias->is_primary)
    <p>대표 계정은 지울 수 없습니다.</p>
@else
    <p>계정에서 SNS 연동 <strong>{!! $alias->displayAlias !!}</strong>이 제거됩니다. </p>
    <p>이것은 당신이 소유한 캐릭터에 영향을 미치지 않으며, {{config('lorekeeper.settings.site_name', 'Lorekeeper')}} 계정에 대한 아트/디자인 출처는 그대로 유지됩니다. 정말 하시겠습니까?</p>
    {!! Form::open(['url' => 'account/remove-alias/' . $alias->id, 'class' => 'text-right']) !!}
    {!! Form::submit('Remove Alias', ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
@endif
