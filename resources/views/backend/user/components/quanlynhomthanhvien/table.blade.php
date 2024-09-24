<table class="table table-bordered">
    <thead>
    <tr>
        <th></th>
        <th>Name</th>
        <th>Description</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($data as $item)
        <tr>
        <td><input type="checkbox"></td>
        <td>{{$item->name}}</td>
        <td>{{$item->description ? $item->description : "Dữ liệu chưa có" }}</td>
        <td> <form name="form_status" action="">
            @csrf
            <input type="hidden" name="table" value="{{$table}}">
           
            <input type="checkbox" data-id="{{$item->id}}" @if($item->status == 1) checked @endif  class="js-switch js-switch_{{$item->id}}" style="display: none;" data-switchery="true">
        </form></td>
        <td>
            <a class="btn btn-sm btn-info" href="{{ route("admin.user_catelogue.edit",$item->id) }}" ><i class="fa fa-paste"></i> Edit</a>
            <form action="" method="POST" data-url="user_catelogue" class="form-delete">
                @method("DELETE")
                @csrf
                <input type="hidden" value="{{$item->id}}" name="user_id">
                <button class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i> Xóa</button>
            </form>

        </td>
    </tr>
    @endforeach
    
    </tbody>
</table>
