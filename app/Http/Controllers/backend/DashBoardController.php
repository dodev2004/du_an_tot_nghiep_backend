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

        return view('backend.dashboard.home', compact('ratingLabels', 'ratingCounts', 'topRatedProducts'));
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

        $fromDate = now()->startOfMonth()->format('Y-m-d');
        $toDate = now()->format('Y-m-d'); // Ngày hiện tại

        // Lấy các đơn hàng đã hoàn thành và đã thanh toán trong 1 năm qua
        $orders = Order::whereBetween('created_at', [$fromDate, $toDate])
            ->where('status', Order::STATUS_COMPLETED)
            ->where('payment_status', Order::PAYMENT_COMPLETED)
            ->orderBy('created_at', 'ASC')
            ->get(['final_amount', 'created_at']);

        // Nhóm các đơn hàng theo ngày và tính tổng doanh thu cho mỗi ngày
        $chartData = $orders->groupBy(function ($order) {
            return $order->created_at->format('Y-m-d'); // Nhóm theo ngày
        })->map(function ($orders, $date) {
            return [
                'created_at' => $date,
                'final_amount' => $orders->sum('final_amount') // Tổng doanh thu của các đơn hàng trong cùng một ngày
            ];
        })->values(); // Reset các key của collection

        $orderStatusCounts = Order::whereNotIn('status', [Order::STATUS_PROCESSING])
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $orderStatusData = [
            ['label' => 'Chờ xử lý', 'value' => $orderStatusCounts[Order::STATUS_PENDING] ?? 0],
            ['label' => 'Xác nhận', 'value' => $orderStatusCounts[Order::STATUS_CONFIRM] ?? 0],
            ['label' => 'Đang giao', 'value' => $orderStatusCounts[Order::STATUS_SHIPPED] ?? 0],
            ['label' => 'Hoàn thành', 'value' => $orderStatusCounts[Order::STATUS_COMPLETED] ?? 0],
            ['label' => 'Đã hủy', 'value' => $orderStatusCounts[Order::STATUS_CANCELLED] ?? 0],
            ['label' => 'Hoàn tiền', 'value' => $orderStatusCounts[Order::STATUS_REFUNDED] ?? 0]
        ];


        // Truyền dữ liệu sang view
        return view('backend.dashboard.order', compact(
            'totalRevenue',
            'totalNewOrders',
            'totalCompletedOrders',
            'totalCanceledOrders',
            'todayRevenue',                // Doanh thu hôm nay
            'completedOrdersToday',        // Số đơn hàng đã hoàn thành hôm nay
            'pendingPaymentOrdersToday',   // Số đơn hàng chưa thu tiền hôm nay
            'canceledOrdersToday',         // Số đơn hàng bị hủy hôm nay
            'chartData',
            'orderStatusData',

            'title',
        ));
    }
    public function filterSalesData(Request $request)
{
    $data = $request->all();
    $fromDate = $data['fromDate'];
    $toDate = $data['toDate'];

    // Lấy các đơn hàng đã hoàn thành và đã thanh toán, nhóm theo ngày
    $get = Order::whereBetween('created_at', [$fromDate, $toDate])
        ->where('status', Order::STATUS_COMPLETED) // Trạng thái hoàn thành
        ->where('payment_status', Order::PAYMENT_COMPLETED) // Trạng thái đã thanh toán
        ->selectRaw('SUM(final_amount) as total_amount, DATE(created_at) as order_date')
        ->groupBy('order_date')
        ->orderBy('order_date', 'ASC')
        ->get();


    foreach ($get as $value) {
        $chart_data[] = array(
            'final_amount' => $value->total_amount,
            'created_at' => $value->order_date,
        );
    }

    return response()->json($chart_data);
}
public function selectSalesData(Request $request)
{
    $data = $request->all();
    $dauthangnay = now()->startOfMonth()->toDateString();
    $dauthangtruoc = now()->subMonth()->startOfMonth()->toDateString();
    $cuoithangtruoc = now()->subMonth()->endOfMonth()->toDateString();

    $sub7days = now()->subDays(7)->toDateString();
    $sub365days = now()->subDays(365)->toDateString();

    // Khởi tạo biến $get
    $get = null;

    if ($data['dashboard_value'] == '7ngay') {
        $get = Order::where('created_at', '>=', $sub7days)
            ->where('status', Order::STATUS_COMPLETED)
            ->where('payment_status', Order::PAYMENT_COMPLETED)
            ->selectRaw('SUM(final_amount) as total_amount, DATE(created_at) as order_date')
            ->groupBy('order_date')
            ->orderBy('order_date', 'ASC')
            ->get();
    } elseif ($data['dashboard_value'] == 'thangtruoc') {
        $get = Order::where('created_at', '>=', $dauthangtruoc)
            ->where('created_at', '<=', $cuoithangtruoc)
            ->where('status', Order::STATUS_COMPLETED)
            ->where('payment_status', Order::PAYMENT_COMPLETED)
            ->selectRaw('SUM(final_amount) as total_amount, DATE(created_at) as order_date')
            ->groupBy('order_date')
            ->orderBy('order_date', 'ASC')
            ->get();
    } elseif ($data['dashboard_value'] == 'thangnay') {
        $get = Order::where('created_at', '>=', $dauthangnay)
            ->where('status', Order::STATUS_COMPLETED)
            ->where('payment_status', Order::PAYMENT_COMPLETED)
            ->selectRaw('SUM(final_amount) as total_amount, DATE(created_at) as order_date')
            ->groupBy('order_date')
            ->orderBy('order_date', 'ASC')
            ->get();
    } else {
        $get = Order::where('created_at', '>=', $sub365days)
            ->where('status', Order::STATUS_COMPLETED)
            ->where('payment_status', Order::PAYMENT_COMPLETED)
            ->selectRaw('SUM(final_amount) as total_amount, DATE(created_at) as order_date')
            ->groupBy('order_date')
            ->orderBy('order_date', 'ASC')
            ->get();
    }

    
    foreach ($get as $value) {
        $chart_data[] = array(
            'final_amount' => $value->total_amount,
            'created_at' => $value->order_date,
        );
    }

    return response()->json($chart_data);
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
