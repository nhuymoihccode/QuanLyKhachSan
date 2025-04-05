<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Order;
use Illuminate\Http\Request;

class BillController extends Controller
{
    public function index()
    {
        $bills = Bill::with(['order', 'order.customer', 'order.room', 'order.orderServices'])->paginate(5);
        return view('bill.index', compact('bills'));
    }
    

    public function search(Request $request)
    {
        $searchTerm = $request->input('search');

        $bills = Bill::with(['order', 'order.customer', 'order.room', 'order.orderServices'])
            ->whereHas('order.customer', function ($query) use ($searchTerm) {
                $query->where('name', 'like', '%' . $searchTerm . '%');
            })->orWhereHas('order.room', function ($query) use ($searchTerm) {
                $query->where('room_number', 'like', '%' . $searchTerm . '%');
            })->orWhereHas('order.orderServices', function ($query) use ($searchTerm) {
                $query->where('name', 'like', '%' . $searchTerm . '%');
            })->orWhere('amount', 'like', '%' . $searchTerm . '%')
            ->orWhere('customer_name', 'like', '%' . $searchTerm . '%')
            ->orWhere('customer_phone', 'like', '%' . $searchTerm . '%')
            ->orWhere('customer_email', 'like', '%' . $searchTerm . '%')
            ->orWhere('status', 'like', '%' . $searchTerm . '%')
            ->paginate(5);

        return view('bill.index', compact('bills'));
    }

    public function create()
    {
        $orders = Order::with('customer')->get();
        return view('bill.create', compact('orders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'status' => 'required|in:paid,unpaid',
            'customer_name' => 'nullable|string|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'customer_email' => 'nullable|email|max:100',
            'customer_address' => 'nullable|string',
        ]);

        Bill::create([
            'order_id' => $request->order_id,
            'amount' => $request->amount,
            'payment_date' => $request->payment_date,
            'status' => $request->status,
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'customer_email' => $request->customer_email,
            'customer_address' => $request->customer_address,
        ]);

        return redirect()->route('bill.index')->with('success', 'Hóa đơn đã được tạo thành công!');
    }

    public function edit($id)
    {
        $bill = Bill::with(['order', 'order.customer', 'order.room', 'order.orderServices'])->findOrFail($id);
        $orders = Order::with('customer')->get();
        return view('bill.edit', compact('bill', 'orders'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'status' => 'required|in:paid,unpaid',
            'customer_name' => 'nullable|string|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'customer_email' => 'nullable|email|max:100',
            'customer_address' => 'nullable|string',
        ]);

        $bill = Bill::findOrFail($id);
        $bill->update([
            'order_id' => $request->order_id,
            'amount' => $request->amount,
            'payment_date' => $request->payment_date,
            'status' => $request->status,
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'customer_email' => $request->customer_email,
            'customer_address' => $request->customer_address,
        ]);

        return redirect()->route('bill.index')->with('success', 'Hóa đơn đã được cập nhật thành công!');
    }

    public function delete($id)
    {
        $bill = Bill::find($id);
        if ($bill) {
            $bill->delete();
            return redirect()->route('bill.index')->with('success', 'Hóa đơn đã được xóa thành công!');
        }

        return redirect()->route('bill.index')->with('error', 'Hóa đơn không tồn tại!');
    }
}