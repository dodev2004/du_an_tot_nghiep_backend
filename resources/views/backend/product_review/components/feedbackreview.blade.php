@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<!-- Chi tiết đánh giá -->
<div class="review-list">
    @forelse ($data as $review)
        <div class="review-details">
            <p><strong>Mã sản phẩm:</strong> {{ $review->product->sku ?? 'N/A' }}</p>
            <p><strong>Tên sản phẩm:</strong> {{ $review->product->name ?? 'N/A' }}</p>
            <p><strong>Người dùng đánh giá:</strong> {{ $review->user->username ?? 'N/A' }}</p>
            <p><strong>Đánh giá:</strong> {{ $review->review ?? 'N/A' }}</p>
            <p><strong>Số sao:</strong> 
                @for($i = 1; $i <= 5; $i++)
                    @if($i <= $review->rating)
                        <i class="fas fa-star text-warning"></i> <!-- Sao sáng (vàng) -->
                    @else
                        <i class="far fa-star text-secondary"></i> <!-- Sao tối (màu xám) -->
                    @endif
                @endfor
            </p>
        </div>
    @empty
        <p>Không có đánh giá nào cho sản phẩm này.</p>
    @endforelse
</div>

        <!-- Form để thêm bình luận mới cho đánh giá -->
        <div class="add-comment">
        <h3>Phản hồi:</h3>
        <form action="{{ route('product_comment.store', ['id' => $reviews->id]) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="comment">Bình luận:</label>
                <textarea name="comment" id="comment" class="form-control" rows="3" placeholder="Nhập bình luận của bạn" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Gửi bình luận</button>
        </form>
    </div>

