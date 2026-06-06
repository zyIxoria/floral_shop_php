@extends('layouts.admin')

@section('title', 'Thêm Khách hàng')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Khách hàng</a></li>
    <li class="breadcrumb-item active">Thêm mới</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 fw-bold">Tạo Khách hàng mới</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.users.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">Họ và tên <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" placeholder="Nhập họ và tên">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" placeholder="Nhập địa chỉ email">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label fw-bold">Số điện thoại</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" name="phone" value="{{ old('phone') }}" placeholder="Nhập số điện thoại">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label fw-bold">Vai trò <span class="text-danger">*</span></label>
                            <select class="form-select @error('role') is-invalid @enderror" id="role" name="role">
                                <option value="customer" {{ old('role') == 'customer' ? 'selected' : '' }}>Khách hàng</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Quản trị viên</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label fw-bold">Trạng thái <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                                <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Hoạt động</option>
                                <option value="blocked" {{ old('status') == 'blocked' ? 'selected' : '' }}>Vô hiệu hóa</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold">Mật khẩu <span class="text-danger">*</span></label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" placeholder="Nhập mật khẩu (tối thiểu 8 ký tự)">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label fw-bold">Xác nhận mật khẩu <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" 
                                   id="password_confirmation" name="password_confirmation" placeholder="Nhập lại mật khẩu">
                        </div>
                        
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg"></i> Tạo khách hàng
                            </button>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x-lg"></i> Hủy
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection