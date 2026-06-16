{{-- resources/views/auth/verify-code.blade.php --}}

@extends('layouts.app')

@section('title', 'Xác Minh Mã OTP')

@section('content')

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-5">

            <div class="card border-0 shadow">

                <div class="card-body p-5">

                    <h3 class="fw-bold mb-3 text-center">
                        Nhập Mã Xác Nhận
                    </h3>
                    
                    <p class="text-muted text-center mb-4">
                        Hệ thống đã gửi một mã xác nhận gồm 6 chữ số đến email <strong>{{ session('reset_email') }}</strong>. Vui lòng nhập mã bên dưới để tiếp tục.
                    </p>

                    <form method="POST" action="{{ route('password.verify') }}">

                        @csrf

                        <div class="mb-4 text-center">

                            <label class="d-block mb-3 fw-bold">Mã OTP (6 chữ số)</label>

                            <input type="text"
                                   name="code"
                                   class="form-control text-center fs-4 fw-bold @error('code') is-invalid @enderror"
                                   placeholder="------"
                                   style="letter-spacing: 0.5rem;"
                                   maxlength="6"
                                   required
                                   autofocus>

                            @error('code')
                                <div class="invalid-feedback text-center">{{ $message }}</div>
                            @enderror

                        </div>

                        <button class="btn btn-primary w-100 mb-3">
                            Xác Minh Mã
                        </button>
                        
                        <div class="text-center">
                            <a href="{{ route('password.request') }}" class="text-decoration-none text-muted small">
                                <i class="bi bi-arrow-left"></i> Gửi lại mã mới
                            </a>
                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
