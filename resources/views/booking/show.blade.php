@extends('layout.booking')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white text-center">
                        <h2 class="mb-0">Đặt Phòng - Phòng {{ $room->room_number }}</h2>
                    </div>
                    <div class="card-body">
                        <!-- Thông tin phòng -->
                        <div class="card mb-4">
                            <div class="card-body bg-light">
                                <h5 class="card-title text-primary">Thông Tin Phòng</h5>
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <p><strong>Loại:</strong> <span class="badge bg-secondary">{{ ucfirst($room->type) }}</span></p>
                                        <p><strong>Giá:</strong> <span class="badge bg-success">{{ number_format($room->price) }} VNĐ/đêm</span></p>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <p><strong>Khách sạn:</strong> <span class="text-success">{{ $room->hotel->name }}</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form đặt phòng -->
                        <form action="{{ route('booking.review', $room->id) }}" method="POST" id="bookingForm">
                            @csrf
                            <div class="card">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0">Thông Tin Đặt Phòng</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <!-- Ngày nhận phòng -->
                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label for="check_in" class="form-label">Ngày Nhận Phòng <span class="text-muted">(từ hôm nay)</span></label>
                                                <input type="date" name="check_in" class="form-control @error('check_in') is-invalid @enderror" 
                                                       required min="{{ now()->toDateString() }}" 
                                                       value="{{ old('check_in') }}">
                                                @error('check_in')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Ngày trả phòng -->
                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label for="check_out" class="form-label">Ngày Trả Phòng</label>
                                                <input type="date" name="check_out" class="form-control @error('check_out') is-invalid @enderror" 
                                                       required min="{{ now()->addDay()->toDateString() }}" 
                                                       value="{{ old('check_out') }}">
                                                @error('check_out')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Dịch vụ bổ sung -->
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="form-label">Dịch Vụ Bổ Sung <span class="text-muted">(Chọn tùy chọn)</span></label>
                                                <div class="list-group">
                                                    @foreach ($services as $service)
                                                        <label class="list-group-item d-flex justify-content-between align-items-center">
                                                            <div>
                                                                <input type="checkbox" name="services[]" value="{{ $service->id }}" 
                                                                       class="me-2"> {{ $service->name }}
                                                            </div>
                                                            <span class="badge bg-success">{{ number_format($service->price) }} VNĐ</span>
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Nút submit -->
                                    <div class="text-center mt-4">
                                        <button type="submit" class="btn btn-primary btn-lg px-5">
                                            <i class="fas fa-check-circle"></i> Xác Nhận Đặt Phòng
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
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
            font-size: 0.9rem;
        }
        .invalid-feedback {
            font-size: 0.875rem;
        }
        .btn-lg {
            font-size: 1.1rem;
            padding: 0.75rem 1.5rem;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script>
        document.getElementById('bookingForm').addEventListener('submit', function(event) {
            const checkIn = document.querySelector('input[name="check_in"]').value;
            const checkOut = document.querySelector('input[name="check_out"]').value;
            if (checkIn && checkOut && new Date(checkIn) >= new Date(checkOut)) {
                event.preventDefault();
                alert('Ngày trả phòng phải sau ngày nhận phòng!');
            }
        });
    </script>
@endpush