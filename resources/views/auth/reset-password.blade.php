{{-- resources/views/auth/reset-password.blade.php --}}

@extends('layouts.app')

@section('title', 'Đặt Lại Mật Khẩu')

@section('content')

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-5">

            <div class="card border-0 shadow">

                <div class="card-body p-5">

                    <h3 class="fw-bold mb-3 text-center">
                        Mật Khẩu Mới
                    </h3>
                    
                    <p class="text-muted text-center mb-4">
                        Đặt lại mật khẩu mới cho tài khoản email <strong>{{ session('reset_email') }}</strong>.
                    </p>

                    <form method="POST" action="{{ route('password.update') }}">

                        @csrf

                        <div class="mb-3">

                            <label>Mật Khẩu Mới</label>

                            <input type="password"
                                   name="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   required
                                   autofocus>

                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                        </div>

                        <div class="mb-4">

                            <label>Xác Nhận Mật Khẩu Mới</label>

                            <input type="password"
                                   name="password_confirmation"
                                   class="form-control"
                                   required>

                        </div>
                        
                        <div class="mb-4 text-muted small bg-light p-3 rounded">
                            <span class="d-block fw-bold mb-1"><i class="bi bi-info-circle-fill text-primary"></i> Yêu cầu mật khẩu:</span>
                            <ul class="mb-0 ps-3">
                                <li>Ít nhất 8 ký tự.</li>
                                <li>Bao gồm chữ hoa (A-Z) và chữ thường (a-z).</li>
                                <li>Bao gồm số (0-9) và ít nhất 1 ký tự đặc biệt (ví dụ: @, #, $, ...).</li>
                            </ul>
                        </div>

                        <button class="btn btn-primary w-100">
                            Cập Nhật Mật Khẩu
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
