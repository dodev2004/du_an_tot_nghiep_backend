<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public $paymentMethods;
    protected $breadcrumbs = [];

    public function index(Request $request)
    {
        $title = "Quản lý đơn hàng";
        if ($request->has("dates")) {
            // Giải mã chuỗi từ request
            $dates = urldecode($request->input('dates'));

            // Tìm và tách khoảng ngày từ chuỗi
            $dateRange = explode(': ', $dates)[1] ?? $dates;

            // Phân tách thành ngày bắt đầu và ngày kết thúc
            [$start, $end] = explode(' - ', $dateRange);

            // Loại bỏ khoảng trắng và ký tự không mong muốn
            $start = trim(preg_replace('/[^0-9\s\p{L},]/u', '', $start));
            $end = trim(preg_replace('/[^0-9\s\p{L},]/u', '', $end));
            

            
            try {
                // Sử dụng createFromFormat với định dạng rõ ràng
                $startDate = Carbon::createFromFormat('d [Tháng] m, Y', $start);
                $endDate = Carbon::createFromFormat('d [Tháng] m, Y', $end);

                // Kiểm tra nếu định dạng không khớp
                if (!$startDate || !$endDate) {
                    throw new \Exception('Định dạng ngày không khớp.');
                }

                // Bắt đầu và kết thúc ở đầu và cuối ngày
                $startDate = $startDate->startOfDay();
                $endDate = $endDate->endOfDay();
            } catch (\Exception $e) {
                return response()->json(['error' => 'Định dạng ngày không hợp lệ: ' . $e->getMessage()], 400);
            }
        }



        $this->breadcrumbs[] = [
            "active" => true,
            "url" => route("admin.orders"),
            "name" => "Quản lý đơn hàng"
        ];
        $breadcrumbs = $this->breadcrumbs;
        $keywords = $request->input('keywords');
        $orders = Order::with(['user', 'orderItems', 'promotion', 'paymentMethod'])->get();

        return view("backend.orders.templates.index", compact("title", "breadcrumbs", 'orders'));
    }
    public function update(Request $request)
    {
        // Tìm đơn hàng theo ID
        $order = Order::find($request->order_id);

        if ($order) {
            if ($request->status === 7) {
                if ($order->payment_status === 2) {
                    $order->payment_status = 3;
                }
            }
            if ($request->status == 6) {
                if ($order->payment_status == 1) {
                    $order->payment_status = 2;
                }
            }
            $order->status = $request->status;
            $order->save();

            return response()->json(['success' => true, 'newStatus' => $order->status, "newPaymebnt_status" => $order->payment_status]);
        }

        return response()->json(['success' => false]);
    }

    public function show($id, Request $request)
    {

        $title = "Chi tiết đơn hàng";

        $this->breadcrumbs[] = [
            "active" => true,
            "url" => route("admin.orders"),
            "name" => "Quản lý đơn hàng"
        ];
        $breadcrumbs = $this->breadcrumbs;
        $orders = Order::with(['customer', 'orderItems.product', 'promotion', 'paymentMethod'])->find($id);

        return view("backend.orders.templates.detail", compact("title", "breadcrumbs", 'orders'));
    }
}
