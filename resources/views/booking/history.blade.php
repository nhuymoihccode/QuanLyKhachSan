@extends('layout.booking')

@section('title', 'Lịch sử đặt phòng')

@section('content')
    <div class="container mt-5">
        <h1 class="mb-4 text-center">Lịch sử đặt phòng</h1>

        @if ($orders->isEmpty())
            <div class="alert alert-info text-center">
                Bạn chưa có đơn đặt phòng nào.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover shadow-sm">
                    <thead class="table-primary">
                        <tr>
                            <th scope="col">Mã đơn</th>
                            <th scope="col">Phòng</th>
                            <th scope="col">Check-in</th>
                            <th scope="col">Check-out</th>
                            <th scope="col">Tổng tiền</th>
                            <th scope="col">Ngày thanh toán</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Hóa đơn</th>
                            <th scope="col">Chi tiết</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->room ? $order->room->room_number : 'N/A' }}</td>
                                <td>{{ $order->check_in ?? 'N/A' }}</td>
                                <td>{{ $order->check_out ?? 'N/A' }}</td>
                                <td>{{ $order->total_price ? number_format($order->total_price) . ' VNĐ' : 'N/A' }}</td>
                                <td>
                                    @if ($order->bills->isNotEmpty() && $order->bills->first()->payment_date)
                                        {{ Carbon\Carbon::parse($order->bills->first()->payment_date)->format('Y-m-d') }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if ($order->bills->isNotEmpty())
                                        <span class="badge {{ $order->bills->first()->status == 'paid' ? 'bg-success' : 'bg-danger' }}">
                                            {{ $order->bills->first()->status }}
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">Chưa có hóa đơn</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($order->bills->isNotEmpty())
                                        Mã {{ $order->bills->first()->id }}: {{ number_format($order->bills->first()->amount) }} VNĐ
                                        <!-- Thêm nút thanh toán nếu trạng thái là unpaid -->
                                        @if ($order->bills->first()->status == 'unpaid')
                                            <form action="{{ route('booking.process', $order->bills->first()->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-info btn-sm ms-2">
                                                    <i class="fas fa-credit-card me-1"></i> Thanh Toán
                                                </button>
                                            </form>
                                        @endif
                                    @else
                                        Chưa có hóa đơn
                                    @endif
                                </td>
                                <td>
                                    <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#billDetailModal{{ $order->id }}">
                                        Xem chi tiết
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Modal cho mỗi Order -->
            @foreach ($orders as $order)
                <div class="modal fade" id="billDetailModal{{ $order->id }}" tabindex="-1"
                    aria-labelledby="billDetailModalLabel{{ $order->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="billDetailModalLabel{{ $order->id }}">Chi tiết hóa đơn - Mã đơn:
                                    {{ $order->id }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <p><strong>Khách hàng:</strong>
                                            @if ($order->bills->isNotEmpty() && $order->bills->first()->customer_name)
                                                {{ $order->bills->first()->customer_name }}
                                            @else
                                                {{ $order->customer->name ?? 'N/A' }}
                                            @endif
                                        </p>
                                        <p><strong>Số điện thoại:</strong>
                                            @if ($order->bills->isNotEmpty() && $order->bills->first()->customer_phone)
                                                {{ $order->bills->first()->customer_phone }}
                                            @else
                                                {{ $order->customer->phone ?? 'N/A' }}
                                            @endif
                                        </p>
                                        <p><strong>Địa chỉ:</strong>
                                            @if ($order->bills->isNotEmpty() && $order->bills->first()->customer_address)
                                                {{ $order->bills->first()->customer_address }}
                                            @else
                                                {{ $order->customer->address ?? 'N/A' }}
                                            @endif
                                        </p>
                                        <p><strong>Phòng:</strong> {{ $order->room->room_number ?? 'N/A' }}</p>
                                        <p><strong>Check-in:</strong> {{ $order->check_in ?? 'N/A' }}</p>
                                        <p><strong>Check-out:</strong> {{ $order->check_out ?? 'N/A' }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Tổng tiền:</strong>
                                            {{ $order->total_price ? number_format($order->total_price) . ' VNĐ' : 'N/A' }}</p>
                                        <p><strong>Trạng thái đơn:</strong>
                                            <span
                                                class="badge {{ $order->status == 'confirmed' ? 'bg-success' : ($order->status == 'pending' ? 'bg-warning' : 'bg-danger') }}">
                                                {{ $order->status ?? 'N/A' }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                                <h6 class="border-bottom pb-2 mb-3">Dịch vụ đã chọn</h6>
                                @if ($order->orderServices && $order->orderServices->isNotEmpty())
                                    <ul class="list-group">
                                        @foreach ($order->orderServices as $service)
                                            <li class="list-group-item">
                                                {{ $service->name ?? 'N/A' }} -
                                                {{ $service->price ? number_format($service->price) . ' VNĐ' : 'N/A' }}
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-muted">Không có dịch vụ nào được chọn.</p>
                                @endif
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
@endsection