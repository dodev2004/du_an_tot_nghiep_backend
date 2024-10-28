<table class="table table-bordered">
    <thead>
        <tr>
            <th>Mã sản phẩm</th>
            <th>Tên sản phẩm</th>
            <th>Số lượng bình luận</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $product)
            <tr>
                <td>
                    <a class="product" data-toggle="tooltip" data-placement="top" title="Chi tiết sản phẩm"
                        data-name="{{ $product->name ?? ''}}"
                        data-description="{{ $product->detailed_description ?? ''}}"
                        data-price="{{ $product->price ?? '' }}"
                        data-discount-price="{{ $product->discount_price ?? '' }}"
                        data-stock="{{ $product->stock ?? ''}}" 
                        data-weight="{{ $product->weight ?? '' }}"
                        data-ratings-avg="{{ $product->ratings_avg ?? ''}}"
                        data-ratings-count="{{ $product->ratings_count ?? ''}}"
                        data-status="{{ $product->status ?? ''}}"
                        data-image-url="{{ asset($product->image_url) ?? ''}}">

                        {{ $product->sku }}
                    </a>
                    
                </td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->product_comments_count }}</td> 
                <td>
                    <center><a class="btn btn-sm btn-info" href="{{ route('admin.product_comment.user_comments', $product->id) }}" data-toggle="tooltip" data-placement="top" title="Xem chi tiết"><i class="fa fa-paste"></i></a></center>
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
                        <div><textarea id="productDescription" readonly style=" border : 1px solid #ccc;background-color:
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

