@extends('layouts.admin')

@section('title', 'Báo cáo thống kê')

@section('breadcrumbs')
    <li class="breadcrumb-item active">Thống kê</li>
@endsection

@section('content')
<div class="container-fluid px-0">
    <!-- Header Page -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark">Báo cáo & Thống kê</h3>
            <p class="text-muted mb-0">Theo dõi doanh thu, số lượng đơn hàng và người dùng mới trong 30 ngày qua.</p>
        </div>
        <div class="bg-white px-3 py-2 rounded-3 shadow-sm border border-light">
            <span class="badge px-3 py-2 rounded-2" style="background-color: rgba(217, 126, 158, 0.1); color: #d97e9e !important; font-size: 0.9rem; font-weight: 600;">
                <i class="bi bi-calendar3 me-1"></i> 30 ngày qua
            </span>
        </div>
    </div>

    <!-- Summary Widgets Row -->
    <div class="row g-4 mb-4">
        <!-- Revenue Card -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100 position-relative" style="background: linear-gradient(135deg, #ffffff 0%, #fffbfd 100%);">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted text-uppercase fw-semibold" style="font-size: 0.8rem; letter-spacing: 0.5px;">Tổng doanh thu</span>
                            <h3 class="fw-bold mt-2 mb-0 text-dark">{{ number_format($totalRevenue, 0, ',', '.') }}đ</h3>
                        </div>
                        <div class="rounded-4 p-3 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #fce4ec 0%, #f8bbd0 100%); width: 56px; height: 56px;">
                            <i class="bi bi-currency-dollar" style="font-size: 24px; color: #d97e9e !important;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders Card -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100 position-relative" style="background: linear-gradient(135deg, #ffffff 0%, #f6fbfb 100%);">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted text-uppercase fw-semibold" style="font-size: 0.8rem; letter-spacing: 0.5px;">Tổng đơn hàng</span>
                            <h3 class="fw-bold mt-2 mb-0 text-dark">{{ number_format($totalOrders) }}</h3>
                        </div>
                        <div class="rounded-4 p-3 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #e0f2f1 0%, #b2dfdb 100%); width: 56px; height: 56px;">
                            <i class="bi bi-cart3" style="font-size: 24px; color: #008080 !important;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customers Card -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100 position-relative" style="background: linear-gradient(135deg, #ffffff 0%, #f8f6fc 100%);">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted text-uppercase fw-semibold" style="font-size: 0.8rem; letter-spacing: 0.5px;">Khách hàng</span>
                            <h3 class="fw-bold mt-2 mb-0 text-dark">{{ number_format($totalCustomers) }}</h3>
                        </div>
                        <div class="rounded-4 p-3 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #ede7f6 0%, #d1c4e9 100%); width: 56px; height: 56px;">
                            <i class="bi bi-people" style="font-size: 24px; color: #6f42c1 !important;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Card -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100 position-relative" style="background: linear-gradient(135deg, #ffffff 0%, #fffcf8 100%);">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted text-uppercase fw-semibold" style="font-size: 0.8rem; letter-spacing: 0.5px;">Sản phẩm</span>
                            <h3 class="fw-bold mt-2 mb-0 text-dark">{{ number_format($totalProducts) }}</h3>
                        </div>
                        <div class="rounded-4 p-3 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%); width: 56px; height: 56px;">
                            <i class="bi bi-flower2" style="font-size: 24px; color: #fd7e14 !important;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Chart: Revenue -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-white border-0 py-3 px-4 d-flex justify-content-between align-items-center">
            <div>
                <h5 class="fw-bold text-white mb-1" style="color: white !important;">Thống kê Doanh thu</h5>
                <p class="text-white-50 mb-0" style="font-size: 0.85rem; color: rgba(255, 255, 255, 0.8) !important;">Biểu đồ đường thể hiện doanh thu hàng ngày của các đơn hàng đã giao thành công.</p>
            </div>
        </div>
        <div class="card-body px-4 pb-4 pt-2">
            <div style="position: relative; height: 320px; width: 100%;">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Secondary Charts: Orders & Registrations -->
    <div class="row g-4 mb-4">
        <!-- Orders Chart -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 py-3 px-4">
                    <h5 class="fw-bold text-white mb-1" style="color: white !important;">Số lượng đơn đặt hàng</h5>
                    <p class="text-white-50 mb-0" style="font-size: 0.85rem; color: rgba(255, 255, 255, 0.8) !important;">Số lượng đơn đặt hàng mới phát sinh theo từng ngày.</p>
                </div>
                <div class="card-body px-4 pb-4 pt-2">
                    <div style="position: relative; height: 240px; width: 100%;">
                        <canvas id="ordersChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Registration Chart -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 py-3 px-4">
                    <h5 class="fw-bold text-white mb-1" style="color: white !important;">Tài khoản đăng ký mới</h5>
                    <p class="text-white-50 mb-0" style="font-size: 0.85rem; color: rgba(255, 255, 255, 0.8) !important;">Số lượng khách hàng đăng ký tài khoản mới hàng ngày.</p>
                </div>
                <div class="card-body px-4 pb-4 pt-2">
                    <div style="position: relative; height: 240px; width: 100%;">
                        <canvas id="usersChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Selling Products Table -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-0 py-3 px-4">
            <h5 class="fw-bold text-white mb-1" style="color: white !important;">Top 5 Sản phẩm Bán chạy</h5>
            <p class="text-white-50 mb-0" style="font-size: 0.85rem; color: rgba(255, 255, 255, 0.8) !important;">Những sản phẩm có số lượng bán ra cao nhất.</p>
        </div>
        <div class="card-body p-4">
            @if($topProducts->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-muted uppercase" style="font-size: 0.85rem;">
                            <tr>
                                <th class="py-3 px-4">Tên sản phẩm</th>
                                <th class="py-3 text-center">Số lượng đã bán</th>
                                <th class="py-3 text-end px-4">Tổng doanh thu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topProducts as $product)
                                <tr>
                                    <td class="py-3 px-4 fw-bold text-dark">{{ $product->name }}</td>
                                    <td class="py-3 text-center">
                                        <span class="badge rounded-pill px-3 py-2" style="background-color: rgba(0, 128, 128, 0.1); color: #008080; font-weight: 600;">
                                            {{ $product->total_quantity }} sản phẩm
                                        </span>
                                    </td>
                                    <td class="py-3 text-end px-4 fw-bold" style="color: #d97e9e;">
                                        {{ number_format($product->total_sales, 0, ',', '.') }}đ
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-bar-chart-line" style="font-size: 48px; color: #ccc;"></i>
                    <p class="text-muted mt-3">Chưa có dữ liệu bán hàng</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Labels (dates)
    const labels = {!! json_encode($dates) !!};

    // Helper to format currency
    function formatCurrency(value) {
        return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(value).replace('₫', 'đ');
    }

    // 1. Revenue Chart
    const ctxRevenue = document.getElementById('revenueChart').getContext('2d');
    
    // Create gradient
    const gradientRevenue = ctxRevenue.createLinearGradient(0, 0, 0, 300);
    gradientRevenue.addColorStop(0, 'rgba(217, 126, 158, 0.4)');
    gradientRevenue.addColorStop(1, 'rgba(217, 126, 158, 0.0)');

    new Chart(ctxRevenue, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Doanh thu (đ)',
                data: {!! json_encode($revenueData) !!},
                borderColor: '#d97e9e',
                borderWidth: 3,
                backgroundColor: gradientRevenue,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#d97e9e',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6,
                pointHoverBorderWidth: 3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#2c3e50',
                    titleColor: '#ffffff',
                    bodyColor: '#ffffff',
                    padding: 12,
                    cornerRadius: 8,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return ' Doanh thu: ' + formatCurrency(context.parsed.y);
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)',
                        drawBorder: false
                    },
                    ticks: {
                        callback: function(value) {
                            if (value >= 1000000) {
                                return (value / 1000000) + 'M';
                            }
                            if (value >= 1000) {
                                return (value / 1000) + 'k';
                            }
                            return value;
                        },
                        color: '#95a5a6',
                        font: {
                            family: 'Nunito',
                            size: 11
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: '#95a5a6',
                        font: {
                            family: 'Nunito',
                            size: 11
                        }
                    }
                }
            }
        }
    });

    // 2. Orders Chart
    const ctxOrders = document.getElementById('ordersChart').getContext('2d');
    
    const gradientOrders = ctxOrders.createLinearGradient(0, 0, 0, 200);
    gradientOrders.addColorStop(0, 'rgba(0, 128, 128, 0.3)');
    gradientOrders.addColorStop(1, 'rgba(0, 128, 128, 0.0)');

    new Chart(ctxOrders, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Đơn hàng',
                data: {!! json_encode($orderData) !!},
                borderColor: '#008080',
                borderWidth: 2.5,
                backgroundColor: gradientOrders,
                fill: true,
                tension: 0.35,
                pointBackgroundColor: '#008080',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 1.5,
                pointRadius: 3,
                pointHoverRadius: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#2c3e50',
                    padding: 10,
                    cornerRadius: 6,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return ' Số lượng: ' + context.parsed.y + ' đơn hàng';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)',
                        drawBorder: false
                    },
                    ticks: {
                        stepSize: 1,
                        precision: 0,
                        color: '#95a5a6',
                        font: {
                            size: 10
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: '#95a5a6',
                        font: {
                            size: 10
                        }
                    }
                }
            }
        }
    });

    // 3. Users Chart
    const ctxUsers = document.getElementById('usersChart').getContext('2d');
    
    const gradientUsers = ctxUsers.createLinearGradient(0, 0, 0, 200);
    gradientUsers.addColorStop(0, 'rgba(111, 66, 193, 0.3)');
    gradientUsers.addColorStop(1, 'rgba(111, 66, 193, 0.0)');

    new Chart(ctxUsers, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Tài khoản mới',
                data: {!! json_encode($userData) !!},
                borderColor: '#6f42c1',
                borderWidth: 2.5,
                backgroundColor: gradientUsers,
                fill: true,
                tension: 0.35,
                pointBackgroundColor: '#6f42c1',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 1.5,
                pointRadius: 3,
                pointHoverRadius: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#2c3e50',
                    padding: 10,
                    cornerRadius: 6,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return ' Đăng ký: ' + context.parsed.y + ' người dùng';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)',
                        drawBorder: false
                    },
                    ticks: {
                        stepSize: 1,
                        precision: 0,
                        color: '#95a5a6',
                        font: {
                            size: 10
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: '#95a5a6',
                        font: {
                            size: 10
                        }
                    }
                }
            }
        }
    });
});
</script>
@endpush
