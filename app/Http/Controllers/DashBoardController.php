<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Service;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashBoardController extends Controller
{
    public function index()
    {
        // Tổng số tiền đã thanh toán trong tháng này (Earnings Monthly)
        $monthlyEarnings = Bill::where('status', 'paid')
            ->whereMonth('payment_date', Carbon::now()->month)
            ->whereYear('payment_date', Carbon::now()->year)
            ->sum('amount');

        // Tổng số tiền đã thanh toán trong ngày hôm nay (Earnings Daily)
        $dailyEarnings = Bill::where('status', 'paid')
            ->whereDate('payment_date', Carbon::now()->toDateString())
            ->sum('amount');

        // Số lượng hóa đơn chưa thanh toán (Pending Bills)
        $pendingBills = Bill::where('status', 'unpaid')->count();

        // Số lượng hóa đơn đã thanh toán (Paid Bills) - Thêm mới
        $paidBills = Bill::where('status', 'paid')->count();

        // Số lượng hóa đơn theo ngày (7 ngày gần nhất)
        $billsByDate = Bill::selectRaw('DATE(payment_date) as date, COUNT(*) as count')
            ->where('payment_date', '>=', Carbon::now()->subDays(6))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->date => $item->count];
            })->toArray();

        // Đảm bảo có dữ liệu cho 7 ngày, nếu không có thì mặc định là 0
        $dateLabels = [];
        $billCounts = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->toDateString();
            $dateLabels[] = $date;
            $billCounts[] = $billsByDate[$date] ?? 0;
        }

        // Doanh thu mỗi ngày (7 ngày gần nhất)
        $revenueByDate = Bill::selectRaw('DATE(payment_date) as date, SUM(amount) as total')
            ->where('status', 'paid')
            ->where('payment_date', '>=', Carbon::now()->subDays(6))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->date => $item->total];
            })->toArray();

        // Đảm bảo có dữ liệu doanh thu cho 7 ngày, nếu không có thì mặc định là 0
        $revenueCounts = [];
        foreach ($dateLabels as $date) {
            $revenueCounts[] = $revenueByDate[$date] ?? 0;
        }

        // Dịch vụ được chọn nhiều nhất
        $topServices = Service::leftJoin('order_service', 'services.id', '=', 'order_service.service_id')
            ->selectRaw('services.name, COUNT(order_service.service_id) as count')
            ->groupBy('services.id', 'services.name')
            ->orderByDesc('count')
            ->limit(5)
            ->get();

        $serviceLabels = $topServices->pluck('name')->toArray();
        $serviceCounts = $topServices->pluck('count')->toArray();

        return view('dashboard.index', [
            'monthlyEarnings' => $monthlyEarnings,
            'dailyEarnings' => $dailyEarnings,
            'pendingBills' => $pendingBills,
            'paidBills' => $paidBills, // Thêm mới
            'dateLabels' => $dateLabels,
            'billCounts' => $billCounts,
            'revenueCounts' => $revenueCounts,
            'serviceLabels' => $serviceLabels,
            'serviceCounts' => $serviceCounts,
        ]);
    }
}