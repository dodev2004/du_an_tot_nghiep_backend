<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $favorites = Favorite::where('user_id', $user->id)
            ->with('product')
            ->get();

        return response()->json($favorites);
    }

    /**
     * toggleFavorite(Thêm/Xóa).
     */
    public function toggleFavorite(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $user = Auth::user();
        $product_id = $request->product_id;

        // Kiểm tra nếu sản phẩm đã có trong danh sách yêu thích
        $existingFavorite = Favorite::where('user_id', $user->id)
            ->where('product_id', $product_id)
            ->first();

        if ($existingFavorite) {
            // Nếu đã có, xóa sản phẩm khỏi danh sách yêu thích
            $existingFavorite->delete();
            return response()->json(['message' => 'Đã xóa sản phẩm khỏi danh sách yêu thích'], 200);
        } else {
            // Nếu chưa có, thêm sản phẩm vào danh sách yêu thích
            $favorite = Favorite::create([
                'user_id' => $user->id,
                'product_id' => $product_id,
            ]);
            return response()->json(['message' => 'Đã thêm sản phẩm vào danh sách yêu thích', 'data' => $favorite], 201);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
