<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductComment;
use App\Models\ProductReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashBoardController extends Controller
{
    public function index()
    {
        $ratingStats = ProductReview::select(DB::raw('rating, COUNT(*) as count'))
                    ->groupBy('rating')
                    ->orderBy('rating', 'asc')
                    ->get();

        $ratingLabels = [1, 2, 3, 4, 5]; // Các mốc sao
        $ratingCounts = [0, 0, 0, 0, 0]; // Số lượng tương ứng cho từng mốc sao

        foreach ($ratingStats as $stat) {
            $ratingCounts[$stat->rating - 1] = $stat->count;
        }

        //Top 10 sản phẩm được đánh giá trung bình sao cao nhất
        $topRatedProducts = ProductReview::select('product_id', DB::raw('AVG(rating) as average_rating'))
        ->groupBy('product_id')
        ->orderBy('average_rating', 'desc')
        ->take(10)
        ->with('product')
        ->get();

        //Top 10 sản phẩm được bình luận nhiều nhất
        $mostCommentedProducts = ProductComment::select('product_id', DB::raw('COUNT(*) as comment_count'))
        ->groupBy('product_id')
        ->orderBy('comment_count', 'desc')
        ->take(10)
        ->with('product')
        ->get();

        return view('backend.dashboard.home', compact('ratingLabels', 'ratingCounts','topRatedProducts', 'mostCommentedProducts'));
    }
    public function OrderIndex()
    {
        $title = "Thống kê order";

        // 1. Doanh thu theo từng tháng trong năm hiện tại
        $monthlySales = Order::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, SUM(final_amount) as total_final_amount')
            ->where('status', 1) // Giao hàng thành công
            ->where('payment_status', 1) // Đã trả tiền
            ->whereYear('created_at', date('Y')) // Chỉ lấy dữ liệu cho năm hiện tại
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        // 2. Doanh thu theo từng năm
        $yearlySales = Order::selectRaw('YEAR(created_at) as year, SUM(final_amount) as total_final_amount')
            ->where('status', 1) // Giao hàng thành công
            ->where('payment_status', 1) // Đã trả tiền
            ->groupBy('year')
            ->orderBy('year')
            ->get();

        // 3. Tổng doanh thu toàn bộ
        $totalSales = Order::where('status', 1)
            ->where('payment_status', 1)
            ->sum('final_amount');

        // 4. Số lượng đơn hàng đã hoàn thành trong tháng hiện tại
        $completedOrdersMonthly = Order::where('status', 1)
            ->whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->count();

        // 5. Số lượng đơn hàng đã hoàn thành trong năm hiện tại
        $completedOrdersYearly = Order::where('status', 1)
            ->whereYear('created_at', date('Y'))
            ->count();

        // 6. Số lượng đơn hàng đã hoàn thành và đã thu tiền
        $paidOrders = Order::where('status', 1)
            ->where('payment_status', 1)
            ->count();

        // 7. Số lượng đơn hàng đang giao (trạng thái 2)
        $inDeliveryOrders = Order::where('status', 2)
            ->count();

        // 8. Số lượng đơn hàng đã huỷ (trạng thái 0)
        $cancelledOrders = Order::where('status', 0)
            ->count();

        // 9. Số lượng đơn hàng đã hoàn thành nhưng chưa thu tiền
        $unpaidOrders = Order::where('status', 1)
            ->where('payment_status', 0)
            ->count();

        // 10. Tổng số tiền của đơn hàng đã hoàn thành nhưng chưa thu tiền
        $totalUnpaidOrdersAmount = Order::where('status', 1)
            ->where('payment_status', 0)
            ->sum('final_amount');

        // 11. Chuyển đổi dữ liệu thành mảng dùng cho view
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

        // Số lượng đơn hàng hoàn thành theo tháng
        $monthlyCompletedOrders = [];
        foreach ($monthlyLabels as $month) {
            $completedOrdersCount = Order::whereMonth('created_at', '=', $month)
                ->whereYear('created_at', '=', date('Y'))
                ->where('status', 1)
                ->count();
            $monthlyCompletedOrders[] = $completedOrdersCount;
        }

        // Số lượng đơn hàng hoàn thành theo năm
        $yearlyCompletedOrders = [];
        foreach ($yearlyLabels as $year) {
            $completedOrdersCount = Order::whereYear('created_at', '=', $year)
                ->where('status', 1)
                ->count();
            $yearlyCompletedOrders[] = $completedOrdersCount;
        }

        // Dữ liệu cho biểu đồ tròn
        $orderStatusLabels = ['Completed Orders', 'Orders In Delivery', 'Cancelled Orders'];
        $orderStatusData = [$paidOrders, $inDeliveryOrders, $cancelledOrders];

        // 12. Số lượng đơn hàng bị huỷ theo tháng trong năm hiện tại
        $cancelledOrdersMonthly = Order::selectRaw('MONTH(created_at) as month, COUNT(*) as cancelled_count')
            ->where('status', 0) // Đơn hàng bị huỷ
            ->whereYear('created_at', date('Y')) // Năm hiện tại
            ->groupBy('month')
            ->orderBy('month')
            ->get();
        // 13. Số lượng đơn hàng bị huỷ theo từng năm
        $cancelledOrdersYearly = Order::selectRaw('YEAR(created_at) as year, COUNT(*) as cancelled_count')
            ->where('status', 0) // Đơn hàng bị huỷ
            ->groupBy('year')
            ->orderBy('year')
            ->get();

        // Truyền dữ liệu sang view
        return view('backend.dashboard.order', compact(
            'monthlyLabels',
            'monthlyData',
            'yearlyLabels',
            'yearlyData',
            'totalSales',
            'completedOrdersMonthly',
            'completedOrdersYearly',
            'paidOrders',
            'inDeliveryOrders',
            'cancelledOrders',
            'unpaidOrders',
            'totalUnpaidOrdersAmount',
            'monthlyCompletedOrders',
            'yearlyCompletedOrders',
            'orderStatusLabels',  // Đưa biến vào
            'orderStatusData',    // Đưa biến vào
            'cancelledOrdersMonthly', // Thêm dữ liệu vào
            'cancelledOrdersYearly',  // Thêm dữ liệu vào
            'title'
        ));
    }
}
