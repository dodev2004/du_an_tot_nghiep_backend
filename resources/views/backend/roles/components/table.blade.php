<table class="table table-bordered">
    <thead>
        <tr>
            <!-- <th>STT</th> -->
            <th>Tên vai trò</th>
            <th>Mô tả</th>
            <th>Quyền hạn</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($roles as $key => $role)
            <tr>
                <!-- <td>
                    <p style="margin-bottom: 0;font-weight: 600;font-size: 14px;">{{ $role->id }}</p>
                </td> -->
                <td>
                    <p style="margin-bottom: 0;font-weight: 600;font-size: 14px;">{{ $role->name }}</p>
                </td>
                <td>
                    <p style="margin-bottom: 0;font-weight: 600;font-size: 14px;">{{ $role->description }}</p>
                </td>
                <td>
                    @foreach ($role->permissions as $permission)
                        <span class="badge badge-info" style="padding: 8px">{{ $permission->name }}</span>
                    @endforeach
                </td>
                <th class="text-center">
                    <div style="display: flex; justify-content: center;column-gap: 5px;">
                        <a class="btn btn-sm btn-info" href="{{ route('admin.role.edit', $role->id) }}" data-toggle="tooltip" data-placement="top" title="Sửa thông tin"><i class="fa fa-pencil"></i></a>
                        {{-- <a class="btn btn-sm btn-info" href="{{ route('admin.role.show', $role->id) }}"><i
                            class="fa fa-paste"></i> Chi tiết</a> --}}
                        <form action="" method="POST" data-url="role" class="form-delete">
                            @method('DELETE')
                            @csrf
                            <input type="hidden" value="{{ $role->id }}" name="id">
                            <button class="btn btn-sm btn-danger"data-toggle="tooltip" data-placement="top" title="Xóa"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </div>
                </th>
            </tr>
        @endforeach
    </tbody>
</table>
