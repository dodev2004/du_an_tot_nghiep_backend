<table class="table table-bordered">
    <thead>
        <tr>
            <!-- <th>ID</th> -->
            <th>Tiêu đề</th>
            <th>Tên người dùng</th>
            <th>Email</th>
            <th>Địa chỉ</th>
            <th>Số điện thoại</th>
            <th>Trạng thái</th>
            <th class="text-center">Chỉnh sửa</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $item)
            <tr>
                <td>
                    <p style="margin-bottom: 0;font-weight: 600;font-size: 14px;">{{ $loop->iteration }}</p>
                </td>
                <td>
                    <p style="margin-bottom: 0;font-weight: 600;font-size: 14px;">{{ $item->title }}</p>
                </td>
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
                    <p style="margin-bottom: 0;font-weight: 600;font-size: 14px;">

                        @if ($item->status == 0)
                            <div class="icon-container">
                                <p style="margin-bottom: 0;font-weight: 600;font-size: 14px;"><i
                                        class="fas fa-hourglass-start text-warning"></i></p>
                            </div>
                        @elseif ($item->status == 1)
                            <div class="icon-container">
                                <p style="margin-bottom: 0;font-weight: 600;font-size: 14px;"><i
                                        class="fas fa-check-circle text-success"></i></p>
                            </div>
                        @endif

                    </p>
                </th>

                <th class="text-center">

                    <a class="btn btn-sm btn-info" href="{{ route('admin.contact.edit', $item->id) }}"><i
                            class="fa fa-paste"></i> Phản hồi</a>
                    {{-- <form action="" method="POST" data-url="contact" class="form-delete">
                        @method('DELETE')
                        @csrf
                        <input type="hidden" value="{{ $item->id }}" name="id">
                <button class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Xóa"><i
                        class="fa-solid fa-trash"></i> Xóa</button>
                </form> --}}
            </th>
        </tr>
        @endforeach
    </tbody>
</table>