@extends('layouts.app')

@section('title', 'Chỉnh Sửa Hồ Sơ')

@section('content')
<div class="container-fluid px-4 py-5">
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <div class="card border-0 shadow mb-4">
                <div class="card-body p-4">
                    <h4 class="fw-bold mb-4">Chỉnh Sửa Hồ Sơ</h4>

                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="mb-3">
                            <label class="form-label fw-bold">Họ Tên</label>
                            <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                            @error('name')<span class="text-danger small">{{ $message }}</span>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                            @error('email')<span class="text-danger small">{{ $message }}</span>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Số Điện Thoại</label>
                            <input type="tel" name="phone" class="form-control" value="{{ $user->phone }}">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Địa Chỉ</label>
                            <textarea name="address" class="form-control" rows="3">{{ $user->address }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Cập Nhật</button>
                    </form>
                </div>
            </div>

            <div class="card border-0 shadow">
                <div class="card-body p-4">
                    <h4 class="fw-bold mb-4">Thay Đổi Mật Khẩu</h4>

                    <form action="{{ route('profile.changePassword') }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="mb-3">
                            <label class="form-label fw-bold">Mật Khẩu Hiện Tại</label>
                            <input type="password" name="current_password" class="form-control" required>
                            @error('current_password')<span class="text-danger small">{{ $message }}</span>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Mật Khẩu Mới</label>
                            <input type="password" name="password" class="form-control" required>
                            @error('password')<span class="text-danger small">{{ $message }}</span>@enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Xác Nhận Mật Khẩu</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Thay Đổi Mật Khẩu</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection