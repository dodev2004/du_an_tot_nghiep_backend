<table class="table table-bordered">
    <thead>
        <tr>
            <th>Sản phẩm</th>
            <th>Bình luận</th>
            <th>Ngày tạo</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $comment)
            <tr>
                <td>
                    <a class="product" data-toggle="tooltip" data-placement="top" title="Chi tiết sản phẩm"
                        data-name="{{ $comment->product->name }}" 
                        data-description="{{ $comment->product->detailed_description }}" 
                        data-price="{{ $comment->product->price }}" 
                        data-discount-price="{{ $comment->product->discount_price }}" 
                        data-stock="{{ $comment->product->stock }}" 
                        data-weight="{{ $comment->product->weight }}" 
                        data-ratings-avg="{{ $comment->product->ratings_avg }}" 
                        data-ratings-count="{{ $comment->product->ratings_count }}" 
                        data-status="{{ $comment->product->status }}" 
                        data-image-url="{{ asset($comment->product->image_url) }}">
                        {{ $comment->product->name }}
                    </a>
                </td>
                <td>{{ $comment->comment }}</td>
                <td>{{ $comment->created_at }}</td>
                
                <td>
                    <form action="" method="POST" data-url="product-comment" style="text-align: center;" class="form-delete">
                        @method("DELETE")
                        @csrf
                        <input type="hidden" value="{{$comment->id}}" name="id">
                        <button class="btn btn-warning center" data-toggle="tooltip" data-placement="top" title="Xóa"><i class="fa fa-trash-o"></i></button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<!-- Modal -->
<div class="modal fade" id="productDetailModal" tabindex="-1" role="dialog" aria-labelledby="productDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productDetailModalLabel">Chi Tiết Sản Phẩm</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4"><strong>Tên sản phẩm:</strong></div>
                    <div class="col-md-8"><span id="productName"></span></div>
                </div>
                <div class="row">
                    <div class="col-md-4"><strong>Mô tả:</strong></div>
                    <div class="col-md-8"><span id="productDescription"></span></div>
                </div>
                <div class="row">
                    <div class="col-md-4"><strong>Giá:</strong></div>
                    <div class="col-md-8"><span id="productPrice"></span></div>
                </div>
                <div class="row">
                    <div class="col-md-4"><strong>Giá khuyến mãi:</strong></div>
                    <div class="col-md-8"><span id="productDiscountPrice"></span></div>
                </div>
                <div class="row">
                    <div class="col-md-4"><strong>Tồn kho:</strong></div>
                    <div class="col-md-8"><span id="productStock"></span></div>
                </div>
                <div class="row">
                    <div class="col-md-4"><strong>Cân nặng:</strong></div>
                    <div class="col-md-8"><span id="productWeight"></span></div>
                </div>
                <div class="row">
                    <div class="col-md-4"><strong>Đánh giá trung bình:</strong></div>
                    <div class="col-md-8"><span id="productRatingsAvg"></span></div>
                </div>
                <div class="row">
                    <div class="col-md-4"><strong>Số lượng đánh giá:</strong></div>
                    <div class="col-md-8"><span id="productRatingsCount"></span></div>
                </div>
                <div class="row">
                    <div class="col-md-4"><strong>Trạng thái:</strong></div>
                    <div class="col-md-8"><span id="productStatus"></span></div>
                </div>
                <div class="row">
                    <div class="col-md-4"><strong>Hình ảnh:</strong></div>
                    <div class="col-md-8"><img id="productImage" src="" alt="Hình ảnh sản phẩm" style="max-width: 100px;" /></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
