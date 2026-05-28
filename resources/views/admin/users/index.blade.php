@extends('layouts.admin')

@section('title', 'Quản lý Khách hàng')

@section('breadcrumbs')
    <li class="breadcrumb-item active">Khách hàng</li>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold">Quản lý Khách hàng</h3>
            <p class="text-muted">Tổng cộng: <strong>{{ $users->total() }}</strong> khách hàng</p>
        </div>
    </div>
    
    <!-- Users Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            @if($users->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Tên khách hàng</th>
                                <th>Email</th>
                                <th>Vai trò</th>
                                <th>Trạng thái</th>
                                <th>Ngày tạo</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>
                                        <strong>{{ $user->name }}</strong>
                                    </td>
                                    <td>
                                        {{ $user->email }}
                                    </td>
                                    <td>
                                        @if($user->role == 'admin')
                                            <span class="badge bg-danger">
                                                <i class="bi bi-shield-lock"></i> Quản trị viên
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">
                                                <i class="bi bi-person"></i> Khách hàng
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($user->status == 'active')
                                            <span class="badge bg-success">
                                                <i class="bi bi-check-circle"></i> Hoạt động
                                            </span>
                                        @else
                                            <span class="badge bg-warning">
                                                <i class="bi bi-exclamation-circle"></i> Vô hiệu hóa
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $user->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-outline-warning">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            @if($user->id !== auth()->id())
                                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmDelete({{ $user->id }})">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                                <form id="delete-form-{{ $user->id }}" action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-inbox" style="font-size: 48px; color: #ccc;"></i>
                    <p class="text-muted mt-3">Chưa có khách hàng nào</p>
                </div>
            @endif
        </div>
    </div>
    
    <!-- Pagination -->
    @if($users->count() > 0)
        <div class="d-flex justify-content-center mt-4">
            {{ $users->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>

@push('scripts')
<script>
    function confirmDelete(id) {
        if(confirm('Bạn chắc chắn muốn xóa khách hàng này?')) {
            document.getElementById('delete-form-' + id).submit();
        }
    }
</script>
@endpush
@endsection
