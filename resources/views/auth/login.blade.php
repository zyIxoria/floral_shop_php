{{-- resources/views/auth/login.blade.php --}}

@extends('layouts.app')

@section('title', 'Đăng Nhập')

@section('content')

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-5">

            <div class="card border-0 shadow">

                <div class="card-body p-5">

                    <h3 class="fw-bold mb-4 text-center">
                        Đăng Nhập
                    </h3>

                    <form method="POST" action="{{ route('login') }}">

                        @csrf

                        <div class="mb-3">

                            <label>Email</label>

                            <input type="email"
                                   name="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}">

                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                        </div>

                        <div class="mb-4">

                            <label>Mật Khẩu</label>

                            <input type="password"
                                   name="password"
                                   class="form-control @error('password') is-invalid @enderror">

                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Ghi nhớ đăng nhập</label>
                        </div>

                        <button class="btn btn-primary w-100">
                            Đăng Nhập
                        </button>
                        
                        <div class="mt-3 text-center">
                            <p>Chưa có tài khoản? <a href="{{ route('register') }}">Đăng ký ngay</a></p>
                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
