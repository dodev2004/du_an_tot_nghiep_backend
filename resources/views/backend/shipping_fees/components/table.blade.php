<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên thành phố</th>
            <th>Phí ship</th>
            <th>Trọng lượng tối đa</th>
            <th>Trạng thái</th>
            <th class="text-center">Chỉnh sửa</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $item)
            <tr>
                <td><p style="margin-bottom: 0;font-weight: 600;font-size: 14px;">{{ $item->province->code }}</p></td>
                <td>
                    <p style="margin-bottom: 0;font-weight: 600;font-size: 14px;">{{ $item->province->name }}</p>
                </td>
                <th>
                    <p style="margin-bottom: 0;font-weight: 600;font-size: 14px;">{{ $item->fee }}</p>
                </th>
                <th>
                    <p style="margin-bottom: 0;font-weight: 600;font-size: 14px;">{{ $item->weight_limit }}</p>
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
                    <a class="btn btn-sm btn-info" href="{{ route('admin.shipping_fee.edit', $item->id) }}"><i
                            class="fa fa-paste"></i> Edit</a>
                    <form action="" method="POST" data-url="shipping-fee" class="form-delete ">
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
