<table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên vai trò</th>
                    <th>Miêu tả</th>
                    <th>Tên nhóm quyền</th>
                    <th>Ngày xóa</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->description }}</td>
                        <td>
                            @if($item->permissions->isNotEmpty())
                            <span class="badge badge-info" style="padding: 8px">{{ $item->permissions->count() }} / {{ $totalPermissions }}</span>
                            @else
                                Không có quyền
                            @endif
                        </td>
                        <td>{{ $item->deleted_at }}</td>
                        <td>
                            <form action="{{ route('admin.role.restore', $item->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-success"><i class="fa fa-undo"></i></button>
                            </form>
                            <form action="" method="POST" data-url="role" class="form-delete" style="display: inline;">
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
