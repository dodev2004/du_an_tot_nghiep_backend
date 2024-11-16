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
        
        $averageRating = ProductReview::where('product_id', $id)->avg('rating');

        // Kiểm tra xem có tham số rating trong request hay không
        $query = ProductReview::where('product_id', $id)
            ->with([
                'user:id,username,avatar', 
                'comments:id,comment,created_at,review_id',
                'orderItem:id,variant'
            ]);

            if ($request->has('rating')) {
                $rating = $request->query('rating');
                $query->where('rating', '=', $rating);
            }

        // Phân trang với 10 kết quả mỗi trang
        $reviews = $query->paginate(10)->through(function ($review) {
            return [
                'id' => $review->id,
                'product_id' => $review->product_id,
                'user' => [
                    'avatar'=> $review->avatar,
                    'username' => $review->user->username,
                ],
                'rating' => $review->rating,
                'review' => $review->review,
                'created_at' => $review->created_at,
                'image' => $review->image ? asset('storage/' . $review->image) : null,
                'comments' => $review->comments->map(function ($comment) {
                    return [
                        'comment' => $comment->comment,
                        'created_at' => $comment->created_at,
                    ];
                }),
                'variant' => json_decode($review->orderItem->variant), 
            ];
        });

        return response()->json([
            'average_rating' => round($averageRating, 2), 
            'reviews' => $reviews,
        ]);
    }


    /**
     * Store a newly created review for a product.
     */
    public function store(Request $request, $orderItemId)
    {
        
        $validator = Validator::make($request->all(), [
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        $userId = Auth::id();

        // Kiểm tra xem sản phẩm thuộc về một đơn hàng đã hoàn thành của người dùng hay không
        $orderItem = OrderItem::whereHas('order', function ($query) use ($userId) {
            $query->where('customer_id', $userId)
                ->where('status', Order::STATUS_COMPLETED);
        })->find($orderItemId);

        if (!$orderItem) {
            return response()->json([
                'error' => 'This product is not part of a completed order or does not belong to you.',
            ], 403);
        }

        // Kiểm tra xem sản phẩm này đã được đánh giá chưa
        $existingReview = ProductReview::where('order_item_id', $orderItem->id)->exists();
        if ($existingReview) {
            return response()->json([
                'error' => 'You have already reviewed this product.',
            ], 403);
        }

        // Xử lý upload ảnh
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public'); 
        }

        // Tạo đánh giá mới
        $review = ProductReview::create([
            'order_item_id' => $orderItem->id, 
            'product_id' => $orderItem->product_id, 
            'user_id' => $userId,
            'rating' => $request->rating,
            'review' => $request->review,
            'image' => $imagePath, 
        ]);

        return response()->json([
            'message' => 'Review submitted successfully.',
            'review' => $review,
        ], 201);
    }


    /**
     * Show the details of a specific review.
     */
    public function show($id, $reviewId)
    {
        $review = ProductReview::with(['user:id,username,avatar', 'comments:id,review_id,comment,created_at'])
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
