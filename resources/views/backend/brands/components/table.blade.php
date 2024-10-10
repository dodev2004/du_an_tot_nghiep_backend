<table class="table table-bordered">
    <thead>
        <tr>
            <th></th>
            <th>Tên nhãn hàng</th>
            <th>Miêu tả</th>
            <th>Trạng thái</th>
            <th class="text-center">Chỉnh sửa</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $item)
            <tr>
                <td><input type="checkbox" value="{{ $item->id }}"></td>
                <td>
                    <p style="margin-bottom: 0;font-weight: 600;font-size: 14px;">{{ $item->name }}</p>
                </td>
                <th>
                    <p style="margin-bottom: 0;font-weight: 600;font-size: 14px;">{{ $item->description }}</p>
                </th>

                <td class="text-center">
                    <form name="form_status" action="">
                        @csrf
                        <input type="hidden" name="table" value="">
                        <input type="checkbox" data-id="{{ $item->id }}"
                            @if ($item['status'] == 1) checked @endif
                            class="js-switch js-switch_{{ $item->id }}" style="display: none;"
                            data-switchery="true">
                    </form>

                </td>

                <th class="text-center">
                    <a class="btn btn-sm btn-info" href="{{ route('admin.brand.edit', $item->id) }}"><i
                            class="fa fa-paste"></i> Edit</a>
                    <form action="" method="POST" data-url="brand" class="form-delete">
                        @method('DELETE')
                        @csrf
                        <input type="hidden" value="{{ $item->id }}" name="id">
                        <button class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i> Xóa</button>
                    </form>
                </th>
            </tr>
        @endforeach
    </tbody>
</table>