<table class="table table-bordered">
            <thead>
                <tr>
                    <!-- <th>ID</th> -->
                    <th>Tên quyền</th>
                    <th>Miêu tả</th>
                    <th>Tên nhóm quyền</th>
                    <th>Ngày xóa</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $item)
                    <tr>
                        <!-- <td>{{ $item->id }}</td> -->
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->description }}</td>
                        <td>{{ $item->groupPermission->name }}</td>
                        <td>{{ $item->deleted_at }}</td>
                        <td>
                            <form action="{{ route('admin.permission.restore', $item->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-success"><i class="fa fa-undo"></i></button>
                            </form>
                            <form action="" method="POST" data-url="group-permission" class="form-delete" style="display: inline;">
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
