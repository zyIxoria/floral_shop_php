@extends('layouts.admin')

@section('title', 'Quản lý Danh mục')

@section('breadcrumbs')
    <li class="breadcrumb-item active">Danh mục</li>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold">Quản lý Danh mục</h3>
            <p class="text-muted">Tổng cộng: <strong>{{ $categories->total() }}</strong> danh mục</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Thêm danh mục
        </a>
    </div>
    
    <!-- Categories Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            @if($categories->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Hình ảnh</th>
                                <th>Tên danh mục</th>
                                <th>Slug</th>
                                <th>Mô tả</th>
                                <th>Sản phẩm</th>
                                <th>Ngày tạo</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                                <tr>
                                    <td>
                                        @if($category->image)
                                            <img src="{{ $category->image_url }}" alt="{{ $category->name }}" 
                                                 style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center" 
                                                 style="width: 50px; height: 50px; border-radius: 8px;">
                                                <i class="bi bi-image text-muted"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $category->name }}</strong>
                                    </td>
                                    <td>
                                        <code>{{ $category->slug }}</code>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ Str::limit($category->description, 50) }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $category->products_count ?? 0 }}</span>
                                    </td>
                                    <td>{{ $category->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-sm btn-outline-warning">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmDelete({{ $category->id }})">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                        <form id="delete-form-{{ $category->id }}" action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" style="display:none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-inbox" style="font-size: 48px; color: #ccc;"></i>
                    <p class="text-muted mt-3">Chưa có danh mục nào</p>
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary mt-2">
                        <i class="bi bi-plus-lg"></i> Tạo danh mục đầu tiên
                    </a>
                </div>
            @endif
        </div>
    </div>
    
    <!-- Pagination -->
    @if($categories->count() > 0)
        <div class="d-flex justify-content-center mt-4">
            {{ $categories->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>

@push('scripts')
<script>
    function confirmDelete(id) {
        if(confirm('Bạn chắc chắn muốn xóa danh mục này?')) {
            document.getElementById('delete-form-' + id).submit();
        }
    }
</script>
@endpush
@endsection
