@extends('layout.booking')
@section('content')
    {{-- img --}}
    <header class="section__container header__container">
        <div class="header__image__container">
            <div class="header__content">
                <h1>Tận hưởng kỳ nghỉ mơ ước của bạn</h1>
                <p>Đặt phòng khách sạn.</p>
            </div>
        </div>
    </header>

    {{-- <!-- Booking Form -->
    <section class="section__container">
        <div class="container">
            <h2 class="text-center my-5">Đặt phòng ngay</h2>
            <div class="booking-form">
                <form>
                    <div class="row">
                        <div class="col-md-5 mb-3">
                            <label for="checkIn" class="form-label">Ngày Check In</label>
                            <input type="date" class="form-control" id="checkIn" required>
                        </div>
                        <div class="col-md-5 mb-3">
                            <label for="checkOut" class="form-label">Ngày Check Out</label>
                            <input type="date" class="form-control" id="checkOut" required>
                        </div>
                        <div class="col-md-2 mb-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">Đặt phòng</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section> --}}

    <!-- Reward Section -->
    <section class="reward__container">
        <p>Hơn 100 mã giảm giá</p>
        <h4>Tham gia phần thưởng và khám phá giảm giá tuyệt vời khi đặt phòng của bạn</h4>
        <a href="{{ route('promotions.index') }}" class="btn btn-primary">Tham gia ngay</a>
    </section>
@endsection