@extends('account.layout')

@section('account-title')
    설정
@endsection

@section('account-content')
    {!! breadcrumbs(['My Account' => Auth::user()->url, 'Settings' => 'account/settings']) !!}

    <h1>설정</h1>


    <div class="card p-3 mb-2">
        <h3>프로필 이미지</h3>
        @if (Auth::user()->isStaff)
            <div class="alert alert-info">관리자용 - .GIF 아바타는 디렉토리에 임시 파일(예: php2471.tmp)을 남깁니다. 이러한 파일을 삭제하는 자동 일정이 있습니다.
            </div>
        @endif
        {!! Form::open(['url' => 'account/avatar', 'files' => true]) !!}
        <div class="custom-file mb-1">
            {!! Form::label('avatar', '프로필 이미지 업데이트', ['class' => 'custom-file-label']) !!}
            {!! Form::file('avatar', ['class' => 'custom-file-input']) !!}
        </div>
        <div class="text-right">
            {!! Form::submit('수정', ['class' => 'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
    </div>

    @if (config('lorekeeper.settings.allow_username_changes'))
        <div class="card p-3 mb-2">
            <h3>닉네임 변경</h3>
            @if (config('lorekeeper.settings.username_change_cooldown'))
                <div class="alert alert-info">
                    {{ config('lorekeeper.settings.username_change_cooldown') }} 일마다 닉네임을 변경할 수 있습니다.
                </div>
                @if (Auth::user()->logs()->where('type', 'Username Change')->orderBy('created_at', 'desc')->first())
                    <div class="alert alert-warning">
                        당신은 {{ Auth::user()->logs()->where('type', 'Username Change')->orderBy('created_at', 'desc')->first()->created_at->format('F jS, Y') }}에 닉네임을 변경했습니다.
                        <br />
                        <b>
                            {{ Auth::user()->logs()->where('type', 'Username Change')->orderBy('created_at', 'desc')->first()->created_at->addDays(config('lorekeeper.settings.username_change_cooldown'))->format('F jS, Y') }} 이후에 다시 닉네임을 변경할 수 있습니다.
                        </b>
                    </div>
                @endif
            @endif
            {!! Form::open(['url' => 'account/username']) !!}
            <div class="form-group row">
                <label class="col-md-2 col-form-label">닉네임</label>
                <div class="col-md-10">
                    {!! Form::text('username', Auth::user()->name, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="text-right">
                {!! Form::submit('수정', ['class' => 'btn btn-primary']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    @endif

    <div class="card p-3 mb-2">
        <h3>프로필</h3>
        {!! Form::open(['url' => 'account/profile']) !!}
        <div class="form-group">
            {!! Form::label('text', '프로필 텍스트') !!}
            {!! Form::textarea('text', Auth::user()->profile->text, ['class' => 'form-control wysiwyg']) !!}
        </div>
        <div class="text-right">
            {!! Form::submit('수정', ['class' => 'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
    </div>

    <div class="card p-3 mb-2">
        <h3>생일 공개 설정</h3>
        {!! Form::open(['url' => 'account/dob']) !!}
        <div class="form-group row">
            <label class="col-md-2 col-form-label">설정</label>
            <div class="col-md-10">
                {!! Form::select(
                    'birthday_setting',
                    ['0' => '0: 누구도 생일을 볼 수 없습니다.', '1' => '1: 회원들은 생일의 날짜와 달만 볼 수 있습니다.', '2' => '2: 누구나 생일의 날짜와 달을 볼 수 있습니다.', '3' => '3: 전체 날짜가 공개됩니다.'],
                    Auth::user()->settings->birthday_setting,
                    ['class' => 'form-control'],
                ) !!}
            </div>
        </div>
        <div class="text-right">
            {!! Form::submit('수정', ['class' => 'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
    </div>

    <div class="card p-3 mb-2">
        <h3>이메일 주소</h3>
        <p>이메일 주소를 변경하면 이메일 주소를 다시 확인해야 합니다.</p>
        {!! Form::open(['url' => 'account/email']) !!}
        <div class="form-group row">
            <label class="col-md-2 col-form-label">이메일 주소</label>
            <div class="col-md-10">
                {!! Form::text('email', Auth::user()->email, ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="text-right">
            {!! Form::submit('수정', ['class' => 'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
    </div>

    <div class="card p-3 mb-2">
        <h3>비밀번호 변경</h3>
        {!! Form::open(['url' => 'account/password']) !!}
        <div class="form-group row">
            <label class="col-md-2 col-form-label">기존 비밀번호</label>
            <div class="col-md-10">
                {!! Form::password('old_password', ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-2 col-form-label">새 비밀번호</label>
            <div class="col-md-10">
                {!! Form::password('new_password', ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-2 col-form-label">새 비밀번호 확인</label>
            <div class="col-md-10">
                {!! Form::password('new_password_confirmation', ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="text-right">
            {!! Form::submit('수정', ['class' => 'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
    </div>

    <div class="card p-3 mb-2">
        <h3>Two-Factor Authentication</h3>

        <p>Two-factor authentication acts as a second layer of protection for your account. It uses an app on your phone-- such as Google Authenticator-- and information provided by the site to generate a random code that changes frequently.</p>

        <div class="alert alert-info">
            Please note that two-factor authentication is only used when logging in directly to the site (with an email address and password), and not when logging in via an off-site account. If you log in using an off-site account, consider enabling
            two-factor authentication on that site instead!
        </div>

        @if (!isset(Auth::user()->two_factor_secret))
            <p>In order to enable two-factor authentication, you will need to scan a QR code with an authenticator app on your phone. Two-factor authentication will not be enabled until you do so and confirm by entering one of the codes provided by your
                authentication app.</p>
            {!! Form::open(['url' => 'account/two-factor/enable']) !!}
            <div class="text-right">
                {!! Form::submit('Enable', ['class' => 'btn btn-primary']) !!}
            </div>
            {!! Form::close() !!}
        @elseif(isset(Auth::user()->two_factor_secret))
            <p>Two-factor authentication is currently enabled.</p>

            <h4>Disable Two-Factor Authentication</h4>
            <p>To disable two-factor authentication, you must enter a code from your authenticator app.</p>
            {!! Form::open(['url' => 'account/two-factor/disable']) !!}
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Code</label>
                <div class="col-md-10">
                    {!! Form::text('code', null, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="text-right">
                {!! Form::submit('Disable', ['class' => 'btn btn-primary']) !!}
            </div>
            {!! Form::close() !!}
        @endif
    </div>
@endsection
