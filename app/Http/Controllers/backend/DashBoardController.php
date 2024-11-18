<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductComment;
use App\Models\ProductReview;
use App\Models\OrderItem;
use App\Models\Promotion;
use Carbon\Carbon;
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

        $orderStatusCounts = Order::select('status', DB::raw('count(*) as count'))
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy('status')
            ->orderBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $orderStatusData = [
            ['label' => 'Chờ xử lý', 'value' => $orderStatusCounts[Order::STATUS_PENDING] ?? 0],
            ['label' => 'Xác nhận', 'value' => $orderStatusCounts[Order::STATUS_CONFIRM] ?? 0],
            ['label' => 'Đang xử lí', 'value' => $orderStatusCounts[Order::STATUS_PROCESSING] ?? 0],
            ['label' => 'Đang giao', 'value' => $orderStatusCounts[Order::STATUS_SHIPPED] ?? 0],
            ['label' => 'Đã giao', 'value' => $orderStatusCounts[Order::STATUS_SHIPPEDS] ?? 0],
            ['label' => 'Hoàn thành', 'value' => $orderStatusCounts[Order::STATUS_COMPLETED] ?? 0],
            ['label' => 'Đã hủy', 'value' => $orderStatusCounts[Order::STATUS_CANCELLED] ?? 0],
            ['label' => 'Hoàn tiền', 'value' => $orderStatusCounts[Order::STATUS_REFUNDED] ?? 0]
        ];

        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Thống kê tổng số mã giảm giá tạo 
        $totalCoupons = Promotion::count();

        // Thống kê tổng số mã giảm giá còn hoạt động
        $activeCoupons = Promotion::where('status', 'active')->count();

        // Tính tổng số mã giảm giá không còn hoạt động
        $inactiveCoupons = $totalCoupons - $activeCoupons;
        // Lấy mã giảm giá được sử dụng nhiều nhất dựa trên trường used_count
        $topCoupons = Promotion::select('code', 'used_count')
            ->orderBy('used_count', 'desc')
            ->limit(5) 
            ->get();

        return view('backend.dashboard.home', compact(
            'ratingLabels',
            'ratingCounts',
            'topRatedProducts',
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
            'totalCoupons',
            'activeCoupons',
            'inactiveCoupons',
            'topCoupons',
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




    public function selectOrderStatusData(Request $request)
    {
        $data = $request->all();
        $startOfToday = now()->startOfDay();
        $startOfMonth = now()->startOfMonth();
        $startOfLastMonth = now()->subMonth()->startOfMonth();
        $endOfLastMonth = now()->subMonth()->endOfMonth();
        $sub7days = now()->subDays(7);
        $sub365days = now()->subDays(365);

        $query = Order::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->orderBy('status');

        // Thêm điều kiện dựa trên khoảng thời gian đã chọn
        if ($data['order_value'] == 'homnay') {
            $query->where('created_at', '>=', $startOfToday);
        } elseif ($data['order_value'] == '7ngay') {
            $query->where('created_at', '>=', $sub7days);
        } elseif ($data['order_value'] == 'thangtruoc') {
            $query->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth]);
        } elseif ($data['order_value'] == 'thangnay') {
            $query->where('created_at', '>=', $startOfMonth);
        } else {
            $query->where('created_at', '>=', $sub365days);
        }

        $statusData = $query->pluck('total', 'status')->toArray();

        // Khởi tạo mảng mặc định với các trạng thái có giá trị 0
        $orderStatusCounts = [
            Order::STATUS_PENDING => 0,
            Order::STATUS_CONFIRM => 0,
            Order::STATUS_PROCESSING => 0,
            Order::STATUS_SHIPPED => 0,
            Order::STATUS_SHIPPEDS => 0,
            Order::STATUS_COMPLETED => 0,
            Order::STATUS_CANCELLED => 0,
            Order::STATUS_REFUNDED => 0,
        ];

        // Ghi đè số lượng thực tế từ dữ liệu truy vấn
        foreach ($statusData as $status => $total) {
            $orderStatusCounts[$status] = $total;
        }

        // Chuẩn bị dữ liệu cho biểu đồ
        $chartData = [];
        foreach ($orderStatusCounts as $status => $total) {
            $chartData[] = [
                'label' => $this->getStatusLabel($status),
                'value' => $total,
            ];
        }

        if (array_sum(array_column($chartData, 'value')) === 0) {
            return response()->json([
                'error' => 'Không có đơn hàng nào cho khoảng thời gian này.'
            ], 404); // Trả về mã lỗi 404
        }

        return response()->json($chartData);
    }

    // Hàm để lấy nhãn trạng thái
    private function getStatusLabel($status)
    {
        return match ($status) {
            Order::STATUS_PENDING => 'Chờ xử lý',
            Order::STATUS_CONFIRM => 'Xác nhận',
            Order::STATUS_PROCESSING => 'Đang xử lí',
            Order::STATUS_SHIPPED => 'Đang giao',
            Order::STATUS_SHIPPEDS => 'Đã giao',
            Order::STATUS_COMPLETED => 'Hoàn thành',
            Order::STATUS_CANCELLED => 'Đã hủy',
            Order::STATUS_REFUNDED => 'Hoàn tiền',
            default => 'Không xác định'
        };
    }
}
