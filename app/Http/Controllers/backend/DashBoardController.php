<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashBoardController extends Controller
{
    public function index(){

        return view('backend.dashboard.home');
    }
    public function OrderIndex()
    {
        $title = "Thống kê order";
        // 1. Doanh thu theo từng tháng trong năm hiện tại
        $monthlySales = Order::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, SUM(final_amount) as total_final_amount')
            ->where('status', 1) // giao hàng thành công
            ->where('payment_status', 1) // đã trả tiền
            ->groupBy('year', 'month')
            ->whereYear('created_at', date('Y')) // Chỉ lấy dữ liệu cho năm hiện tại
            ->orderBy('year')
            ->orderBy('month')
            ->get();
        // 2. Doanh thu theo từng năm
        $yearlySales = Order::selectRaw('YEAR(created_at) as year, SUM(final_amount) as total_final_amount')
            ->where('status', 1) // giao hàng thành công
            ->where('payment_status', 1) // đã trả tiền
            ->groupBy('year')
            ->orderBy('year')
            ->get();
        // 3. Tổng doanh thu toàn bộ
        $totalSales = Order::where('status', 1)
            ->where('payment_status', 1)
            ->sum('final_amount');
        // 4. Chuyển đổi dữ liệu thành mảng dùng cho view
        // Thống kê theo tháng
        $monthlyLabels = [];
        $monthlyData = [];
        foreach ($monthlySales as $sale) {
            $monthlyLabels[] = $sale->month . '-' . $sale->year; // Định dạng tháng-năm
            $monthlyData[] = $sale->total_final_amount;
        }
        // Thống kê theo năm
        $yearlyLabels = [];
        $yearlyData = [];
        foreach ($yearlySales as $sale) {
            $yearlyLabels[] = $sale->year;
            $yearlyData[] = $sale->total_final_amount;
        }
         // Truyền dữ liệu sang view
         return view('backend.dashboard.order', compact('monthlyLabels', 'monthlyData', 'yearlyLabels', 'yearlyData', 'totalSales','title'));
    }
    //thống kê số lượng đơn hàng đã hoàn thành trong tháng, năm
    //thống kê số lượng đơn hàng đã huỷ
    //thống kê số lượng đơn hàng đang giao
    //thống kê số lượng đơn hàng đã hoàn thành nhưng chưa thu tiền, thống kê số tiền

}
