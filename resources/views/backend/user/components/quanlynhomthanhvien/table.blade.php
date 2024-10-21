<table class="table table-bordered">
    <thead>
        <tr>
            <th>STT</th>
            <th>Tên nhóm thành viên</th>
            <th>Mô tả</th>
            <th>Trạng thái</th>
            <th class="text-center">Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $index => $item)
            <tr>
                <td>{{$index + 1}}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->description ? $item->description : 'Dữ liệu chưa có' }}</td>
                <td>
                    <form name="form_status" action="">
                        @csrf
                        <input type="hidden" name="table" value="{{ $table }}">
                        <input type="hidden" name="attribute" value="status">
                        <input type="checkbox" data-id="{{ $item->id }}"
                            @if ($item->status == 1) checked @endif
                            class="js-switch js-switch_{{ $item->id }}" style="display: none;" data-switchery="true">
                    </form>
                </td>
                {{-- <td>
            <a class="btn btn-sm btn-info" href="{{ route("admin.user_catelogue.edit",$item->id)}}" ><i class="fa fa-paste"></i> Edit</a>
            <form action="" method="POST" data-url="user_catelogue" class="form-delete">
                @method("DELETE")
                @csrf
                <input type="hidden" value="{{$item->id}}" name="id">
                <button class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i> Xóa</button>
          </form>

        </td> --}}
                <td style="text-align: center">
                    <div style="display: flex; justify-content: center;column-gap: 5px;">

                        <a class="btn btn-sm btn-info" href="{{ route("admin.user_catelogue.edit",$item->id)}}"><i
                                class="fa fa-pencil"></i></a>
                        <form action="" method="POST" data-url="post" class="form-delete">
                            @method("DELETE")
                            @csrf
                            <input type="hidden" value="{{$item->id}}" name="id">
                            <button class="btn btn-warning center"><i class="fa fa-trash-o"></i></button>
                        </form>
                    </div>

                </td>
            </tr>
        @endforeach

    </tbody>
</table>
