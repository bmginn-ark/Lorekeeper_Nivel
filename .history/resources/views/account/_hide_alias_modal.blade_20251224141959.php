@if (!$alias)
    <p>잘못된 SNS 계정 선택</p>
@elseif($alias->is_primary)
    <p>이 계정은 대표 계정이므로 숨길 수 없습니다.</p>
@else
    <p>이것은 {{ !$alias->is_visible ? '공개' : '숨김' }}할 SNS 계정 <strong>{!! $alias->displayAlias !!}</strong>입니다. </p>
    @if ($alias->is_visible)
        <p>로그아웃한 사용자와 로그인한 사용자는 이 SNS계정이 본 계정과 연관되어 있는지 확인할 수 없습니다. 직원은 볼 수 있습니다.</p>
    @else
        <p>Logged-out users and logged-in users will be able to view a list of your aliases from your profile page.</p>
    @endif
    {!! Form::open(['url' => 'account/hide-alias/' . $alias->id, 'class' => 'text-right']) !!}
    {!! Form::submit((!$alias->is_visible ? 'Unhide' : 'Hide') . ' Alias', ['class' => 'btn btn-secondary']) !!}
    {!! Form::close() !!}
@endif
