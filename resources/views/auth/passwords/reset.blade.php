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
                    <h5 class="card-title text-center pb-0 fs-4">{{ __('Reset Password') }}</h5>
                </div>
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <form class="row g-3 needs-validation" novalidate  method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                    <div class="col-12">
                      <label for="email" class="form-label">Email</label>
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
                      <label for="password" class="form-label">Password</label>
                      <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                      @error('password')
                            <div class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                      @enderror
                    </div>

                    <div class="col-12">
                      <label for="password_confirmation" class="form-label">Confirm Password</label>
                      <input id="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" required autocomplete="new-password">
                      
                    </div>

                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">{{ __('Reset Password') }}</button>
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

