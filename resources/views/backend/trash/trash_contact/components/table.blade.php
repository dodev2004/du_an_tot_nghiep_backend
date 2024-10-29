<table class="table table-bordered">
    <thead>
        <tr>
            <th>Tên người dùng</th>
            <th>Email</th>
            <th>Địa chỉ</th>
            <th>Số điện thoại</th>
            <th>Nội dung</th>
            <th>Ngày xóa</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $index=> $item)
        <tr>
            <td>
                    <p style="margin-bottom: 0;font-weight: 600;font-size: 14px;">{{ $item->user->full_name }}</p>
                </td>
                <th>
                    <p style="margin-bottom: 0;font-weight: 600;font-size: 14px;">{{ $item->user->email }}</p>
                </th>
                <th>
                    <p style="margin-bottom: 0;font-weight: 600;font-size: 14px;">{{ $item->user->address }}</p>
                </th>
                <th>
                    <p style="margin-bottom: 0;font-weight: 600;font-size: 14px;">{{ $item->user->phone }}</p>
                </th>
                <th>
                    <p
                        style="margin-bottom: 0; font-weight: 600; font-size: 14px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; width: 200px;">
                        {{ $item->content }}
                    </p>
                </th>
                <th>
                    <p style="margin-bottom: 0;font-weight: 600;font-size: 14px;">{{ $item->deleted_at }}</p>
                </th>
            <td>
                <form action="{{ route('admin.contact.restore', $item->id) }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-success"><i class="fa fa-undo"></i></button>
                </form>
                <form action="" method="POST" data-url="contact" class="form-delete" style="display: inline;">
                    @method('DELETE')
                    @csrf
                    <input type="hidden" value="{{ $item->id }}" name="id">
                    <button class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i></button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
