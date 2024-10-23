<table class="table table-striped table-bordered ">
    <thead>
        <tr>
            <th class="text-center">STT</th>
            <th style="width: 200px" class="text-center">Hình ảnh</th>
            <th class="text-center">Thông tin sản phẩm</th>
            <th class="text-center">Ngày tạo</th>
            <th class="text-center">Trạng thái</th>
            <th class="text-center">Nổi bật</th>
            <th class="text-center">Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($products as $index => $product)
            <tr>
                <td>
                    {{ $index + 1 }}
                </td>
                <td>
                    <img src="{{ asset($product->image_url) }}" alt="{{ $product->name }}" width="50">
                </td>
                <td>
                    <strong>Tên sản phẩm:</strong> {{ $product->name ? $product->name : 'N/A' }}<br>
                    <strong>Danh mục:</strong>
                    {{ $product->catelogues ? implode(',', $product->catelogues) : 'N/A' }}<br>
                    <strong>Nhãn hàng:</strong> {{ $product->brand->name ?? 'N/A' }}<br>
                    <strong>Giá:</strong> {{ $product->display_price }}<br>
                    <strong>Tồn kho:</strong> {{ $product->display_stock }}
                </td>
                <td>{{ $product->created_at->format('d/m/Y') }}</td>
                <td class="text-center">
                    <form name="form_status" action="">
                        @csrf
                        <input type="hidden" name="attribute" value="status">
                        <input type="hidden" name="table" value="{{$table}}">
                        <input type="checkbox"  data-id="{{$product["id"]}}" @if($product["status"] == 1) checked @endif class="js-switch js-switch_{{$product["id"]}}"  style="display: none;" data-switchery="true">
                    </form>
                </td>
                <td class="text-center">
                    <form name="form_status" action="">
                        @csrf
                        <input type="hidden" name="attribute" value="is_featured">
                        <input type="hidden" name="table" value="{{$table}}">
                        <input type="checkbox"  data-id="{{$product["id"]}}" @if($product["is_featured"] == 1) checked @endif class="js-switch js-switch_{{$product["id"]}}"  style="display: none;" data-switchery="true">
                    </form>
                </td>
                <td style="text-align: center">
                    <div style="display: flex; justify-content: center;column-gap: 5px;">

                        <a href="{{ route('admin.product.edit',$product->id) }}" class="btn btn-info"><i
                                class="fa fa-pencil"></i></a>
                        <form action="" method="POST" data-url="product" class="form-delete">
                            @method('DELETE')
                            @csrf
                            <input type="hidden" value="{{$product->id }}" name="id">
                            <button class="btn btn-warning center"><i class="fa fa-trash-o"></i></button>
                        </form>
                    </div>

                </td>
            </tr>
        @endforeach
    </tbody>
</table>
