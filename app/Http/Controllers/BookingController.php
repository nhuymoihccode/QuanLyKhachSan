<?php

namespace App\Http\Controllers;

use App\Events\BillCreatedOrUpdated;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Bill;
use App\Models\Service;
use App\Models\Promotion;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        $orders = Order::with('room')->get(); // Assuming you have an Order model
        return view('booking.index', compact('orders')); // Pass orders to the view
    }

    // Bước 1: Hiển thị danh sách phòng
    public function rooms()
    {
        $rooms = Room::where('status', 'available')
            ->with('hotel')
            ->get();

        return view('booking.rooms', [
            'rooms' => $rooms
        ]);
    }

    // Bước 2: Hiển thị chi tiết phòng để đặt
    public function show($id)
    {
        $room = Room::with('hotel')->findOrFail($id);

        if ($room->status !== 'available') {
            return redirect()->route('booking.index')
                ->with('error', 'Phòng này đã được đặt!');
        }

        $services = Service::all(); // Lấy danh sách dịch vụ bổ sung

        return view('booking.show', [
            'room' => $room,
            'services' => $services
        ]);
    }

    // Bước 3 & 4: Xác nhận thông tin đặt phòng
    public function reviewBooking(Request $request, $id)
    {
        $request->validate([
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'services' => 'nullable|array',
        ]);

        $room = Room::findOrFail($id);

        // Tính tổng giá
        $days = (strtotime($request->check_out) - strtotime($request->check_in)) / (60 * 60 * 24);
        $base_price = $room->price * $days;

        $service_price = 0;
        $services = collect(); // Khởi tạo collection rỗng
        if ($request->services && is_array($request->services)) {
            $services = Service::whereIn('id', $request->services)->get();
            $service_price = $services->sum('price');
            \Log::info('Selected services in reviewBooking: ' . $services->pluck('name')->implode(', '));
        } else {
            \Log::info('No services selected in reviewBooking');
        }

        $total_price = $base_price + $service_price;

        // Lưu tạm thông tin vào session để xác nhận
        $bookingData = [
            'room_id' => $id,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'services' => $request->services ?? [],
            'total_price' => $total_price,
            'room' => $room,
        ];

        $request->session()->put('bookingData', $bookingData);

        return view('booking.review', [
            'booking' => $bookingData,
            'selected_services' => $services
        ]);
    }

    // Bước 5: Lưu thông tin đặt phòng
    public function storeOrder(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login.index')->with('error', 'Vui lòng đăng nhập để đặt phòng!');
        }

        $bookingData = $request->session()->get('bookingData');

        \Log::info('Booking data from session: ', $bookingData);

        if (!$bookingData || !isset($bookingData['room_id']) || !isset($bookingData['check_in']) || !isset($bookingData['check_out']) || !isset($bookingData['total_price'])) {
            \Log::error('Invalid booking data: ', $bookingData);
            $request->session()->forget('bookingData');
            return redirect()->route('booking.index')->with('error', 'Thông tin đặt phòng không hợp lệ!');
        }

        $room = Room::findOrFail($bookingData['room_id']);
        \Log::info('Room status: ' . $room->status);

        if ($room->status !== 'available') {
            \Log::error('Room not available: ' . $room->id);
            $request->session()->forget('bookingData');
            return redirect()->route('booking.index')->with('error', 'Phòng đã được đặt bởi người khác!');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:500',
        ]);

        try {
            $bill = DB::transaction(function () use ($request, $bookingData, $room) {
                // Tìm khách hàng hiện có với user_id và phone
                $existingCustomer = Customer::where('user_id', Auth::user()->id)
                    ->where('phone', $request->phone)
                    ->first();

                if ($existingCustomer) {
                    if ($existingCustomer->name !== $request->name) {
                        $customer = Customer::create([
                            'user_id' => Auth::user()->id,
                            'name' => $request->name,
                            'phone' => $request->phone,
                            'email' => $request->email ?? 'N/A',
                            'address' => $request->address ?? null,
                            'total_paid' => 0.00,
                        ]);
                        \Log::info('Created new customer with ID: ' . $customer->id . ' for user_id: ' . Auth::user()->id . ' with name: ' . $customer->name . ' due to name mismatch.');
                    } else {
                        $existingCustomer->update([
                            'name' => $request->name,
                            'email' => $request->email ?? 'N/A',
                            'address' => $request->address ?? null,
                        ]);
                        $customer = $existingCustomer;
                        \Log::info('Updated existing customer with ID: ' . $customer->id . ' for user_id: ' . Auth::user()->id . ' with name: ' . $customer->name);
                    }
                } else {
                    $customer = Customer::create([
                        'user_id' => Auth::user()->id,
                        'name' => $request->name,
                        'phone' => $request->phone,
                        'email' => $request->email ?? 'N/A',
                        'address' => $request->address ?? null,
                        'total_paid' => 0.00,
                    ]);
                    \Log::info('Created new customer with ID: ' . $customer->id . ' for user_id: ' . Auth::user()->id . ' with name: ' . $customer->name);
                }

                // Tạo đơn hàng
                $order = Order::create([
                    'customer_id' => $customer->id,
                    'user_id' => Auth::user()->id,
                    'room_id' => $bookingData['room_id'],
                    'check_in' => $bookingData['check_in'],
                    'check_out' => $bookingData['check_out'],
                    'total_price' => $bookingData['total_price'],
                    'status' => 'pending',
                    'customer_name' => $request->name,
                    'customer_phone' => $request->phone,
                    'customer_email' => $request->email,
                    'customer_address' => $request->address,
                ]);

                // Tạo hóa đơn
                $paymentDate = Carbon::now()->timezone('Asia/Ho_Chi_Minh');
                \Log::info('Creating bill with payment_date: ' . $paymentDate);

                $bill = Bill::create([
                    'order_id' => $order->id,
                    'amount' => $bookingData['total_price'],
                    'payment_date' => $paymentDate,
                    'status' => 'unpaid',
                    'customer_name' => $request->name,
                    'customer_phone' => $request->phone,
                    'customer_email' => $request->email,
                    'customer_address' => $request->address,
                ]);

                if (!empty($bookingData['services'])) {
                    $order->orderServices()->attach($bookingData['services']);
                    \Log::info('Attached services to order ' . $order->id . ': ' . json_encode($bookingData['services']));
                } else {
                    \Log::info('No services selected for order ' . $order->id);
                }

                \Log::info('Order and bill created successfully: ' . $order->id . ', ' . $bill->id);

                return $bill;
            });

            $request->session()->forget('bookingData');

            return redirect()->route('booking.payment', $bill->id)->with('success', 'Đặt phòng thành công! Vui lòng thanh toán.');
        } catch (\Exception $e) {
            \Log::error('Error in storeOrder: ' . $e->getMessage());
            $request->session()->forget('bookingData');
            return redirect()->route('booking.index')->with('error', 'Có lỗi xảy ra khi đặt phòng. Vui lòng thử lại! Error: ' . $e->getMessage());
        }
    }

    // Bước 6: Hiển thị trang thanh toán
    public function payment($bill_id)
    {
        $bill = Bill::with(['order.room', 'order.customer'])->findOrFail($bill_id);
        $userPromotions = Auth::user()->promotions; // Lấy danh sách mã khuyến mãi của người dùng

        return view('booking.payment', [
            'bill' => $bill,
            'userPromotions' => $userPromotions,
        ]);
    }

    // Xử lý thanh toán (có thể tích hợp cổng thanh toán)
    public function processPayment(Request $request, $bill_id)
    {
        $bill = Bill::findOrFail($bill_id);
        $order = $bill->order;
        $room = $order->room;
        $user = Auth::user();
        $appliedPromotion = null;

        try {
            DB::transaction(function () use ($bill, $order, $room, $appliedPromotion) {
                $bill->status = 'paid';
                $bill->payment_date = Carbon::now()->timezone('Asia/Ho_Chi_Minh');
                \Log::info('Updating payment_date for bill ' . $bill->id . ' to: ' . $bill->payment_date);
                $bill->save();

                $order->status = 'confirmed';
                $order->save();

                // Cập nhật trạng thái phòng thành occupied khi thanh toán thành công
                $room->status = 'occupied';
                $room->save();
                \Log::info('Room ' . $room->id . ' status updated to occupied after payment.');

                // Nếu có mã khuyến mãi, lưu thông tin (nếu cần)
                if ($appliedPromotion) {
                    $order->update(['promotion_id' => $appliedPromotion->id]);
                }

                event(new BillCreatedOrUpdated($bill));

                \Log::info('Payment processed successfully for bill: ' . $bill->id);
            });

            return redirect()->route('booking.history')
                ->with('success', 'Thanh toán thành công! Số tiền sau giảm giá: ' . number_format($bill->amount) . ' VNĐ');
        } catch (\Exception $e) {
            \Log::error('Error in processPayment: ' . $e->getMessage());

            // Khôi phục trạng thái phòng nếu thanh toán thất bại
            if ($bill->status !== 'paid') {
                $room->status = 'available';
                $room->save();
                \Log::info('Room ' . $room->id . ' status restored to available due to payment failure.');
            }

            return redirect()->route('booking.payment', $bill_id)
                ->with('error', 'Có lỗi xảy ra khi thanh toán. Vui lòng thử lại!');
        }
    }

    // Bước 7: Xem lịch sử thanh toán
    public function history()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login.index')->with('error', 'Vui lòng đăng nhập để xem lịch sử!');
        }

        $orders = Order::where('user_id', $user->id)
            ->with(['room', 'bills', 'customer', 'orderServices', 'promotion']) 
            ->orderBy('created_at', 'desc')
            ->get();
        if ($orders->isEmpty()) {
            \Log::info('No orders found for user ID: ' . $user->id);
        } else {
            \Log::info('Orders found: ' . $orders->count() . ' for user ID: ' . $user->id);
        }

        return view('booking.history', [
            'orders' => $orders
        ]);
    }
}