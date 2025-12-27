@extends('layouts.app')

@section('title')
    로그인
@endsection

@section('content')
    @if ($userCount)
        @if (session('status'))
            <div class="alert alert-success mb-4">
                {{ session('status') }}
            </div>
        @endif

        <div class="row">
            <div class="col-md-6 offset-md-4">
                <h1>로그인</h1>
            </div>
        </div>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            @honeypot

            <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('이메일 주소') }}</label>

                <div class="col-md-6">
                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>
                    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('비밀번호') }}</label>

                <div class="col-md-6">
                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                    @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-6 offset-md-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                        <label class="form-check-label" for="remember">
                            {{ __('로그인 상태 유지') }}
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('로그인') }}
                    </button>

                    @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('비밀번호 찾기') }}
                        </a>
                    @endif
                </div>
            </div>
        </form>

        @if ($altLogins)
            <h3 class="text-center mt-5 pt-2">SNS 로그인</h3>
            @foreach ($altLogins as $provider => $site)
                @if (isset($site['login']) && $site['login'])
                    <div class="text-center pt-3 w-75 m-auto">
                        <a href="{{ url('/login/redirect/' . $provider) }}" class="btn btn-primary text-white w-100"><i class="{{ $site['icon'] }} mr-2"></i> Login With {{ ucfirst($provider) }}</a>
                    </div>
                @endif
            @endforeach
        @endif
    @else
        @include('auth._require_setup')
    @endif
@endsection
