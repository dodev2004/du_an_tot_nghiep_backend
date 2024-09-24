<table class="table table-bordered">
    <thead>
        <tr>
            <th></th>
            <th>Gía trị thuộc tính</th>
            <th>Danh mục thuộc tính</th>
            <th class="text-center">Chỉnh sửa</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $item)
            <tr >
                <td><input type="checkbox" value="{{ $item->id }}"></td>
                <td>
                    <p style="margin-bottom: 0;font-weight: 600;font-size: 14px;">{{ $item->name }}</p>
                </td>
                <th>
                    <p style="margin-bottom: 0;font-weight: 600;font-size: 14px;">{{ $item->attributes->name }}</p>
                    
                <th class="text-center">
                    <a class="btn btn-sm btn-info"  href="{{route("admin.variant.edit",$item->id) }}" ><i class="fa fa-paste"></i> Edit</a>
                    <form action="" method="POST" data-url="variant" class="form-delete">
                        @method("DELETE")
                        @csrf
                        <input type="hidden" value="{{$item->id}}" name="id">
                        <button class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i> Xóa</button>
                    </form>
                </th>
            </tr>
        @endforeach
    </tbody>
</table>
