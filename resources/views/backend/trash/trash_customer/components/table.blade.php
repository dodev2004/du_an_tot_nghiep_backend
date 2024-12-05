<table class="table table-bordered">
    <thead>
        <tr>
            <th>Tài khoản</th>
            <th>Họ và tên</th>
            <th>Email</th>
            <th>Số điện thoại</th>
            <th>Địa chỉ</th>
            <th>Ngày xóa</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $index=> $item)
        <tr>

            <td>{{ $item->username }}</td>
                <td>{{ $item->full_name }}</td>
                <td>{{ $item->email }}</td>
                <td>{{ $item->phone ? $item->phone : 'Dữ liệu chưa có' }}</td>
                <td>{{ $item->address ? $item->address : 'Dữ liệu chưa có' }}</td>
            <td>{{ $item->deleted_at }}</td>
            <td>
                <form action="{{ route('admin.customer.restore', $item->id) }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-success"><i class="fa fa-undo"></i></button>
                </form>
                @if(auth()->user()->hasPermission('deleteCustomer'))

                <form action="" method="POST" data-url="customer" class="form-delete" style="display: inline;">
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
