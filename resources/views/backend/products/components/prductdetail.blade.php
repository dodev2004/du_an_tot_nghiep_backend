<div class="container mt-4">
    <div class="row" style="align-items: center;">
        <div class="col-md-5 " style="align-items: center;">
        <img src="{{ asset($product->image_url) }}" alt="{{ $product->name }}" width="100%">
        </div>

        <div class="col-md-7">
            <table class="table table-borderless">
                <tbody>
                    <tr>
                        <th>Danh mục</th>
                        <td>{{ $product->catelogues ? implode(',',$product->catelogues) : 'Chưa có danh mục' }}</td>
                    </tr>
                    <tr>
                        <th>Nhãn hàng</th>
                        <td>{{ $product->brand->name ?? ''}}</td>
                    </tr>
                    <tr>
                        <th>Trọng lượng</th>
                        <td>{{ $product->weight }}Kg</td>
                    </tr>
                    <tr>
                        <th>Mã SKU</th>
                        <td>{{ $product->sku }}</td>
                    </tr>
                    <tr>
                        <th>Mô tả</th>
                        <td>{{ $product->detailed_description }}</td>
                    </tr>
                    <tr>
                        <th>Giá</th>
                        <td>
                            @if($product->discount_price && $product->discount_price < $product->price)
                                <span class="text-muted"><s>{{ number_format($product->price, 0, ',', '.') }} VND</s></span>
                                <span class="text-danger font-weight-bold ml-2">{{ number_format($product->discount_price, 0, ',', '.') }} VND</span>
                            @else
                                <span class="text-danger font-weight-bold">{{ number_format($product->price, 0, ',', '.') }} VND</span>
                            @endif
                        </td>
                    <tr>
                        <th>Tồn kho</th>
                        <td>{{ $product->stock }}</td>
                    </tr>
                </tbody>
            </table>

            <h5 class="font-weight-bold mt-4">Phiên bản:</h5>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>SKU</th>
                        <th>Giá</th>
                        <th>Giảm giá</th>
                        <th>Tồn kho</th>
                        <th>Thuộc tính</th>
                    </tr>
                </thead>
                <tbody>
                    @if($product->variants && count($product->variants) > 0)
                        @foreach($product->variants as $variant)
                            <tr>
                                <td>{{ $variant->sku }}</td>
                                <td>{{ number_format($variant->price, 0, ',', '.') }} VND</td>
                                <td>{{ number_format($variant->discount, 0, ',', '.') }} VND</td>
                                <td>{{ $variant->stock }}</td>
                                <td>
                                {{ $variant->attributeValues->pluck('name')->implode(', ') }}
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5">Không có phiên bản nào.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
