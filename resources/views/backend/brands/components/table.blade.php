<table class="table table-bordered">
    <thead>
        <tr>
            <th>Tên nhãn hàng</th>
            <th>Miêu tả</th>
            <th>Trạng thái</th>
            <th class="text-center">Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $index => $item)
        <tr>
            <!-- <td>
                    <p style="margin-bottom: 0;font-weight: 600;font-size: 14px;">{{ $index+1 }}</p>
                </td> -->
            <td>
                <p style="margin-bottom: 0;font-weight: 600;font-size: 14px;">{{ $item->name }}</p>
            </td>
            <th>
                <p style="width: 800px ;margin-bottom: 0;font-weight: 600;font-size: 14px;">{{ $item->description }}</p>
            </th>

            <td class="text-center">
                <form name="form_status" action="">
                    @csrf
                    <input type="hidden" name="attribute" value="status">
                    <input type="hidden" name="table" value="{{$table}}">
                    <input type="checkbox" data-id="{{ $item->id }}" @if ($item['status']==1) checked @endif
                        class="js-switch js-switch_{{ $item->id }}" style="display: none;" data-switchery="true">
                </form>

            </td>

            <th class="text-center">
                <div style="display: flex; justify-content: center;column-gap: 5px;">
                    <a class="btn btn-sm btn-info" href="{{ route('admin.brand.edit', $item->id) }}"><i
                            class="fa fa-pencil"></i></a>
                    <form action="" method="POST" data-url="brand" class="form-delete">
                        @method('DELETE')
                        @csrf
                        <input type="hidden" value="{{ $item->id }}" name="id">
                        <button class="btn btn-sm btn-warning"><i class="fa fa-trash-o"></i></button>
                    </form>
                </div>
            </th>
        </tr>
        @endforeach
    </tbody>
</table>