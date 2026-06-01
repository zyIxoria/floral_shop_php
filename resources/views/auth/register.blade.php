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
                                   class="form-control">

                        </div>

                        <div class="mb-3">

                            <label>Email</label>

                            <input type="email"
                                   name="email"
                                   class="form-control">

                        </div>

                        <div class="mb-3">

                            <label>Mật Khẩu</label>

                            <input type="password"
                                   name="password"
                                   class="form-control">

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

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection