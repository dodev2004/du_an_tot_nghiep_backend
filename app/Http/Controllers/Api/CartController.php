<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class CartController extends Controller
{
    /**
     * Lấy danh sách sản phẩm trong giỏ hàng của người dùng hiện tại.
     */
    public function index()
    {
        $userId = Auth::id();
        
        // Lấy giỏ hàng của người dùng và xác định giá dựa trên discount_price nếu có
        $cartItems = Cart::with(['product', 'productVariant'])
            ->where('user_id', $userId)
            ->get()
            ->map(function ($item) {
                if ($item->product_variant_id) {
                    // Sử dụng discount_price nếu có, nếu không thì sử dụng price từ productVariant
                    $item->price = $item->productVariant->discount_price ?? $item->productVariant->price;
                } else {
                    // Sử dụng discount_price nếu có, nếu không thì sử dụng price từ product
                    $item->price = $item->product->discount_price ?? $item->product->price;
                }
                return $item;
            });
    
        return response()->json([
            'message' => 'Lấy giỏ hàng thành công.',
            'data' => $cartItems
        ]);
    }

    /**
     * Thêm sản phẩm vào giỏ hàng.
     */
    public function store(Request $request): JsonResponse
    {
        $userId = Auth::id();

        $validatedData = $request->validate([
            'product_id' => 'nullable|exists:products,id',
            'product_variant_id' => 'nullable|exists:product_variants,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // Đảm bảo rằng chỉ một trong hai giá trị `product_id` hoặc `product_variant_id` được cung cấp.
        if (empty($validatedData['product_id']) && empty($validatedData['product_variant_id'])) {
            return response()->json([
                'error' => 'Vui lòng chọn sản phẩm hoặc biến thể.',
            ], 400);
        }

        $cartItem = Cart::where('user_id', $userId)
            ->where('product_id', $validatedData['product_id'])
            ->where('product_variant_id', $validatedData['product_variant_id'])
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $validatedData['quantity'];
            $cartItem->save();

            return response()->json([
                'message' => 'Cập nhật số lượng sản phẩm trong giỏ hàng thành công.',
                'data' => $cartItem,
            ], 200);
        }

        $newCartItem = Cart::create([
            'user_id' => $userId,
            'product_id' => $validatedData['product_id'],
            'product_variant_id' => $validatedData['product_variant_id'],
            'quantity' => $validatedData['quantity'],
        ]);

        return response()->json([
            'message' => 'Thêm sản phẩm vào giỏ hàng thành công.',
            'data' => $newCartItem,
        ], 201);
    }

    /**
     * Cập nhật số lượng sản phẩm trong giỏ hàng.
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $validatedData = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = Cart::find($id);

        if (!$cartItem) {
            return response()->json([
                'error' => 'Sản phẩm không tồn tại trong giỏ hàng.',
            ], 404);
        }

        if ($cartItem->user_id !== Auth::id()) {
            return response()->json([
                'error' => 'Bạn không có quyền cập nhật sản phẩm này.',
            ], 403);
        }

        $cartItem->update(['quantity' => $validatedData['quantity']]);

        return response()->json([
            'message' => 'Cập nhật số lượng sản phẩm thành công.',
            'data' => $cartItem,
        ], 200);
    }

    /**
     * Xóa sản phẩm khỏi giỏ hàng.
     */
    public function destroy(int $id): JsonResponse
    {
        $cartItem = Cart::find($id);

        if (!$cartItem) {
            return response()->json([
                'error' => 'Sản phẩm không tồn tại trong giỏ hàng.',
            ], 404);
        }

        if ($cartItem->user_id !== Auth::id()) {
            return response()->json([
                'error' => 'Bạn không có quyền xóa sản phẩm này.',
            ], 403);
        }

        $cartItem->delete();

        return response()->json([
            'message' => 'Xóa sản phẩm khỏi giỏ hàng thành công.',
        ], 200);
    }
}
