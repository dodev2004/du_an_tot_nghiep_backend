<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id, Request $request)
    {
        // Kiểm tra xem có tham số rating trong request hay không
    $query = ProductReview::where('product_id', $id)
    ->with(['user:id,username', 'comments:id,comment,created_at,review_id']); // Chỉ lấy các trường cần thiết

    // Nếu có tham số rating, thêm điều kiện lọc
    if ($request->has('rating')) {
        $minRating = $request->query('rating');
        $query->where('rating', '>=', $minRating);
    }

    // Phân trang với 10 kết quả mỗi trang
    $reviews = $query->paginate(10)->through(function ($review) {
        return [
            'id' => $review->id,
            'product_id' => $review->product_id,
            'user' => [
                'username' => $review->user->username,
            ],
            'rating' => $review->rating,
            'review' => $review->review,
            'created_at' => $review->created_at,
            'image' => $review->image, // Sử dụng image thay vì media
            'comments' => $review->comments->map(function ($comment) {
                return [
                    'comment' => $comment->comment,
                    'created_at' => $comment->created_at,
                ];
            }),
        ];
    });

        return response()->json($reviews);
    }

    /**
     * Store a newly created review for a product.
     */
    public function store(Request $request, $id)
    {
        // Xác thực dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'rating' => 'required|integer|min:1|max:5', // Đánh giá từ 1 đến 5
            'review' => 'nullable|string', // Đánh giá có thể để trống
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Kiểm tra xem người dùng đã mua sản phẩm này chưa
        $userId = Auth::id();
        // Kiểm tra xem người dùng có đơn hàng đã hoàn thành cho sản phẩm này không
        $hasPurchased = OrderItem::whereHas('order', function ($query) use ($userId) {
            $query->where('customer_id', $userId)
                ->where('status', Order::STATUS_COMPLETED);
        })->where('product_id', $id)
          ->exists();

        // Xử lý upload ảnh và lưu đường dẫn
        $imagePath = null;
        if ($request->hasFile('image')) {
            // Lưu hình ảnh vào thư mục 'public/images'
            $imagePath = $request->file('image')->store('images', 'public');
        }
        // Tạo đánh giá mới
        $review = ProductReview::create([
            'product_id' => $id,
            'user_id' => $userId,
            'rating' => $request->rating,
            'review' => $request->review,
            'image' => $imagePath,
        ]);

        return response()->json($review, 201); // Trả về đánh giá vừa tạo
    }

    /**
     * Show the details of a specific review.
     */
    public function show($id, $reviewId)
    {
        $review = ProductReview::with(['user:id,username', 'comments:id,review_id,comment,created_at'])
            ->where('product_id', $id)
            ->findOrFail($reviewId);

        return response()->json($review);
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
