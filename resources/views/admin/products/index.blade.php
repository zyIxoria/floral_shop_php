@extends('layouts.admin')

@section('title', 'Quản lý Sản phẩm')

@section('breadcrumbs')
    <li class="breadcrumb-item active">Sản phẩm</li>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold">Quản lý Sản phẩm</h3>
            <p class="text-muted">Tổng cộng: <strong>{{ $products->total() }}</strong> sản phẩm</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Thêm sản phẩm
        </a>
    </div>
    
    <!-- Products Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            @if($products->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Hình ảnh</th>
                                <th>Tên sản phẩm</th>
                                <th>Danh mục</th>
                                <th>Giá</th>
                                <th>Kho</th>
                                <th>Ngày tạo</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                                <tr>
                                    <td>
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" 
                                                 style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center" 
                                                 style="width: 50px; height: 50px; border-radius: 8px;">
                                                <i class="bi bi-image text-muted"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $product->name }}</strong>
                                        <br>
                                        <small class="text-muted">{{ Str::limit($product->description, 50) }}</small>
                                    </td>
                                    <td>{{ $product->category->name ?? 'N/A' }}</td>
                                    <td>
                                        <strong>{{ number_format($product->price, 0, ',', '.') }} ₫</strong>
                                        @if($product->sale_price)
                                            <br>
                                            <span class="badge bg-danger">-{{ round(((($product->price - $product->sale_price) / $product->price) * 100)) }}%</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($product->stock > 0)
                                            <span class="badge bg-success">{{ $product->stock }}</span>
                                        @else
                                            <span class="badge bg-danger">Hết hàng</span>
                                        @endif
                                    </td>
                                    <td>{{ $product->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-outline-warning">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmDelete({{ $product->id }})">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                        <form id="delete-form-{{ $product->id }}" action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display:none;">
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
                    <p class="text-muted mt-3">Chưa có sản phẩm nào</p>
                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary mt-2">
                        <i class="bi bi-plus-lg"></i> Tạo sản phẩm đầu tiên
                    </a>
                </div>
            @endif
        </div>
    </div>
    
    <!-- Pagination -->
    @if($products->count() > 0)
        <div class="d-flex justify-content-center mt-4">
            {{ $products->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>

@push('scripts')
<script>
    function confirmDelete(id) {
        if(confirm('Bạn chắc chắn muốn xóa sản phẩm này?')) {
            document.getElementById('delete-form-' + id).submit();
        }
    }
</script>
@endpush
@endsection