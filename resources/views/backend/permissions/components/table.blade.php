<table class="table table-bordered">
    <thead>
        <tr>
            <!-- <th>ID</th> -->
            <th>Tên quyền</th>
            <th>Miêu tả</th>
            <th>Tên nhóm quyền</th>
            <th>Trạng thái</th>
            <th class="text-center">Chỉnh sửa</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $item)
            <tr>
                <!-- <td> -->
                    <!-- <p style="margin-bottom: 0;font-weight: 600;font-size: 14px;">{{ $item->id }}</p> -->
                <!-- </td> -->
                <td>
                    <p style="margin-bottom: 0;font-weight: 600;font-size: 14px;">{{ $item->name }}</p>
                </td>
                <th>
                    <p style="margin-bottom: 0;font-weight: 600;font-size: 14px;">{{ $item->description }}</p>
                </th>
                <th>
                    <p style="margin-bottom: 0;font-weight: 600;font-size: 14px;">{{ $item->groupPermission->name }}</p>
                </th>

                <td class="text-center">
                    <form name="form_status" action="">
                        @csrf
                        <input type="hidden" name="attribute" value="status">
                        <input type="hidden" name="table" value="{{$table}}">
                        <input type="checkbox" data-id="{{ $item->id }}"
                            @if ($item['status'] == 1) checked @endif
                            class="js-switch js-switch_{{ $item->id }}" style="display: none;"
                            data-switchery="true">
                    </form>

                </td>

                <th class="text-center">
                    <div style="display: flex; justify-content: center;column-gap: 5px;">
                        <a class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="Sửa" href="{{ route('admin.permission.edit', $item->id) }}"><i
                                class="fa fa-pencil"></i></a>
                        <form action="" method="POST" data-url="permission" class="form-delete">
                            @method('DELETE')
                            @csrf
                            <input type="hidden" value="{{ $item->id }}" name="id">
                            <button class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Xóa"><i class="fa fa-trash-o"></i></button>
                        </form>
                    </div>
                </th>
            </tr>
        @endforeach
    </tbody>
</table>
