<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductComment;
use App\Models\ProductReview;
use App\Models\OrderItem;
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

        // 1. Tổng doanh thu trong toàn bộ thời gian
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

        // 5. Doanh thu theo từng tháng trong năm hiện tại
        $salesMonthly = Order::selectRaw('MONTH(created_at) as month, SUM(final_amount) as total')
            ->whereYear('created_at', date('Y'))
            ->whereIn('status', [Order::STATUS_COMPLETED])
            ->where('payment_status', Order::PAYMENT_COMPLETED)
            ->groupByRaw('MONTH(created_at)')
            ->orderBy('month')
            ->get();
        // 6. Số lượng đơn hàng hoàn thành theo tháng trong năm hiện tại
        $completedOrdersMonthly = Order::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', date('Y'))
            ->where('status', Order::STATUS_COMPLETED)
            ->groupByRaw('MONTH(created_at)')
            ->orderBy('month')
            ->get();

        // 7. Số lượng đơn hàng bị hủy theo tháng trong năm hiện tại
        $canceledOrdersMonthly = Order::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', date('Y'))
            ->where('status', Order::STATUS_CANCELLED)
            ->groupByRaw('MONTH(created_at)')
            ->orderBy('month')
            ->get();
        // 8. Doanh thu hôm nay
        $todayRevenue = Order::whereDate('created_at', date('Y-m-d'))
            ->where('payment_status', Order::PAYMENT_COMPLETED)
            ->sum('final_amount');

        // 9. Số đơn hàng đã hoàn thành hôm nay
        $completedOrdersToday = Order::whereDate('created_at', date('Y-m-d'))
            ->where('status', Order::STATUS_COMPLETED)
            ->count();

        // 10. Số đơn hàng chưa thu tiền hôm nay
        $pendingPaymentOrdersToday = Order::whereDate('created_at', date('Y-m-d'))
            ->where('status', Order::STATUS_COMPLETED)
            ->where('payment_status', Order::PAYMENT_PENDING)
            ->count();

        // 11. Số đơn hàng bị hủy hôm nay
        $canceledOrdersToday = Order::whereDate('created_at', date('Y-m-d'))
            ->where('status', Order::STATUS_CANCELLED)
            ->count();
        // Thống kê trạng thái đơn hàng trong tháng
        $orderStatusCount = Order::select('status', DB::raw('COUNT(*) as total'))
            ->whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->groupBy('status')
            ->get();

        // Chuyển đổi kết quả thành mảng để dễ dàng sử dụng trong biểu đồ
        $statusLabels = [];
        $statusCounts = [];

        foreach ($orderStatusCount as $status) {
            $statusLabels[] = $this->getStatusLabel($status->status);
            $statusCounts[] = $status->total;
        }


        // Truyền dữ liệu sang view
        return view('backend.dashboard.order', compact(
            'totalRevenue',
            'totalNewOrders',
            'totalCompletedOrders',
            'totalCanceledOrders',
            'salesMonthly',
            'completedOrdersMonthly',  // Đơn hàng hoàn thành theo tháng
            'canceledOrdersMonthly',   // Đơn hàng bị hủy theo tháng
            'todayRevenue',                // Doanh thu hôm nay
            'completedOrdersToday',        // Số đơn hàng đã hoàn thành hôm nay
            'pendingPaymentOrdersToday',   // Số đơn hàng chưa thu tiền hôm nay
            'canceledOrdersToday',         // Số đơn hàng bị hủy hôm nay
            'statusLabels',
            'statusCounts',
            'title',
        ));
    }
    private function getStatusLabel($status)
    {
        switch ($status) {
            case Order::STATUS_PENDING:
                return 'Chờ Xác Nhận';
            case Order::STATUS_CONFIRM:
                return 'Đã Xác Nhận';
            case Order::STATUS_PROCESSING:
                return 'Đang Xử Lý';
            case Order::STATUS_SHIPPED:
                return 'Đã Giao';
            case Order::STATUS_COMPLETED:
                return 'Hoàn Thành';
            case Order::STATUS_CANCELLED:
                return 'Đã Hủy';
            case Order::STATUS_REFUNDED:
                return 'Đã Hoàn Tiền';
            default:
                return 'Khác';
        }
    }
}
