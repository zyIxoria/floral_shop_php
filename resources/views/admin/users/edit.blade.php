@extends('layouts.admin')

@section('title', 'Chỉnh sửa Khách hàng')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Khách hàng</a></li>
    <li class="breadcrumb-item active">Chỉnh sửa</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 fw-bold">Chỉnh sửa Khách hàng</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <!-- User Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">Tên khách hàng <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $user->name) }}" placeholder="Nhập tên khách hàng">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email', $user->email) }}" placeholder="Nhập email">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Phone (Optional) -->
                        <div class="mb-3">
                            <label for="phone" class="form-label fw-bold">Số điện thoại</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" name="phone" value="{{ old('phone', $user->phone ?? '') }}" placeholder="Nhập số điện thoại">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Role -->
                        <div class="mb-3">
                            <label for="role" class="form-label fw-bold">Vai trò <span class="text-danger">*</span></label>
                            <select class="form-select @error('role') is-invalid @enderror" id="role" name="role">
                                <option value="customer" {{ old('role', $user->role) == 'customer' ? 'selected' : '' }}>
                                    Khách hàng
                                </option>
                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>
                                    Quản trị viên
                                </option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Status -->
                        <div class="mb-3">
                            <label for="status" class="form-label fw-bold">Trạng thái <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                                <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>
                                    Hoạt động
                                </option>
                                <option value="inactive" {{ old('status', $user->status) == 'inactive' ? 'selected' : '' }}>
                                    Vô hiệu hóa
                                </option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Password (Optional) -->
                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold">Mật khẩu mới (tùy chọn)</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" placeholder="Để trống nếu không muốn thay đổi">
                            <small class="text-muted">Nhập mật khẩu mới nếu muốn cập nhật</small>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg"></i> Cập nhật khách hàng
                            </button>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x-lg"></i> Hủy
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Info Card -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-light">
                <div class="card-body">
                    <h6 class="fw-bold mb-3"><i class="bi bi-info-circle"></i> Thông tin</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><strong>Ngày tạo:</strong><br>{{ $user->created_at->format('d/m/Y H:i') }}</li>
                        <li class="mb-2"><strong>Lần cập nhật:</strong><br>{{ $user->updated_at->format('d/m/Y H:i') }}</li>
                        <li class="mb-2"><strong>Vai trò hiện tại:</strong><br>
                            @if($user->role == 'admin')
                                <span class="badge bg-danger">Quản trị viên</span>
                            @else
                                <span class="badge bg-secondary">Khách hàng</span>
                            @endif
                        </li>
                        <li class="mb-2"><strong>Trạng thái:</strong><br>
                            @if($user->status == 'active')
                                <span class="badge bg-success">Hoạt động</span>
                            @else
                                <span class="badge bg-warning">Vô hiệu hóa</span>
                            @endif
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
