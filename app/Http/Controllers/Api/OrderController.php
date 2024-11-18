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
        $searchQuery = $request->input('search'); // Ô input chung cho mã đơn và tên khách hàng
        $orderDate = $request->input('order_date'); // Ngày đặt hàng


        // Điều kiện lọc trạng thái
        // Query danh sách đơn hàng với các trường cần thiết
        $query = Order::with([
            'customer:id,full_name',
            'promotion:id,code,discount_value',
            'paymentMethod:id,name',
        ])->where('customer_id', $userId)
        ->where('status', '!=', 7);

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
        if ($searchQuery) {
            // Chuyển `$searchQuery` về viết hoa để không phân biệt chữ hoa - chữ thường
            $normalizedQuery = strtoupper($searchQuery);

            if (str_starts_with($normalizedQuery, 'BND-') || is_numeric($searchQuery)) {
                // Loại bỏ tiền tố 'BND-' (không phân biệt hoa thường) nếu có và tìm theo mã đơn hàng (id)
                $orderId = ltrim($normalizedQuery, 'BND-');
                $query->where('id', $orderId);
            } else {
                // Tìm kiếm theo tên khách hàng trong bảng `order`
                $query->where('customer_name', 'like', '%' . $searchQuery . '%');
            }
        }

        // Áp dụng bộ lọc theo ngày đặt hàng
        if ($orderDate) {
            // Chuyển đổi định dạng 'DD-MM-YYYY' thành 'Y-m-d'
            $orderDateFormatted = \Carbon\Carbon::createFromFormat('d-m-Y', $orderDate)->format('Y-m-d');

            // Tìm kiếm theo ngày trong trường 'created_at'
            $query->whereDate('created_at', $orderDateFormatted);
        }

        // Sắp xếp và phân trang
        $orders = $query->orderBy('created_at', 'desc')->paginate(10);
        if ($orders->isEmpty()) {
            return response()->json(['message' => 'người dùng không có đơn hàng nào'], 404);
        }
        $data = $orders->map(function ($order) {

            return [
                'id' => $order->id,
                'order_code' => 'BND-' . $order->id, // Mã đơn hàng theo yêu cầu
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
                'created_at' => $order->created_at->format('d-m-Y'),
                'updated_at' => $order->updated_at->format('d-m-Y'),
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
        $order = Order::with(['.product_reviews', 'customer:id,full_name', 'promotion:id,code,discount_value', 'paymentMethod:id,name'])->where('customer_id', $userId)
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
            'order_code' => 'BND-' . $order->id, // Mã đơn hàng theo yêu cầu
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
            'created_at' => $order->created_at->format('d-m-Y'),
            'updated_at' => $order->updated_at->format('d-m-Y'),
            'order_items' => $order->orderItems,
            'reviews' => $order->orderItems->map(function ($item) {
                    return [
                        'order_item_id' => $item->id,
                        'product_id' => $item->product_id,
                        'review' => $item->product_reviews ? [
                            'rating' => $item->product_reviews->rating,
                            'review' => $item->product_reviews->review,
                            'image' => $item->product_reviews->image,
                            'created_at' => $item->product_reviews->created_at->format('d-m-Y'),
                        ] : null,
                    ];
                }),
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
    public function store(Request $request) {
        $validatedData = $request->validate([
            'customer_id' => 'required|exists:users,id',
            'customer_name' => 'required|string|max:255',
            'promotion_id' => 'nullable|exists:promotions,id',
            'total_amount' => 'required|numeric',
            'discount_amount' => 'nullable|numeric',
            'final_amount' => 'required|numeric',
            'status' => 'required|in:1,2,3,4,5,6,7,8',
            'payment_status' => 'required|in:1,2,3,4',
            'shipping_address' => 'required|string|max:255',
            'shipping_fee' => 'required|numeric',
            'payment_method_id' => 'nullable|exists:payment_methods,id',
            'discount_code' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:15',
            'note' => 'nullable|string',
            'order_items' => 'required|array',
            'order_items.*.product_id' => 'required|exists:products,id',
            'order_items.*.product_name' => 'required|string|max:255',
            'order_items.*.quantity' => 'required|integer|min:1',
            'order_items.*.price' => 'required|numeric',
            'order_items.*.total' => 'required|numeric',
            'order_items.*.variant' => 'nullable|json',
        ]);

        $order = Order::create($validatedData);
    
        // Tạo các mục đơn hàng
        foreach ($validatedData['order_items'] as $item) {
            $order->orderItems()->create($item);
        }
    
        // Trả về phản hồi thành công
        return response()->json([
            'success' => true,
            'message' => 'Đơn hàng đã được tạo thành công!',
            'data' => $order->load('orderItems')
        ], 201);

    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) {}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Tìm đơn hàng theo ID
        $order = Order::find($id);

        if ($order) {
            // Xoá đơn hàng
            $order->delete();

            // Trả về phản hồi thành công
            return response()->json([
                'status' => 'success',
                'message' => 'Đơn hàng đã được xoá thành công!',
            ], 200);
        }

        // Nếu đơn hàng không tồn tại
        return response()->json([
            'message' => 'Không tìm thấy đơn hàng.',
        ], 404);
    }


    public function completeOrderStatus($id)
    {
        // Tìm đơn hàng theo ID
        $order = Order::find($id);

        if ($order) {
            // Chỉ cập nhật trạng thái thành hoàn thành
            $order->update([
                'status' => Order::STATUS_COMPLETED
            ]);

            // Trả về phản hồi thành công
            return response()->json([
                'status' => 'success',
                'message' => 'Cập nhật trạng thái đơn hàng thành công!',

            ], 200);
        }

        // Nếu đơn hàng không tồn tại
        return response()->json([

            'message' => 'Không tìm thấy đơn hàng.',
        ], 404);
    }

    public function cancelOrderStatus($id)
    {
        // Tìm đơn hàng theo ID
        $order = Order::find($id);

        if ($order) {
            // Chỉ cập nhật trạng thái thành hoàn thành
            $order->update([
                'status' => Order::STATUS_CANCELLED
            ]);

            // Trả về phản hồi thành công
            return response()->json([
                'status' => 'success',
                'message' => 'Huỷ đơn hàng thành công!',

            ], 200);
        }

        // Nếu đơn hàng không tồn tại
        return response()->json([

            'message' => 'Không tìm thấy đơn hàng.',
        ], 404);
    }
    // public function restore($id)
    // {
    //     // Tìm đơn hàng theo ID bao gồm cả đơn hàng đã xóa mềm
    // $order = Order::withTrashed()->find($id);

    //     if ($order) {
    //         // Chỉ cập nhật trạng thái thành hoàn thành
    //         $order->restore();

    //         // Trả về phản hồi thành công
    //         return response()->json([
    //             'status' => 'success',
    //             'message' => 'khôi phục đơn hàng thành công!',

    //         ], 200);
    //     }

    //     // Nếu đơn hàng không tồn tại
    //     return response()->json([

    //         'message' => 'Không tìm thấy đơn hàng.',
    //     ], 404);
    // }

    public function OrderCancel(Request $request)
    {
        $userId = Auth::id();
        $searchQuery = $request->input('search'); // Ô input chung cho mã đơn và tên khách hàng
        $orderDate = $request->input('order_date'); // Ngày đặt hàng


        // Điều kiện lọc trạng thái
        // Query danh sách đơn hàng với các trường cần thiết
        $query = Order::with([
            'customer:id,full_name',
            'promotion:id,code,discount_value',
            'paymentMethod:id,name'
        ])->where('customer_id', $userId)
        ->where('status', '=', 7);

        if ($searchQuery) {
            // Chuyển `$searchQuery` về viết hoa để không phân biệt chữ hoa - chữ thường
            $normalizedQuery = strtoupper($searchQuery);

            if (str_starts_with($normalizedQuery, 'BND-') || is_numeric($searchQuery)) {
                // Loại bỏ tiền tố 'BND-' (không phân biệt hoa thường) nếu có và tìm theo mã đơn hàng (id)
                $orderId = ltrim($normalizedQuery, 'BND-');
                $query->where('id', $orderId);
            } else {
                // Tìm kiếm theo tên khách hàng trong bảng `order`
                $query->where('customer_name', 'like', '%' . $searchQuery . '%');
            }
        }

        // Áp dụng bộ lọc theo ngày đặt hàng
        if ($orderDate) {
            // Chuyển đổi định dạng 'DD-MM-YYYY' thành 'Y-m-d'
            $orderDateFormatted = \Carbon\Carbon::createFromFormat('d-m-Y', $orderDate)->format('Y-m-d');

            // Tìm kiếm theo ngày trong trường 'created_at'
            $query->whereDate('created_at', $orderDateFormatted);
        }

        // Sắp xếp và phân trang
        $orders = $query->orderBy('created_at', 'desc')->paginate(10);
        if ($orders->isEmpty()) {
            return response()->json(['message' => 'người dùng không có đơn hàng nào'], 404);
        }
        $data = $orders->map(function ($order) {

            return [
                'id' => $order->id,
                'order_code' => 'BND-' . $order->id, // Mã đơn hàng theo yêu cầu
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
                'created_at' => $order->created_at->format('d-m-Y'),
                'updated_at' => $order->updated_at->format('d-m-Y'),
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
}
