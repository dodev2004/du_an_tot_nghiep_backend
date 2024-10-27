<table class="table table-bordered">
    <thead>
        <tr>
            <th>STT</th>
            <th>Họ và tên</th>
            <th>Email</th>
            <th>Số điện thoại</th>
            <th>Địa chỉ</th>
            <th>Vai trò</th>
            <th>Trạng thái</th>
            <th class="text-center">Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $index => $user)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $user->full_name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->phone ? $user->phone : 'Dữ liệu chưa có' }}</td>
            <td>{{ $user->address ? $user->address : 'Dữ liệu chưa có' }}</td>
            <td>
                @if ($user->roles->isNotEmpty())

                @foreach ($user->roles as $role)
                <span class="badge badge-info">{{ $role->name }}</span>
                @endforeach

                @else
                Không có vai trò
                @endif
            </td>
            <td>
                <form name="form_status" action="">
                    @csrf
                    <input type="hidden" name="attribute" value="status">
                    <input type="hidden" name="table" value="{{ $table }}">
                    <input type="checkbox" @if ($user->status == 1) checked @endif
                    data-id="{{ $user->id }}" class="js-switch js-switch_{{ $user->id }}"
                    style="display: none;" data-switchery="true">
                </form>

            </td>
            <td>
                <div class="" style="display:flex;justify-content: center;column-gap: 12px">
                    <a class="btn btn-sm btn-info" href="{{ route('admin.users.edit', $user->id) }}" title="Chỉnh sửa"><i
                            class="fa fa-pencil"></i></a>
                    <form action="" method="POST" data-url="users" class="form-delete">
                        @method('DELETE')
                        @csrf
                        <input type="hidden" value="{{ $user->id }}" name="id">
                        <button class="btn btn-warning center" title="Xóa"><i class="fa fa-trash-o"></i></button>
                    </form>
                </div>


            </td>
        </tr>
        @endforeach

    </tbody>

</table>