@extends('layouts.app')

@section('content')
<style>
    .input-group-text {
        border-top-right-radius: 0px;
        border-bottom-right-radius: 0px;
    }
</style>
<div class="container">

    <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
    <div class="container">
        <div class="row justify-content-center">
        <div class="col-lg-5 col-md-6 d-flex flex-column align-items-center justify-content-center">

            <div class="d-flex justify-content-center py-4">
            <a href="index.html" class="logo d-flex align-items-center w-auto">                
                <span class="d-none d-lg-block">Punjab Horticulture</span>
            </a>
            </div><!-- End Logo -->

            <div class="card mb-3">

            <div class="card-body">

                <div class="pt-4 pb-2">
                    <div class="pb-2 text-center">
                        <img src="{{ asset('img/apple-icon-72x72.png')}}" alt="">
                    </div>
                <h5 class="card-title text-center pb-0 fs-4">{{ __('Admin Login') }}</h5>
                </div>
                <form class="row g-3 needs-validation" novalidate method="POST" action="{{ route('login') }}">
                @csrf
                    <div class="col-12">
                      <label for="email" class="form-label">Username</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <div class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Password</label>
                      <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                      @error('password')
                            <div class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                      @enderror
                    </div>

                    <div class="col-12">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="rememberMe">Remember me</label>
                      </div>
                    </div>
                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Login</button>
                    </div>
                    <div class="col-12">
                      <p class="small mb-0">
                            @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                        </p>
                    </div>
                  </form>
            </div>
            </div>

        </div>
        </div>
    </div>

    </section>

</div>
@endsection
