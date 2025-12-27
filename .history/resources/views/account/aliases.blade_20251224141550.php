@extends('account.layout')

@section('account-title')
    링크
@endsection

@section('account-content')
    {!! breadcrumbs(['My Account' => Auth::user()->url, 'Aliases' => 'account/aliases']) !!}

    <h1>SNS</h1>

    <p>신원을 확인하려면 소유하고 있는 소셜 미디어 사이트의 계정을 인증할 수 있습니다. 이러한 소셜 미디어 계정에 크레딧된 캐릭터는 계정에 추가됩니다
    <p><strong>대표</strong> 계정이 연결되어 있어야 합니다. 이 계정은 프로필에 표시되며, 숨길 수 없거나 제거할 수 없습니다. 이 계정을 변경하려면 <strong>대표</strong> 상태를 다른 계정으로 변경해야 합니다. 
    대표로 연결되지 않은 계정은 언제든지 숨기거나 제거할 수 있습니다.</p>

    <h3>Linked Accounts</h3>
    <div class="mb-4 logs-table">
        <div class="logs-table-header">
            <div class="row">
                <div class="col-3">
                    <div class="logs-table-cell">계정</div>
                </div>
                <div class="col-3">
                    <div class="logs-table-cell">사이트</div>
                </div>
                <div class="col-1">
                    <div class="logs-table-cell"></div>
                </div>
                <div class="col-5">
                    <div class="logs-table-cell"></div>
                </div>
            </div>
        </div>
        <div class="logs-table-body">
            @foreach (Auth::user()->aliases()->orderBy('is_primary_alias', 'DESC')->orderBy('site')->get() as $alias)
                <div class="logs-table-row">
                    <div class="row flex-wrap">
                        <div class="col-3">
                            <div class="logs-table-cell"><a href="{{ $alias->url }}">{{ $alias->alias }}</a></div>
                        </div>
                        <div class="col-3">
                            <div class="logs-table-cell">
                                <i class="{{ $alias->config['icon'] }} fa-fw mr-1"></i> {{ config('lorekeeper.sites.' . $alias->site . '.full_name') }}
                            </div>
                        </div>
                        <div class="col-1">
                            <div class="logs-table-cell">
                                @if ($alias->is_primary_alias)
                                    <span class="badge badge-success">대표</span>
                                @endif
                                @if (!$alias->is_visible)
                                    <i class="fas fa-eye-slash" data-toggle="tooltip" title="This alias is hidden from public view."></i>
                                @endif
                            </div>
                        </div>
                        <div class="col-5 text-right">
                            <div class="logs-table-cell">
                                @if (!$alias->is_primary_alias || !config('lorekeeper.settings.require_alias'))
                                    @if (!$alias->is_primary_alias && config('lorekeeper.sites.' . $alias->site . '.primary_alias'))
                                        <a href="#" class="btn btn-outline-primary btn-sm make-primary" data-id="{{ $alias->id }}">대표로 설정</a>
                                    @endif
                                    <a href="#" class="btn btn-outline-secondary btn-sm hide-alias" data-id="{{ $alias->id }}">{{ $alias->is_visible ? '숨기기' : '보이기' }}</a>
                                    <a href="#" class="btn btn-outline-danger btn-sm remove-alias" data-id="{{ $alias->id }}">삭제</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <h3>Link New Account</h3>

    <p>Click on a button to link a social media account to your {{ config('lorekeeper.settings.site_name', 'Lorekeeper') }} account. You must be logged into the account you want to link to be able to continue.</p>
    <p>Accounts on sites that have the <strong>Primary</strong> label can be used as a primary account, but will not automatically switch your primary account once authenticated. Added accounts are not visible on your profile by default.</p>

    @foreach (config('lorekeeper.sites') as $provider => $site)
        @if (isset($site['auth']) && $site['auth'])
            <div class="d-flex mb-3">
                <div class="d-flex justify-content-end align-items-center"><i class="{{ $site['icon'] }} fa-fw mr-3"></i></div>
                <div class="">
                    <a href="{{ url('auth/redirect/' . $provider) }}" class="btn btn-outline-primary mr-3">Link <strong>{{ $site['full_name'] }}</strong> Account</a>
                    @if (isset($site['primary_alias']) && $site['primary_alias'])
                        <span class="badge badge-success">Primary</span>
                    @endif
                </div>
            </div>
        @endif
    @endforeach
@endsection
@section('scripts')
    <script>
        $('.make-primary').on('click', function(e) {
            e.preventDefault();
            loadModal("{{ url('account/make-primary') }}/" + $(this).data('id'), 'Make Primary Alias');
        });
        $('.hide-alias').on('click', function(e) {
            e.preventDefault();
            loadModal("{{ url('account/hide-alias') }}/" + $(this).data('id'), 'Alias Visibility');
        });
        $('.remove-alias').on('click', function(e) {
            e.preventDefault();
            loadModal("{{ url('account/remove-alias') }}/" + $(this).data('id'), 'Remove Alias');
        });
    </script>
@endsection
