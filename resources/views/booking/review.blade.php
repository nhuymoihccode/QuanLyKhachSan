@extends('layout.booking')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-info text-white text-center" style="background-color: #17a2b8;">
                        <h2 class="mb-0 fs-3">Xác Nhận Đặt Phòng</h2>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <!-- Cột trái: Thông Tin Đặt Phòng -->
                            <div class="col-12 col-md-6">
                                <div class="card h-100">
                                    <div class="card-header bg-light text-primary">
                                        <h5 class="mb-0 fs-5">Thông Tin Đặt Phòng</h5>
                                    </div>
                                    <div class="card-body">
                                        <p class="fs-6"><strong>Phòng:</strong> <span class="badge bg-secondary">{{ $booking['room']->room_number }}</span></p>
                                        <p class="fs-6"><strong>Ngày Nhận:</strong> <span class="text-info">{{ $booking['check_in'] }}</span></p>
                                        <p class="fs-6"><strong>Ngày Trả:</strong> <span class="text-info">{{ $booking['check_out'] }}</span></p>
                                        <p class="fs-6"><strong>Dịch Vụ:</strong>
                                            @if (!empty($selected_services))
                                                <ul class="list-group list-group-flush">
                                                    @foreach ($selected_services as $service)
                                                        <li class="list-group-item d-flex justify-content-between align-items-center fs-6">
                                                            {{ $service->name }}
                                                            <span class="badge bg-success">{{ number_format($service->price) }} VNĐ</span>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <span class="text-muted fs-6">Không có dịch vụ bổ sung</span>
                                            @endif
                                        </p>
                                        <p class="fs-6"><strong>Tổng Giá:</strong> <span class="badge bg-success">{{ number_format($booking['total_price']) }} VNĐ</span></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Cột phải: Thông Tin Khách Hàng -->
                            <div class="col-12 col-md-6">
                                <div class="card h-100">
                                    <div class="card-header bg-light text-primary">
                                        <h5 class="mb-0 fs-5">Thông Tin Liên Hệ</h5>
                                    </div>
                                    <div class="card-body">
                                        <form action="{{ route('booking.store') }}" method="POST" id="bookingConfirmForm">
                                            @csrf
                                            <div class="form-group mb-3">
                                                <label for="name" class="form-label fs-6">Họ Tên <span class="text-muted">(Bắt buộc)</span></label>
                                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                                       value="{{ Auth::user()->name ?? old('name') }}" required>
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="phone" class="form-label fs-6">Số Điện Thoại <span class="text-muted">(Bắt buộc)</span></label>
                                                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                                                       value="{{ Auth::user()->phone ?? old('phone') }}" required>
                                                @error('phone')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="email" class="form-label fs-6">Email</label>
                                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                                       value="{{ Auth::user()->email ?? old('email') }}">
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-4">
                                                <label for="address" class="form-label fs-6">Địa Chỉ</label>
                                                <textarea name="address" class="form-control @error('address') is-invalid @enderror">{{ Auth::user()->address ?? old('address') }}</textarea>
                                                @error('address')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="text-center">
                                                <button type="submit" class="btn btn-info btn-lg px-5" style="background-color: #17a2b8; border-color: #17a2b8;">
                                                     Xác Nhận và Đặt Phòng
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
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
            font-size: 1rem !important; /* Tăng kích thước chữ cơ bản */
        }
        .fs-5 {
            font-size: 1.25rem !important; /* Tăng kích thước tiêu đề */
        }
        .fs-3 {
            font-size: 1.75rem !important; /* Tăng kích thước tiêu đề chính */
        }
    </style>
@endpush

@push('scripts')
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
@endpush