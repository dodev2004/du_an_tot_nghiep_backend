<table class="table table-bordered">
    <thead>
        <tr>
            <!-- <th>STT</th> -->
            <th>Tên nhãn hàng</th>
            <th>Miêu tả</th>
            <th>Ngày xóa</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $index=> $item)
        <tr>
            <!-- <td>{{ $index+1 }}</td> -->
            <td>{{ $item->name }}</td>
            <td>{{ $item->description }}</td>
            <td>{{ $item->deleted_at }}</td>
            <td>
                <form action="{{ route('admin.brand.restore', $item->id) }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-success"><i class="fa fa-undo"></i></button>
                </form>
                @if(auth()->user()->hasPermission('forceDeleteBrand'))

                <form action="" method="POST" data-url="brand" class="form-delete" style="display: inline;">
                    @method('DELETE')
                    @csrf
                    <input type="hidden" value="{{ $item->id }}" name="id">
                    <button class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i></button>
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
