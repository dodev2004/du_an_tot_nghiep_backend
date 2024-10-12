<table class="table table-striped table-bordered ">
    <thead>
        <tr>
            <th></th>
            <th style="width: 200px" class="text-center">Hình ảnh</th>
            <th  class="text-center">Thông tin sản phẩm</th>
            <th class="text-center">Ngày tạo</th>
            <th class="text-center">Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($products as $index => $product)
            <tr>
                <td>
                   {{$index +1}}
                </td>
                <td>
                    <img src="{{ asset($product->image_url) }}" alt="{{ $product->name }}" width="50">
                </td>
                <td>
                    <strong>Tên sản phẩm:</strong> {{ $product->catelogues ?  implode(",",$product->catelogues) : 'N/A' }}<br>
                    <strong>Danh mục:</strong> {{ $product->catelogues ?  implode(",",$product->catelogues) : 'N/A' }}<br>
                    <strong>Nhãn hàng:</strong> {{ $product->brand->name ?? 'N/A' }}<br>
                    <strong>Giá:</strong> {{ $product->display_price }}<br>
                    <strong>Tồn kho:</strong> {{ $product->display_stock }}
                </td>
                <td>{{ $product->created_at->format('d/m/Y') }}</td>
                <td class="text-center">
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
