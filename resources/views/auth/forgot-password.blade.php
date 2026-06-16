{{-- resources/views/auth/forgot-password.blade.php --}}

@extends('layouts.app')

@section('title', 'Quên Mật Khẩu')

@section('content')

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-5">

            <div class="card border-0 shadow">

                <div class="card-body p-5">

                    <h3 class="fw-bold mb-3 text-center">
                        Quên Mật Khẩu
                    </h3>
                    
                    <p class="text-muted text-center mb-4">
                        Nhập địa chỉ email đăng ký tài khoản của bạn để nhận mã xác nhận đổi lại mật khẩu.
                    </p>

                    <form method="POST" action="{{ route('password.email') }}">

                        @csrf

                        <div class="mb-4">

                            <label>Địa Chỉ Email</label>

                            <input type="email"
                                   name="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}"
                                   required
                                   autofocus>

                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                        </div>

                        <button class="btn btn-primary w-100 mb-3">
                            Gửi Mã Xác Nhận
                        </button>
                        
                        <div class="text-center">
                            <a href="{{ route('login') }}" class="text-decoration-none text-muted small">
                                <i class="bi bi-arrow-left"></i> Quay lại Đăng nhập
                            </a>
                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
