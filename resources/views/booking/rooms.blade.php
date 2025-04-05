@extends('layout.booking')

@section('content')
<div class="container">
    <h1>Danh Sách Phòng Có Sẵn</h1>
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <div class="row">
        @forelse ($rooms as $room)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Phòng {{ $room->room_number }}</h5>
                        <p class="card-text">
                            Loại: {{ ucfirst($room->type) }} <br>
                            Giá: {{ number_format($room->price) }} VNĐ/đêm <br>
                            Khách sạn: {{ $room->hotel ? $room->hotel->name : 'Không xác định' }}
                        </p>
                        <a href="{{ route('booking.show', $room->id) }}" class="btn btn-primary">Đặt Phòng</a>
                    </div>
                </div>
            </div>
        @empty
            <p>Không có phòng nào khả dụng.</p>
        @endforelse
    </div>
</div>
@endsection