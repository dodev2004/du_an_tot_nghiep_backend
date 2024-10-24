<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashBoardController extends Controller
{
    public function index()
    {

        return view('backend.dashboard.home');
    }
    public function OrderIndex()
    {
        $title = "Thống kê order";

        // 1. Tổng doanh thu trong toàn bộ thời gian (chỉ tính các đơn hàng đã thanh toán)
        $totalRevenue = Order::whereIn('status', [Order::STATUS_COMPLETED])
            ->where('payment_status', Order::PAYMENT_COMPLETED)
            ->sum('final_amount');

        // 2. Tổng số đơn hàng mới trong toàn bộ thời gian
        $totalNewOrders = Order::where('status', Order::STATUS_PENDING)
            ->count();

        // 3. Tổng số đơn hàng đã hoàn thành trong toàn bộ thời gian
        $totalCompletedOrders = Order::where('status', Order::STATUS_COMPLETED)
            ->count();

        // 4. Tổng số đơn hàng bị hủy trong toàn bộ thời gian
        $totalCanceledOrders = Order::where('status', Order::STATUS_CANCELLED)
            ->count();

        // 5. Tổng số tiền của đơn hàng đã hoàn thành nhưng chưa thu tiền
        $totalUnpaidAmount = Order::where('status', Order::STATUS_COMPLETED)
            ->where('payment_status', Order::PAYMENT_PENDING)
            ->sum('final_amount');

        // 6. Số lượng đơn hàng đang giao
        $totalShippingOrders = Order::where('status', Order::STATUS_SHIPPED)
            ->count();

        // 7. Doanh thu theo từng tháng trong năm hiện tại, sử dụng biểu đồ line
        $salesMonthly = Order::selectRaw('MONTH(created_at) as month, SUM(final_amount) as total')
            ->whereYear('created_at', date('Y'))
            ->whereIn('status', [Order::STATUS_COMPLETED])
            ->where('payment_status', Order::PAYMENT_COMPLETED)
            ->groupByRaw('MONTH(created_at)')
            ->orderBy('month')
            ->get();

        // 8. Doanh thu theo từng năm sử dụng biểu đồ line
        $salesYearly = Order::selectRaw('YEAR(created_at) as year, SUM(final_amount) as total')
            ->whereIn('status', [Order::STATUS_COMPLETED])
            ->where('payment_status', Order::PAYMENT_COMPLETED)
            ->groupByRaw('YEAR(created_at)')
            ->orderBy('year')
            ->get();

        // 9. Số lượng đơn hàng đã hoàn thành và đã hủy theo từng tháng trong năm sử dụng biểu đồ line vẽ 2 cái vào trong 1 biểu đồ
        $ordersMonthly = Order::selectRaw('MONTH(created_at) as month,
            SUM(CASE WHEN status = ' . Order::STATUS_COMPLETED . ' THEN 1 ELSE 0 END) as completed,
            SUM(CASE WHEN status = ' . Order::STATUS_CANCELLED . ' THEN 1 ELSE 0 END) as canceled')
            ->whereYear('created_at', date('Y'))
            ->groupByRaw('MONTH(created_at)')
            ->orderBy('month')
            ->get();

        // 10. Số lượng đơn hàng đã hoàn thành và đã hủy trong năm hiện tại sử dụng biểu đồ line vẽ 2 cái vào trong 1 biểu đồ
        $ordersYearly = Order::selectRaw('YEAR(created_at) as year,
            SUM(CASE WHEN status = ' . Order::STATUS_COMPLETED . ' THEN 1 ELSE 0 END) as completed,
            SUM(CASE WHEN status = ' . Order::STATUS_CANCELLED . ' THEN 1 ELSE 0 END) as canceled')
            ->whereYear('created_at', date('Y'))
            ->groupByRaw('YEAR(created_at)')
            ->orderBy('year')
            ->get();

        // 11. Số lượng đơn hàng đã hoàn thành và chưa thu tiền theo từng tháng trong năm sử dụng biểu đồ line vẽ 2 cái vào trong 1 biểu đồ
        $paymentsMonthly = Order::selectRaw('MONTH(created_at) as month,
            SUM(CASE WHEN payment_status = ' . Order::PAYMENT_COMPLETED . ' THEN 1 ELSE 0 END) as paid,
            SUM(CASE WHEN payment_status = ' . Order::PAYMENT_PENDING . ' THEN 1 ELSE 0 END) as unpaid')
            ->whereYear('created_at', date('Y'))
            ->groupByRaw('MONTH(created_at)')
            ->orderBy('month')
            ->get();

        // 12. Số lượng đơn hàng bị hủy theo tháng trong năm hiện tại
        $canceledOrdersMonthly = Order::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->where('status', Order::STATUS_CANCELLED)
            ->whereYear('created_at', date('Y'))
            ->groupByRaw('MONTH(created_at)')
            ->orderBy('month')
            ->get();

        // 13. Số lượng đơn hàng bị hủy theo từng năm
        $canceledOrdersYearly = Order::selectRaw('YEAR(created_at) as year, COUNT(*) as total')
            ->where('status', Order::STATUS_CANCELLED)
            ->groupByRaw('YEAR(created_at)')
            ->orderBy('year')
            ->get();
        // 14. Số lượng đơn hàng đã hoàn thành và đã hủy trong tháng này
        $currentMonth = date('m');
        $currentYear = date('Y');

        $totalCompletedThisMonth = Order::where('status', Order::STATUS_COMPLETED)
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();

        $totalCanceledThisMonth = Order::where('status', Order::STATUS_CANCELLED)
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();
        // 14. Số lượng đơn hàng đã thanh toán và chưa thanh toán trong tháng này
        $paymentsThisMonth = Order::selectRaw('
SUM(CASE WHEN payment_status = ' . Order::PAYMENT_COMPLETED . ' THEN 1 ELSE 0 END) as paid,
SUM(CASE WHEN payment_status = ' . Order::PAYMENT_PENDING . ' THEN 1 ELSE 0 END) as unpaid
')
            ->whereYear('created_at', date('Y'))
            ->whereMonth('created_at', date('m'))
            ->first();

        // Truyền dữ liệu sang view
        return view('backend.dashboard.order', compact(
            'totalRevenue',
            'totalNewOrders',
            'totalCompletedOrders',
            'totalCanceledOrders',
            'totalUnpaidAmount',
            'totalShippingOrders',
            'salesMonthly',
            'salesYearly',
            'ordersMonthly',
            'ordersYearly',
            'paymentsMonthly',
            'canceledOrdersMonthly',
            'canceledOrdersYearly',
            'totalCompletedThisMonth', // Số đơn hàng hoàn thành trong tháng hiện tại
            'totalCanceledThisMonth', // Số đơn hàng bị hủy trong tháng hiện tại
            'paymentsThisMonth', // thêm biến này
            'title',
        ));
    }
}
