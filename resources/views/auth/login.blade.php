@extends('layouts.auth') 
{{-- Baris ini menunjukkan bahwa tampilan ini memperluas tata letak 'layouts.auth', yang berarti akan menggunakan struktur yang didefinisikan dalam file tata letak tersebut. --}}

@section('auth') 
{{-- Bagian ini mendefinisikan bagian 'auth' dari tata letak, yang akan berisi formulir login. --}}

<div id="app">
    <section class="section">
        <div class="container mt-5">
            <div class="row">
                {{-- Pusatkan kartu login di dalam layar --}}
                <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">

                    <div class="card card-primary">
                        <div class="card-header text-center d-flex flex-column align-items-center">
                            {{-- Tampilkan gambar logo di tengah bagian atas kartu --}}
                            <img src="assets/img/logo peraduan.jpeg" alt="Logo" class="rounded-circle mr-1 mx-auto d-block" style="width: 100px; height: 100px;">
                            {{-- Tampilkan nama aplikasi di bawah logo --}}
                            <h4 class="mt-2">PERADUAN</h4>
                        </div>

                        <div class="card-body">
                            {{-- Formulir login dimulai di sini --}}
                            <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate="">
                                @csrf
                                {{-- Token CSRF untuk keamanan --}}

                                {{-- Kolom input Email --}}
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input id="email" type="email" class="form-control" name="email" tabindex="1" required autofocus>
                                    <div class="invalid-feedback">Masukkan Email</div>
                                    {{-- Umpan balik validasi untuk kolom email --}}
                                </div>

                                {{-- Kolom input Password --}}
                                <div class="form-group">
                                    <div class="d-block">
                                        <label for="password" class="control-label">Password</label>
                                    </div>
                                    <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                                    <div class="invalid-feedback">Masukkan Password</div>
                                    {{-- Umpan balik validasi untuk kolom password --}}
                                </div>

                                {{-- Kotak centang Remember Me --}}
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me">
                                        <label class="custom-control-label" for="remember-me">Remember Me</label>
                                    </div>
                                </div>

                                {{-- Tombol Login --}}
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                        Login
                                    </button>
                                </div>
                            </form>
                            {{-- Formulir login berakhir di sini --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

{{-- Bagian di bawah ini dikomentari dan tampaknya merupakan formulir login lama atau alternatif. Ini tidak akan dirender di tampilan. --}}
{{-- 
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
--}}
