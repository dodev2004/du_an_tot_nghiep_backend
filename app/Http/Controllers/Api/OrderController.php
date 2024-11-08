<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function index(Request $request)
    {
        $userId = Auth::id();
        $statusFilter = $request->input('status');
        // Kiểm tra nếu có yêu cầu xác nhận đơn hàng
        if ($request->has('confirm_order_id')) {
            $orderId = $request->input('confirm_order_id');

            // Tìm đơn hàng theo ID
            $order = Order::find($orderId);
            if ($order) {
                // Kiểm tra trạng thái thanh toán và cập nhật
                // if ($order->payment_status == Order::PAYMENT_COMPLETED) {
                    $order->status = Order::STATUS_COMPLETED;
                // } else {
                //     $order->status = Order::STATUS_COMPLETED;
                //     $order->payment_status = Order::PAYMENT_COMPLETED;
                // }
                $order->save();
            }
        }


        // Điều kiện lọc trạng thái
        // Query danh sách đơn hàng với các trường cần thiết
        $query = Order::with([
            'customer:id,full_name',
            'promotion:id,code,discount_value',
            'paymentMethod:id,name'
        ])->where('customer_id', $userId);

        // Áp dụng bộ lọc theo trạng thái
        if ($statusFilter) {
            switch ($statusFilter) {
                case 'pending': // Chờ xác nhận
                    $query->where('status', 1);
                    break;
                case 'processing': // Đang xử lý
                    $query->whereIn('status', [2, 3]);
                    break;
                case 'shipping': // Đang giao
                    $query->whereIn('status', [4, 5]);
                    break;
                case 'completed': // Hoàn thành
                    $query->where('status', 6);
                    break;
            }
        }

        // Sắp xếp và phân trang
        $orders = $query->orderBy('created_at', 'desc')->paginate(10);

        $data = $orders->map(function ($order) {
            return [
                'id' => $order->id,
                'customer_name' => $order->customer_name,
                'customer' => [
                    'id' => $order->customer->id,
                    'customer_name' => $order->customer->full_name ?? null,
                ],
                'promotion' => [
                    'promotion_code' => $order->promotion->code ?? null,
                    'promotion_discount' => $order->promotion->discount_value ?? null,
                ],
                'payment_method' => [
                    'payment_method_id' => $order->paymentMethod->id,
                    'payment_method_name' => $order->paymentMethod->name ?? null,
                ],
                'total_amount' => $order->total_amount,
                'discount_amount' => $order->discount_amount,
                'final_amount' => $order->final_amount,
                'status' => $order->status_text,              // Trạng thái bằng tiếng Việt
                'payment_status' => $order->payment_status_text, // Trạng thái thanh toán bằng tiếng Việt
                'shipping_address' => $order->shipping_address,
                'shipping_fee' => $order->shipping_fee,
                'created_at' => $order->created_at,
                'updated_at' => $order->updated_at,
            ];
        });



        // Cập nhật lại collection của paginator
        $orders->setCollection(collect($data));

        // Trả về JSON cho phía front-end
        return response()->json([
            'success' => true,
            'data' => $orders
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function show($id)
    {
        $userId = Auth::id();
        // Query danh sách đơn hàng, có thể thêm điều kiện lọc nếu cần thiết
        $order = Order::with(['orderItems', 'customer:id,full_name', 'promotion:id,code,discount_value', 'paymentMethod:id,name'])->where('customer_id', $userId)
            ->find($id);
        // Kiểm tra nếu không tìm thấy đơn hàng
        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy đơn hàng'
            ], 404);
        }
        // Định dạng dữ liệu trả về
        $data = [
            'id' => $order->id,
            'customer_name' => $order->customer_name,
            'customer' => [
                'id' => $order->customer->id,
                'customer_name' => $order->customer->full_name ?? null,
            ],
            'promotion' => [
                'promotion_code' => $order->promotion->code ?? null,
                'promotion_discount' => $order->promotion->discount_value ?? null,
            ],
            'payment_method' => [
                'payment_method_id' => $order->paymentMethod->id,
                'payment_method_name' => $order->paymentMethod->name ?? null,
            ],
            'total_amount' => $order->total_amount,
            'discount_amount' => $order->discount_amount,
            'final_amount' => $order->final_amount,
            'status' => $order->status_text,              // Trạng thái bằng tiếng Việt
            'payment_status' => $order->payment_status_text, // Trạng thái thanh toán bằng tiếng Việt
            'shipping_address' => $order->shipping_address,
            'shipping_fee' => $order->shipping_fee,
            'created_at' => $order->created_at,
            'updated_at' => $order->updated_at,
            'order_items' => $order->orderItems
        ];

        // Trả về JSON cho phía front-end
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) {}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request) {}
}
