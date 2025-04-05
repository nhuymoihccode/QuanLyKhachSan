@extends('layout.admin')
@section('title')
    Dashboard
@endsection
@section('content')
<div class="container-fluid">
    <!-- Content Row -->
    <div class="row">
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Doanh thu theo tháng</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($monthlyEarnings, 0, ',', '.') }} VND
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Daily) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Doanh thu theo ngày</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($dailyEarnings, 0, ',', '.') }} VND
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tasks Unpaid Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Bill Chưa Thanh Toán</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pendingBills }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Paid Bills Card Example - Đã sửa từ Pending Bills thành Paid Bills -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Bill Đã Thanh Toán</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $paidBills }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Area Chart (Bills by Date) -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Hóa đơn theo ngày (7 ngày qua)</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="myAreaChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pie Chart (Top Services) -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">5 dịch vụ hàng đầu</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="myPieChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        @if (!empty($serviceLabels) && !empty($serviceCounts))
                            @foreach (array_combine($serviceLabels, $serviceCounts) as $label => $count)
                                <span class="mr-2">
                                    <i class="fas fa-circle" style="color: {{ $loop->index == 0 ? '#4e73df' : ($loop->index == 1 ? '#1cc88a' : ($loop->index == 2 ? '#36b9cc' : ($loop->index == 3 ? '#f6c23e' : '#e74a3b'))) }}"></i>
                                    {{ $label }} ({{ $count }})
                                </span>
                            @endforeach
                        @else
                            <p class="text-muted">No service data available.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Revenue by Date -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Doanh thu theo ngày (7 ngày qua)</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="myRevenueChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Area Chart - Bills by Date
        const areaChartData = {
            labels: @json($dateLabels),
            datasets: [{
                label: 'Number of Bills',
                data: @json($billCounts),
                backgroundColor: 'rgba(78, 115, 223, 0.5)',
                borderColor: '#4e73df',
                borderWidth: 1,
                fill: true
            }]
        };

        new Chart(document.getElementById('myAreaChart'), {
            type: 'line',
            data: areaChartData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        display: true
                    }
                }
            }
        });

        // Area Chart - Revenue by Date
        const exchangeRate = 23000; // Tỷ giá: 1 USD = 23,000 VND
        let isUSD = false; // Biến để theo dõi trạng thái đơn vị tiền tệ
        const revenueData = @json($revenueCounts); // Dữ liệu gốc (VND)

        const revenueChartData = {
            labels: @json($dateLabels),
            datasets: [{
                label: 'Revenue (VND)',
                data: revenueData,
                backgroundColor: 'rgba(28, 200, 138, 0.5)',
                borderColor: '#1cc88a',
                borderWidth: 1,
                fill: true
            }]
        };

        const revenueChart = new Chart(document.getElementById('myRevenueChart'), {
            type: 'line',
            data: revenueChartData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                if (isUSD) {
                                    return value.toLocaleString('en-US') + ' USD';
                                }
                                return value.toLocaleString('vi-VN') + ' VND';
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        onClick: function(e, legendItem, legend) {
                            const dataset = revenueChart.data.datasets[legendItem.datasetIndex];
                            
                            // Khi nhấn vào legend, chuyển đổi đơn vị tiền tệ
                            isUSD = !isUSD;
                            if (isUSD) {
                                // Chuyển sang USD
                                dataset.label = 'Revenue (USD)';
                                dataset.data = revenueData.map(value => value / exchangeRate);
                            } else {
                                // Quay lại VND
                                dataset.label = 'Revenue (VND)';
                                dataset.data = revenueData;
                            }

                            // Cập nhật biểu đồ
                            revenueChart.update();
                        }
                    }
                }
            }
        });

        // Pie Chart - Top Services
        const pieChartData = {
            labels: @json($serviceLabels),
            datasets: [{
                data: @json($serviceCounts),
                backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b']
            }]
        };

        console.log('Pie Chart Data:', pieChartData);
        const pieChartCanvas = document.getElementById('myPieChart');
        if (pieChartCanvas && pieChartData.labels.length > 0) {
            new Chart(pieChartCanvas, {
                type: 'pie',
                data: pieChartData,
                options: {
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        } else {
            console.log('Pie Chart not rendered. Canvas:', pieChartCanvas, 'Data length:', pieChartData.labels.length);
        }
    </script>
@endpush