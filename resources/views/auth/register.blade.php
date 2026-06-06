{{-- resources/views/auth/register.blade.php --}}

@extends('layouts.app')

@section('title', 'Đăng Ký')

@section('content')

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-6">

            <div class="card border-0 shadow">

                <div class="card-body p-5">

                    <h3 class="fw-bold mb-4 text-center">
                        Tạo Tài Khoản
                    </h3>

                    <form method="POST"
                          action="{{ route('register') }}">

                        @csrf

                        <div class="mb-3">

                            <label>Họ Tên</label>

                            <input type="text"
                                   name="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name') }}">

                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                        </div>

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

                        <div class="mb-3">

                            <label>Mật Khẩu</label>

                            <input type="password"
                                   name="password"
                                   class="form-control @error('password') is-invalid @enderror">

                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                        </div>

                        <div class="mb-4">

                            <label>Xác Nhận Mật Khẩu</label>

                            <input type="password"
                                   name="password_confirmation"
                                   class="form-control">

                        </div>

                        <button class="btn btn-primary w-100">
                            Đăng Ký
                        </button>

                        <div class="mt-3 text-center">
                            <p>Đã có tài khoản? <a href="{{ route('login') }}">Đăng nhập ngay</a></p>
                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection