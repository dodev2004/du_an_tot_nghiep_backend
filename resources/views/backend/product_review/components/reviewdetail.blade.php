<table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>Mã sản phẩm</th>
                <th>tên Sản phẩm</th>
                <th>Đánh giá</th>
                <th>Số sao</th>
                <th>Ngày</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $review)
            <tr>
                <td>
                    <a class="product" data-toggle="tooltip" data-placement="top" title="Chi tiết sản phẩm"
                        data-name="{{ $review->product->name }}"
                        data-description="{{ $review->product->detailed_description }}"
                        data-price="{{ $review->product->price }}"
                        data-discount-price="{{ $review->product->discount_price }}"
                        data-stock="{{ $review->product->stock }}" data-weight="{{ $review->product->weight }}"
                        data-ratings-avg="{{ $review->product->ratings_avg }}"
                        data-ratings-count="{{ $review->product->ratings_count }}"
                        data-status="{{ $review->product->status }}"
                        data-image-url="{{ asset($review->product->image_url) }}">

                        {{ $review->product->sku }}
                    </a>
                </td>
                <td>{{ $review->product->name }}</td>
                <td>{{ $review->review }}</td>
                <td>{{ $review->rating }}*</td>
                <td>{{ $review->created_at->format('d/m/Y') }}</td>
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
