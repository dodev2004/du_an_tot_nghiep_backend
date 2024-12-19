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
            ->where('status', 1)
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
                    'avatar'=> $review->user->avatar,
                    'username' => $review->user->username,
                ],
                'rating' => $review->rating,
                'review' => $review->review,
                'created_at' => $review->created_at,
                'comments' => $review->comments->map(function ($comment) {
                    return [
                        'comment' => $comment->comment,
                        'created_at' => $comment->created_at,
                    ];
                }),
                'variant' => $review->orderItem->variant, 
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
        // Xác thực dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $orderItem = OrderItem::findOrFail($orderItemId);
        $product = $orderItem->product;

        // Kiểm tra nếu sản phẩm của đơn hàng này đã được đánh giá bởi user hiện tại
        $existingReview = ProductReview::where('order_item_id', $orderItemId)
        ->where('user_id', Auth::id())
        ->first();

        if ($existingReview) {
            return response()->json([
                'message' => 'Bạn đã đánh giá sản phẩm này rồi.',
            ], 409); // HTTP 409 Conflict
        }
        // Tạo review mới
        $review = ProductReview::create([
            'order_item_id' => $orderItemId, 
            'product_id' => $product->id,
            'user_id' => Auth::id(),
            'rating' => $request->rating,
            'review' => $request->review,
            'status' => 1,
        ]);

        DB::transaction(function () use ($product) {
            $ratingsData = $product->product_reviews()
                ->selectRaw('SUM(rating) as total_ratings, COUNT(*) as total_reviews')
                ->first();
    
            $product->update([
                'ratings_avg' => $ratingsData->total_reviews > 0 
                    ? $ratingsData->total_ratings / $ratingsData->total_reviews 
                    : 0,
                'ratings_count' => $ratingsData->total_reviews,
            ]);
        });
        
        return response()->json([
            'message' => 'Đã gửi đánh giá thành công.',
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
