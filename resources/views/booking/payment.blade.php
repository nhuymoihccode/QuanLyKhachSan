@extends('layout.booking')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-sm border-0 bg-white">
                    <div class="card-header bg-info text-white text-center" style="background-color: #17a2b8;">
                        <h2 class="mb-0 fs-3">Thanh Toán</h2>
                    </div>
                    <div class="card-body">
                        <!-- Thông báo thành công -->
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <!-- Thông tin thanh toán -->
                        <div class="row g-4">
                            <!-- Cột trái: Thông Tin Đặt Phòng -->
                            <div class="col-12 col-md-6">
                                <div class="card h-100">
                                    <div class="card-header bg-light text-primary">
                                        <h5 class="mb-0 fs-5">Thông Tin Đặt Phòng</h5>
                                    </div>
                                    <div class="card-body">
                                        <p class="fs-6"><strong>Mã Đặt Phòng:</strong> <span class="badge bg-secondary">{{ $bill->order->id }}</span></p>
                                        <p class="fs-6"><strong>Phòng:</strong> <span class="badge bg-secondary">{{ $bill->order->room->room_number }}</span></p>
                                        <p class="fs-6"><strong>Ngày Nhận:</strong> <span class="text-info">{{ $bill->order->check_in ?? 'N/A' }}</span></p>
                                        <p class="fs-6"><strong>Ngày Trả:</strong> <span class="text-info">{{ $bill->order->check_out ?? 'N/A' }}</span></p>
                                        <p class="fs-6"><strong>Dịch Vụ:</strong>
                                            @if ($bill->order->orderServices && $bill->order->orderServices->isNotEmpty())
                                                <ul class="list-group list-group-flush">
                                                    @foreach ($bill->order->orderServices as $service)
                                                        <li class="list-group-item d-flex justify-content-between align-items-center fs-6">
                                                            {{ $service->name ?? 'N/A' }}
                                                            <span class="badge bg-success">{{ number_format($service->price) }} VNĐ</span>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <span class="text-muted fs-6">Không có dịch vụ bổ sung</span>
                                            @endif
                                        </p>
                                        <p class="fs-6"><strong>Tổng Tiền:</strong> <span class="badge bg-success">{{ number_format($bill->amount) }} VNĐ</span></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Cột phải: Thông Tin Khách Hàng -->
                            <div class="col-12 col-md-6">
                                <div class="card h-100">
                                    <div class="card-header bg-light text-primary">
                                        <h5 class="mb-0 fs-5">Thông Tin Khách Hàng</h5>
                                    </div>
                                    <div class="card-body">
                                        <p class="fs-6"><strong>Họ Tên:</strong> {{ $bill->order->customer->name ?? 'N/A' }}</p>
                                        <p class="fs-6"><strong>Số Điện Thoại:</strong> {{ $bill->order->customer->phone ?? 'N/A' }}</p>
                                        <p class="fs-6"><strong>Email:</strong> {{ $bill->order->customer->email ?? 'N/A' }}</p>
                                        <p class="fs-6"><strong>Địa Chỉ:</strong> {{ $bill->order->customer->address ?? 'N/A' }}</p>
                                        <p class="fs-6"><strong>Trạng Thái:</strong>
                                            <span class="badge {{ $bill->status == 'paid' ? 'bg-success' : 'bg-warning' }}">
                                                {{ ucfirst($bill->status) }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Nút thanh toán hoặc thông báo đã thanh toán -->
                        <div class="text-center mt-4">
                            @if ($bill->status == 'unpaid')
                                <form action="{{ route('booking.process', $bill->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-info btn-lg px-5" style="background-color: #17a2b8; border-color: #17a2b8;">
                                        <i class="fas fa-credit-card me-2"></i> Thanh Toán Ngay
                                    </button>
                                </form>
                            @else
                                <p class="text-success fs-5"><i class="fas fa-check-circle me-2"></i> Đã thanh toán thành công!</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .card-header {
            border-radius: 0.25rem 0.25rem 0 0;
        }
        .list-group-item {
            border: none;
            transition: all 0.3s ease;
        }
        .list-group-item:hover {
            background-color: #f8f9fa;
            transform: translateY(-2px);
        }
        .badge {
            font-size: 1rem;
        }
        .invalid-feedback {
            font-size: 0.875rem;
        }
        .btn-lg {
            font-size: 1.1rem;
            padding: 0.75rem 1.5rem;
        }
        .fs-6 {
            font-size: 1rem !important;
        }
        .fs-5 {
            font-size: 1.25rem !important;
        }
        .fs-3 {
            font-size: 1.75rem !important;
        }
        .alert-success {
            border-left: 5px solid #28a745;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
@endpush