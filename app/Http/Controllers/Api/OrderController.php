<?php

namespace App\Http\Controllers\Api;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Mail\CancelOrder;
use App\Mail\OrderPlaced;
use App\Models\Promotion;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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
                'email' => $order->email,
                'phone_number' => $order->phone_number,
                'note' => $order->note,
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
        $order = Order::with(['orderItems.product_reviews', 'customer:id,full_name', 'promotion:id,code,discount_value', 'paymentMethod:id,name',])->where('customer_id', $userId)
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
            'email' => $order->email,
            'phone_number' => $order->phone_number,
            'note' => $order->note,
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
            'order_items' => $order->orderItems->map(function ($item) {
                $isReviewed = $item->product_reviews ? 'Đã có đánh giá' : 'Chưa có đánh giá';
                return [
                    'id' => $item->id,
                    'product_id' => $item->product_id,
                    'slug'=>$item->product ? $item->product->slug : null,
                    'image'=>$item->product ? $item->product->image_url : null,
                    'product_name' => $item->product_name,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'total' => $item->total,
                    'variant' => $item->variant,
                    'is_reviewed' => $isReviewed, // Trạng thái đã đánh giá
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
            'discount_code' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:15',
            'note' => 'nullable|string',
            'order_items' => 'required|array',
            'order_items.*.product_id' => 'required|exists:products,id',
            'order_items.*.product_variants_id' => 'nullable|exists:product_variants,id',
            'order_items.*.product_name' => 'required|string|max:255',
            'order_items.*.quantity' => 'required|integer|min:1',
            'order_items.*.price' => 'required|numeric',
            'order_items.*.total' => 'required|numeric',
            'order_items.*.variant' => 'nullable|json',
        ]);
        if ($validatedData['payment_method_id'] == 3) {
            foreach ($validatedData['order_items'] as $item) {
                $stock = null;
                $product = Product::find($item['product_id']);
                if ($item['product_variants_id']) {
                    $stock = ProductVariant::where('id', $item['product_variants_id'])->value('stock');
                } else {
                    $stock = Product::where('id', $item['product_id'])->value('stock');
                }
                if ($item['quantity'] > $stock) {
                    return response()->json([
                        'error' => 'Số lượng sản phẩm ' . $product->name . ' không đủ trong kho hàng.',
                    ], 400);
                }
            }
        }
        DB::beginTransaction();

        try {
            // Tạo đơn hàng mới
            $order = Order::create($validatedData);
            foreach ($validatedData['order_items'] as $item) {
                $order->orderItems()->create($item);
            }
            $carts = explode(",",$request->cart_id);
            foreach ($carts as $cartId) {
                $cart = Cart::find($cartId);

                if ($cart) {
                    // Cập nhật tồn kho
                    if ($cart->product_variants_id) {
                        // Trừ tồn kho của biến thể sản phẩm
                        $variant = $cart->productVariant;
                        if ($variant && $variant->stock >= $cart->quantity) {
                            $variant->stock -= $cart->quantity;
                            $variant->save();
                        } else {
                            throw new \Exception('Không đủ tồn kho cho biến thể sản phẩm.');
                        }
                    } else {
                        // Trừ tồn kho của sản phẩm
                        $product = $cart->product;
                        if ($product && $product->stock >= $cart->quantity) {
                            $product->stock -= $cart->quantity;
                            $product->save();
                        } else {
                            throw new \Exception('Không đủ tồn kho cho sản phẩm.');
                        }
                    }
                    // Xóa mục giỏ hàng
                    $cart->delete();
                }
            }
            if (!empty($validatedData['discount_code'])) {
                $promotion = Promotion::where('code', $validatedData['discount_code'])->first();
                if ($promotion && $promotion->max_uses > $promotion->quantity) {
                $order->discount_amount = $promotion->discount_value;
                    $order->final_amount = $order->total_amount - $order->discount_amount;
                    $order->save();
                    $promotion->quantity += 1;
                    $promotion->used_count += 1;
                    $promotion->save();
                } else {
                    throw new \Exception('Mã giảm giá không hợp lệ.');
                }
            }
            $order->final_amount = $order->total_amount - $order->discount_amount + $order->shipping_fee;
            $order->save();
            DB::commit();
            Mail::to($order->email)->send(new OrderPlaced($order->load('orderItems')));           
            return response()->json([
                'success' => true,
                'message' => 'Đơn hàng đã được tạo thành công!',
                'data' => $order->load('orderItems')
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            // Trả về phản hồi lỗi
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
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
        if(!($order->status == 1)){
            return response()->json([
                'message' => 'Không thể huỷ đơn hàng',
            ], 400);
        }
        if ($order) {
            foreach ($order->orderItems as $item) {
                
                if ($item->product_variants_id) {
                    $variant = ProductVariant::find($item->product_variants_id);
                    if ($variant) {
                       
                        $variant->stock += $item->quantity;
                        $variant->save();
                    }
                } else {
                    $product = Product::find($item->product_id);
                    if ($product) {
                        $product->stock += $item->quantity;
                        $product->save();
                    }
                }
            }
            // Chỉ cập nhật trạng thái thành hoàn thành
            $order->update([
                'status' => Order::STATUS_CANCELLED
            ]);
            Mail::to($order->email)->send(new CancelOrder($order)); 
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
        ->orderBy('deleted_at', 'desc')
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
