<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Bảng hotels (Khách sạn)
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('address');
            $table->string('phone', 20)->nullable();
            $table->string('email', 100)->nullable()->unique();
            $table->timestamps();
        });

        // Bảng customers (Khách hàng)
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('name', 255);
            $table->string('phone', 20);
            $table->string('email', 100)->nullable();
            $table->text('address')->nullable();
            $table->integer('total_paid')->default(0);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });

        // Bảng staffs (Nhân viên)
        Schema::create('staffs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')->constrained('hotels')->onDelete('cascade');
            $table->string('name');
            $table->string('position');
            $table->string('phone', 20)->nullable();
            $table->string('email', 100)->nullable()->unique();
            $table->date('started_at');
            $table->integer('salary')->default(0);
            $table->timestamps();
        });

        // Bảng rooms (Phòng)
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')->constrained('hotels')->onDelete('cascade');
            $table->string('room_number')->unique(); // Thêm unique
            $table->enum('type', ['single', 'double', 'suite'])->default('single');
            $table->integer('price')->default(0);
            $table->enum('status', ['available', 'occupied'])->default('available');
            $table->index('status');
            $table->timestamps();
        });

        // Bảng devices (Thiết bị)
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type')->nullable();
            $table->integer('quantity'); // Sửa từ string thành integer
            $table->enum('status', ['in_stock', 'out_of_stock'])->default('in_stock');
            $table->index('status');
            $table->timestamps();
        });

        // Bảng services (Dịch vụ)
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('price');
            $table->timestamps();
        });

        // Bảng shifts (Ca làm)
        Schema::create('shifts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('staff_id')->constrained('staffs')->onDelete('cascade');
            $table->time('start_time');
            $table->time('end_time');
            $table->date('date');
            $table->index('date');
            $table->timestamps();
        });
        

        // Bảng promotions (Khuyến mãi)
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable()->unique();
            $table->string('name')->nullable(); // Thêm tên khuyến mãi
            $table->decimal('discount_percentage',5,2)->unsigned();
            $table->decimal('min_amount', 15, 2)->default(0.00);
            $table->integer('quantity')->unsigned()->default(0);
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamps();
        });

        // Bảng orders (Đặt phòng) - Đặt trước order_service
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('room_id')->nullable()->constrained('rooms')->onDelete('set null');
            $table->date('check_in');
            $table->date('check_out');
            $table->integer('total_price')->nullable();
            $table->unsignedBigInteger('promotion_id')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('customer_phone', 20)->nullable();
            $table->string('customer_email', 100)->nullable();
            $table->text('customer_address')->nullable();
            $table->enum('status', ['pending', 'confirmed', 'canceled'])->default('pending');
            $table->index('status');
            $table->foreign('promotion_id')->references('id')->on('promotions')->onDelete('set null');
            $table->timestamps();
        });

        // Bảng order_service (Mối quan hệ nhiều-nhiều giữa orders và services) - Đặt sau orders
        Schema::create('order_service', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade');
            $table->timestamps();
        });

        // Bảng bills (Hóa đơn)
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->integer('amount')->default(0);
            $table->string('customer_name')->nullable();
            $table->string('customer_phone', 20)->nullable();
            $table->string('customer_email', 100)->nullable();
            $table->text('customer_address')->nullable();
            $table->timestamp('payment_date')->nullable()->useCurrent();
            $table->enum('status', ['paid', 'unpaid'])->default('unpaid');
            $table->index('status');
            $table->timestamps();
        });

        Schema::create('user_promotions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('promotion_id')->constrained()->onDelete('cascade');
            $table->timestamp('claimed_at')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('order_service');
        Schema::dropIfExists('bills');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('shifts');
        Schema::dropIfExists('devices');
        Schema::dropIfExists('rooms');
        Schema::dropIfExists('staffs');
        Schema::dropIfExists('customers');
        Schema::dropIfExists('hotels');
        Schema::dropIfExists('promotions');
        Schema::dropIfExists('services');
    }
};