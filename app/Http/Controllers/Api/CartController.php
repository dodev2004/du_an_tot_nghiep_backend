<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Cart;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        if (!Auth::guard('api')->check()) {
            return response()->json([
                'message' => 'Vui lòng đăng nhập để thực hiện hành động này.'
            ], 401); 
        }

       
        $validated = $request->validate([
            'product_variants_id' => 'required|exists:product_variants,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $user = Auth::guard('api')->user();

        $cart = Cart::updateOrCreate(
            ['user_id' => $user->id, 'product_variants_id' => $validated['product_variants_id']],
            ['quantity' => $validated['quantity']]
        );

        return response()->json([
            'message' => 'Sản phẩm đã được thêm vào giỏ hàng.',
            'cart' => $cart
        ], 200);
    }
}
