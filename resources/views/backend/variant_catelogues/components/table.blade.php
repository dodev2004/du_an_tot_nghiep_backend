<table class="table table-bordered">
    <thead>
        <tr>

            <th>Danh mục thuộc tính</th>
            <th class="text-center">Chỉnh sửa</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $item)
        <tr>

            <td>
                <p style="margin-bottom: 0;font-weight: 600;font-size: 14px;">{{ $item->name }}</p>
            </td>

            <td style="text-align: center">
                <div style="display: flex; justify-content: center;column-gap: 5px;">
                    <a class="btn btn-sm btn-info" href="{{route("admin.variant_catelogue.edit",$item->id) }}"><i class="fa fa-pencil"></i> </a>
                    @if(auth()->user()->hasPermission('deleteVariantCatelogue'))

                    <form action="" method="POST" data-url="variant-catelogue" class="form-delete">
                        @method("DELETE")
                        @csrf
                        <input type="hidden" value="{{$item->id}}" name="id">
                        <button class="btn btn-warning center" data-toggle="tooltip" data-placement="top" title="Xóa"><i class="fa fa-trash-o"></i> </button>
                    </form>
                    @else
                        <a href="{{ route('permission.denied') }}" class="btn btn-warning center" title="Không có quyền">
                            <i class="fa fa-trash-o"></i>
                        </a> {{-- Hiển thị nút xóa nhưng không cho phép --}}
                        @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<p>Tồn tại tổng <strong>{{$data->count()}}</strong> tại trang thứ <strong>{{$data->currentPage()}}</strong></p>
