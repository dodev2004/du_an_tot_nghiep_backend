@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<!-- Chi tiết đánh giá -->
<div class="review-details">
        <p><strong>Mã sản phẩm:</strong> {{ $reviews->product->sku }}</p>
        <p><strong>Tên sản phẩm:</strong> {{ $reviews->product->name }}</p>
        <p><strong>Người dùng đánh giá:</strong> {{ $reviews->user->username }}</p>
        <p><strong>Đánh giá:</strong> {{ $reviews->review }}</p>
        <p><strong>Số sao:</strong> 
            @for($i = 1; $i <= 5; $i++)
                @if($i <= $reviews->rating)
                    <i class="fas fa-star text-warning"></i> <!-- Sao sáng (vàng) -->
                @else
                    <i class="far fa-star text-secondary"></i> <!-- Sao tối (màu xám) -->
                @endif
            @endfor
        </p>
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

