<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public $paymentMethods;
    protected $breadcrumbs = [];
  
    public function index(Request $request)
    {
        $title = "Quản lý phương thức thanh toán";
   
        $this->breadcrumbs[] = [
            "active" => true,
            "url" => route("admin.payment_methods"),
            "name" => "Quản lý phương thức thanh toán"
        ];
        $breadcrumbs = $this->breadcrumbs;
        $keywords = $request->input('keywords');
        $orders = Order::with(['user', 'orderItems', 'promotion', 'paymentMethod'])->get();
        return view("backend.orders.templates.index", compact("title", "breadcrumbs",'orders'));
    }
    public function update(Request $request){
        // Tìm đơn hàng theo ID
    $order = Order::find($request->order_id);

    if ($order) {
        // Nếu trạng thái được cập nhật là 6 (Hủy đơn hàng)
        if ($request->status === 6) {
            
            if ($order->payment_status === 2) {
                // Cập nhật trạng thái thanh toán về 4 (Đã hoàn tiền)
                $order->payment_status = 4;
            }
        }

        // Cập nhật trạng thái đơn hàng
        $order->status = $request->status;
        $order->save();

        return response()->json(['success' => true, 'newStatus' => $order->status]);
    }

    return response()->json(['success' => false]);
    }
}
