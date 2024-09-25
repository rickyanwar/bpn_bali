@extends('layouts.auth')
@php
    use App\Models\Utility;
    //  $logo=asset(Storage::url('uploads/logo/'));
    //$logo = \App\Models\Utility::get_file('uploads/logo');
    //$company_logo = Utility::getValByName('company_logo');
    //$settings = Utility::settings();
@endphp
@push('custom-scripts')
    @if (env('RECAPTCHA_MODULE') == 'on')
        {!! NoCaptcha::renderJs() !!}
    @endif
@endpush
@section('page-title')
    {{ __('Login') }}
@endsection

@section('auth-topbar')
    <li class="nav-item">
        <select class="btn btn-primary ms-2 me-2 language_option_bg text-center" style="text-align-last: center;"
            onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);"
            id="language">
            {{--  @foreach (Utility::languages() as $code => $language)
                <option class="text-center" @if ($lang == $code) selected @endif value="{{ route('login',$code) }}">{{ucfirst($language)}}</option>
            @endforeach  --}}
        </select>
    </li>
@endsection

@section('content')
    <div class="text-center">
        <img src="{{ asset('assets/images/logo-with-subtitle.png') }}" alt="{{ env('APP_NAME') }}" class="logo logo-lg" />
    </div>
    <div>
        <h2 class="mb-3 f-w-600">{{ __('Masuk') }}</h2>
    </div>
    <form action="{{ route('login') }}" method="POST" id="loginForm">
        @csrf
        <div class="">

            <div class="form-group mb-3">
                <label for="email" class="form-label">{{ __('Email') }}</label>
                <input class="form-control @error('email') is-invalid @enderror" id="email" type="email"
                    name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                    <div class="invalid-feedback" role="alert">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="password" class="form-label">{{ __('Password') }}</label>
                <input class="form-control @error('password') is-invalid @enderror" id="password" type="password"
                    name="password" required autocomplete="current-password">
                @error('password')
                    <div class="invalid-feedback" role="alert">{{ $message }}</div>
                @enderror
            </div>

            @if (env('RECAPTCHA_MODULE') == 'on')
                <div class="form-group mb-3">
                    {!! NoCaptcha::display() !!}
                    @error('g-recaptcha-response')
                        <span class="small text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            @endif
            <div class="form-group mb-4">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-xs">{{ __('Forgot Your Password?') }}</a>
                @endif
            </div>
            <div class="d-grid">
                <button type="submit" class="btn-login btn btn-primary btn-block mt-2 " style="border-radius: 20px"
                    id="login_button">{{ __('Masuk') }}</button>
            </div>

        </div>
    </form>
@endsection

<script src="{{ asset('js/jquery.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $("#loginForm").submit(function(e) {
            $("#login_button").attr("disabled", true);
            return true;
        });
    });
</script>
