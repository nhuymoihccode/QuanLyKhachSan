<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Room;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['customer', 'room', 'orderServices', 'user'])->paginate(5);
        return view('order.index', compact('orders'));
    }

    public function create()
    {
        $customers = Customer::all();
        $rooms = Room::where('status', 'available')->get();
        $services = Service::all();
        return view('order.create', compact('customers', 'rooms', 'services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'room_id' => 'required|exists:rooms,id',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'total_price' => 'required|numeric',
            'status' => 'required|in:pending,confirmed,canceled',
            'service_id' => 'array',
            'service_id.*' => 'exists:services,id',
        ]);

        $order = Order::create([
            'customer_id' => $request->customer_id,
            'room_id' => $request->room_id,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'total_price' => $request->total_price,
            'status' => $request->status,
        ]);

        // Gán dịch vụ nếu có
        if ($request->has('service_id')) {
            $order->orderService()->sync($request->service_id);
        }

        // Cập nhật trạng thái phòng
        $room = Room::find($request->room_id);
        if ($room) {
            $room->status = 'occupied';
            $room->save();
        }

        return redirect()->route('order.index')->with('success', 'Đơn hàng đã được tạo thành công!');
    }

    public function edit($id)
    {
        $order = Order::with(['customer', 'room', 'orderService'])->findOrFail($id);
        $customers = Customer::all();
        $rooms = Room::all();
        $services = Service::all();
        return view('order.edit', compact('order', 'customers', 'rooms', 'services'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'room_id' => 'required|exists:rooms,id',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'total_price' => 'required|numeric',
            'status' => 'required|in:pending,confirmed,canceled',
            'service_id' => 'array',
            'service_id.*' => 'exists:services,id',
        ]);

        $order = Order::findOrFail($id);
        $order->update([
            'customer_id' => $request->customer_id,
            'room_id' => $request->room_id,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'total_price' => $request->total_price,
            'status' => $request->status,
        ]);

        // Cập nhật dịch vụ
        if ($request->has('service_id')) {
            $order->orderService()->sync($request->service_id);
        }

        return redirect()->route('order.index')->with('success', 'Đơn hàng đã được cập nhật thành công!');
    }

    public function delete($id)
    {
        $order = Order::find($id);
        if ($order) {
            $order->delete();
            return redirect()->route('order.index')->with('success', 'Đơn hàng đã được xóa thành công!');
        }

        return redirect()->route('order.index')->with('error', 'Đơn hàng không tồn tại!');
    }
}