<table class="table table-bordered">
    <thead>
        <tr>
            <!-- <th>STT</th> -->
            <th>Mã</th>
            <th>Loại giảm giá</th>
            <th>Giá trị giảm</th>
            <th>Giá trị giảm tối đa</th>
            <th>Giá trị đơn hàng tối thiểu</th>
            <th>Trạng thái</th>
            <th>Ngày bắt đầu</th>
            <th>Ngày kết thúc</th>
            <th>Số lượt sử dụng</th>
            <th>Số lượt đã sử dụng</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $index => $promotion)
        <tr>
            <!-- <td>{{ $index + 1 + ($data->currentPage() - 1) * $data->perPage() }}</td> -->
            <td>{{ $promotion->code }}</td>
            <td>{{ $promotion->discount_type == 'fixed' ? 'Cố định' : 'Phần trăm' }}</td>
            <td>{{ $promotion->discount_value ? number_format($promotion->discount_value) : 0 }}</td>
            <td>{{ $promotion->gia_tri_giam_toi_da ?  number_format($promotion->gia_tri_giam_toi_da ): 0 }}</td>
            <td>{{ $promotion->gt_don_hang_toi_thieu  ? number_format($promotion->gt_don_hang_toi_thieu) : 0}}</td>
            <td>
                <span class="badge {{ $promotion->status == 'active' ? 'badge-success' : 'badge-warning' }}">
                    {{ $promotion->status == 'active' ? 'Hoạt động' : 'Không hoạt động' }}
                </span>
            </td>
            <td>{{ $promotion->start_date}}</td>
            <td>{{ $promotion->end_date}}</td>
            <td>{{ $promotion->max_uses }}</td>
            <td>{{ $promotion->used_count }}</td>
            <td>
                <a class="btn btn-sm btn-info" href="{{ route('admin.promotions.edit', $promotion->id) }}">
                    <i class="fa fa-pencil"></i>
                </a>
                @if(auth()->user()->hasPermission('deletePromotion'))

                <form action="" method="POST" data-url="promotions" class="form-delete" style="display:inline;">
                    @method('DELETE')
                    @csrf
                    <input type="hidden" value="{{ $promotion->id }}" name="id">
                    <button class="btn btn-sm btn-warning" data-id="{{ $promotion->id }}">
                        <i class="fa-solid fa-trash"></i>
                    </button>
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

<div class="total_record text-right">
    <p>Tồn tại tổng <strong>{{$data->count()}}</strong> tại trang thứ <strong>{{$data->currentPage()}}</strong></p>
    <div class="pagination-wrapper text-right">
        {{ $data->appends(request()->input())->links() }}
    </div>
</div>
