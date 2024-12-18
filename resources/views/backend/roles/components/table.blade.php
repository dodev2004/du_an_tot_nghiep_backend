<table class="table table-bordered">
    <thead>
        <tr>
            <!-- <th>STT</th> -->
            <th>Tên vai trò</th>
            <th>Mô tả</th>
            <th>Số lượng quyền</th>
            <th>Trạng thái</th>
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
                    {{-- @foreach ($role->permissions as $permission)
                        <span class="badge badge-info" style="padding: 8px">{{ $permission->name }}</span>
                    @endforeach --}}
                    <span class="badge badge-info" style="padding: 8px">{{ $role->permissions->count() }} / {{ $totalPermissions }}</span>
                </td>

                <td class="text-center">
                @if($role->name != 'Admin')
                    <form name="form_status" action="">
                        @csrf
                        <input type="hidden" name="attribute" value="status">
                        <input type="hidden" name="table" value="{{$table}}">
                        <input type="checkbox" data-id="{{ $role->id }}"
                            @if ($role['status'] == 1) checked @endif
                            class="js-switch js-switch_{{ $role->id }}" style="display: none;"
                            data-switchery="true">
                    </form>
                @endif
                
                </td>

                <th class="text-center">
                @if($role->name != 'Admin')

                    <div style="display: flex; justify-content: center;column-gap: 5px;">
                        <a class="btn btn-sm btn-info" href="{{ route('admin.role.edit', $role->id) }}" data-toggle="tooltip" data-placement="top" title="Sửa thông tin"><i class="fa fa-pencil"></i></a>
                        {{-- <a class="btn btn-sm btn-info" href="{{ route('admin.role.show', $role->id) }}"><i
                            class="fa fa-paste"></i> Chi tiết</a> --}}
                        @if(auth()->user()->hasPermission('deleteRole'))

                        <form action="" method="POST" data-url="role" class="form-delete">
                            @method('DELETE')
                            @csrf
                            <input type="hidden" value="{{ $role->id }}" name="id">
                            <button class="btn btn-sm btn-danger"data-toggle="tooltip" data-placement="top" title="Xóa"><i class="fa-solid fa-trash"></i></button>
                        </form>
                        @else
                        <a href="{{ route('permission.denied') }}" class="btn btn-warning center" title="Không có quyền">
                            <i class="fa fa-trash-o"></i>
                        </a> {{-- Hiển thị nút xóa nhưng không cho phép --}}
                        @endif
                    </div>
                @endif
                
                </th>
            </tr>
        @endforeach
    </tbody>
</table>
