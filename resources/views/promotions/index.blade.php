@extends('layout.booking')

@section('title', 'Danh sách khuyến mãi')

@section('content')
    <div class="container mt-5">
        <h1 class="mb-4 text-center">Danh sách khuyến mãi</h1>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($promotions->isEmpty())
            <div class="alert alert-info text-center">
                Không có mã khuyến mãi nào hiện tại.
            </div>
        @else
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @foreach ($promotions as $promotion)
                    <div class="col">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">{{ $promotion->name }}</h5>
                                <p class="card-text"><strong>Mã:</strong> {{ $promotion->code }}</p>
                                <p class="card-text"><strong>Giảm giá:</strong> {{ $promotion->discount_percentage }}%</p>
                                <p class="card-text"><strong>Số lượng còn lại:</strong> {{ $promotion->quantity }}</p>
                                <p class="card-text"><strong>Tối thiểu:</strong> {{ number_format($promotion->min_amount) }} VNĐ</p>
                                <p class="card-text"><strong>Ngày bắt đầu:</strong> {{ $promotion->start_date }}</p>
                                <p class="card-text"><strong>Ngày kết thúc:</strong> {{ $promotion->end_date }}</p>
                                <form action="{{ route('promotions.claim', $promotion->id) }}" method="POST" class="mt-3">
                                    @csrf
                                    @if ($promotion->quantity > 0 && now()->between($promotion->start_date, $promotion->end_date))
                                        <button type="submit" class="btn btn-info btn-sm">
                                            <i class="fas fa-gift me-1"></i> Nhận mã
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-secondary btn-sm" disabled>
                                            <i class="fas fa-times me-1"></i> Mã đã hết
                                        </button>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
@endpush