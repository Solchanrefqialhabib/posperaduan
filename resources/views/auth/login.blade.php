@extends('layouts.auth')

@section('auth')
<div id="app">
    <section class="section">
        <div class="container mt-5">
            <div class="row">
                <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                    <div class="card card-primary">
                        <div class="card-header text-center d-flex flex-column align-items-center">
                            <img src="assets/img/logo peraduan.jpeg" alt="Logo" class="rounded-circle mr-1 mx-auto d-block" style="width: 100px; height: 100px;">
                            <h4 class="mt-2">PERADUAN</h4>
                        </div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate>
                            @if ($errors->has('email') || $errors->has('password'))
                                    <div class="alert alert-danger">
                                        <strong>Email atau password yang Anda masukkan salah.</strong>
                                    </div>
                                @endif
                                @csrf

                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" tabindex="1" required autofocus>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="password" class="control-label">Password</label>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" tabindex="2" required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me">
                                        <label class="custom-control-label" for="remember-me">Remember Me</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                        Login
                                    </button>
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
