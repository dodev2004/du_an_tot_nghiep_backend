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
                    data-stock="{{ $comment->product->stock }}" data-weight="{{ $comment->product->weight }}"
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
                <form action="" method="POST" data-url="product-comment" style="text-align: center;"
                    class="form-delete">
                    @method("DELETE")
                    @csrf
                    <input type="hidden" value="{{$comment->id}}" name="id">
                    <button class="btn btn-warning center" data-toggle="tooltip" data-placement="top" title="Xóa"><i
                            class="fa fa-trash-o"></i></button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- Modal -->
<div class="modal fade" id="productDetailModal" tabindex="-1" role="dialog" aria-labelledby="productDetailModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style=" width: 800px;">
            <div>
                <h5 id="productDetailModalLabel" style="font-size: 16px; padding: 10px">Chi Tiết Sản Phẩm</h5>
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> -->
                <hr>
            </div>
            <div style="display: grid; grid-template-columns:40% 60%; padding: 10px">
                <div style="text-align: center">
                    <div><strong>Hình ảnh:</strong></div>
                    <div><img id="productImage" src="" alt="Hình ảnh sản phẩm" width="77%" /></div>
                </div>
                <div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr ; gap: 10px">
                        <div>
                            <div><strong>Tên sản phẩm:</strong></div>
                            <div
                                style="border: 1px solid #ccc; padding: 8px; width: 100%; background-color: #f9f9f9;border-radius: 5px">
                                <span id="productName"></span>
                            </div>
                        </div>
                        <div>
                            <div><strong>Giá:</strong></div>
                            <div style="border: 1px solid #ccc; padding: 8px; width: 100%; background-color:
                                #f9f9f9;border-radius: 5px"><span id="productPrice"></span></div>
                        </div>
                    </div>
                    <div style="margin-top: 10px;display: grid; grid-template-columns: 1fr 1fr ; gap: 10px">
                        <div>
                            <div><strong>Giá khuyến má:</strong></div>
                            <div style="border: 1px solid #ccc; padding: 8px; width:100%; background-color:
                                #f9f9f9;border-radius: 5px"><span id="productDiscountPrice"></span></div>
                        </div>
                        <div>
                            <div><strong>Tồn kho:</strong></div>
                            <div style="border: 1px solid #ccc; padding: 8px; width: 100%; background-color:
                                #f9f9f9;border-radius: 5px"><span id="productStock"></span></div>
                        </div>
                    </div>
                    <div style="margin-top: 10px;display: grid; grid-template-columns: 1fr 1fr ; gap: 10px">
                        <div>
                            <div><strong>Cân nặng:</strong></div>
                            <div style="border: 1px solid #ccc; padding: 8px; width: 100%; background-color:
                                #f9f9f9;border-radius: 5px"><span id="productWeight"></span></div>
                        </div>
                        <div>
                            <div><strong>Đánh giá trung bình:</strong></div>
                            <div style="border: 1px solid #ccc; padding: 8px; width: 100%; background-color:
                                #f9f9f9;border-radius: 5px"><span id="productRatingsAvg"></span></div>
                        </div>
                    </div>
                    <div style="margin-top: 10px;display: grid; grid-template-columns: 1fr 1fr ; gap: 10px">
                        <div>
                            <div><strong>Số lượng đánh giá:</strong></div>
                            <div style="border: 1px solid #ccc; padding: 8px; width: 100%; background-color:
                                #f9f9f9;border-radius: 5px"><span id="productRatingsCount"></span></div>
                        </div>
                        <div>
                            <div><strong>Trạng thái:</strong></div>
                            <div style="border: 1px solid #ccc; padding: 8px; width: 100%; background-color:
                                #f9f9f9;border-radius: 5px"><span id="productStatus"></span></div>
                        </div>
                    </div>
                    <div style="margin-top: 10px">
                        <div><strong>Mô tả:</strong></div>
                        <div><textarea readonly style=" border : 1px solid #ccc;background-color:
                                #f9f9f9;border-radius: 5px; padding: 8px; width: 100%; height: 150px ; overflow: auto">
                                </textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
