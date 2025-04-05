<?php

namespace App\Listeners;

use App\Events\BillCreatedOrUpdated;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateCustomerTotalPaid
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(BillCreatedOrUpdated $event): void
    {
        $bill = $event->bill;

        // Chỉ cập nhật total_paid khi hóa đơn đã được thanh toán (status = 'paid')
        if ($bill->status === 'paid') {
            // Tìm order liên quan để lấy customer_id
            $order = Order::find($bill->order_id);
            if ($order) {
                // Tìm khách hàng
                $customer = Customer::find($order->customer_id);
                if ($customer) {
                    // Cập nhật total_paid
                    $customer->total_paid += $bill->amount;
                    $customer->save();
                }
            }
        }
    }
}