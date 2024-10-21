<table class="table table-bordered">
    <thead>
        <tr>
            <th>STT</th>
            <th>Tên vai trò</th>
            <th>Mô tả</th>
            <th>Quyền hạn</th>
            <th>Trạng thái</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($roles as $key => $role)
            <tr>
                <td>
                    <p style="margin-bottom: 0;font-weight: 600;font-size: 14px;">{{ $role->id }}</p>
                </td>
                <td>
                    <p style="margin-bottom: 0;font-weight: 600;font-size: 14px;">{{ $role->name }}</p>
                </td>
                <td>
                    <p style="margin-bottom: 0;font-weight: 600;font-size: 14px;">{{ $role->description }}</p>
                </td>
                <td>
                    @foreach ($role->permissions as $permission)
                        <span class="badge badge-info">{{ $permission->name }}</span>
                    @endforeach
                </td>

                <td class="text-center">
                    <form name="form_status" action="">
                        @csrf
                        <input type="hidden" name="attribute" value="status">
                        <input type="hidden" name="table" value="{{$table}}">
                        <input type="checkbox" data-id="{{ $role->id }}"
                            @if ($role['status'] == 1) checked @endif
                            class="js-switch js-switch_{{ $role->id }}" style="display: none;"
                            data-switchery="true">
                    </form>

                </td>

                <th class="text-center">
                    <div style="display: flex; justify-content: center;column-gap: 5px;">
                        <a class="btn btn-sm btn-info" href="{{ route('admin.role.edit', $role->id) }}"><i
                                class="fa fa-paste"></i> Sửa</a>
                        {{-- <a class="btn btn-sm btn-info" href="{{ route('admin.role.show', $role->id) }}"><i
                            class="fa fa-paste"></i> Chi tiết</a> --}}
                        <form action="" method="POST" data-url="role" class="form-delete">
                            @method('DELETE')
                            @csrf
                            <input type="hidden" value="{{ $role->id }}" name="id">
                            <button class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i> Xóa</button>
                        </form>
                    </div>
                </th>
            </tr>
        @endforeach
    </tbody>
</table>
