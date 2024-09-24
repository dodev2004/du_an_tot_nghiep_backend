<table class="table table-bordered">
    <thead>
    <tr>
        <th></th>
        <th>#</th>
        <th>Full Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Adress</th>
        <th>Status</th>
        <th>Active</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($data as $user)
        <tr>
        <td><input type="checkbox"></td>
        <td>{{$user->id}}</td>
        <td>{{$user->Fullname}}</td>
        <td>{{$user->email}}</td>
        <td>{{$user->phone ? $user->phone : "Dữ liệu chưa có" }}</td>
        <td>{{$user->address ? $user->address : "Dữ liệu chưa có" }}</td>
        <td>
            <form name="form_status" action="">
                @csrf
                <input type="hidden" name="table" value="{{$table}}">
                <input type="checkbox" @if($user->status == 1) checked @endif data-id="{{$user->id}}" class="js-switch js-switch_{{$user->id}}" style="display: none;" data-switchery="true">
            </form>
            
        </td>
        <td>
            <a class="btn btn-sm btn-info"  href="{{route("admin.users.edit",$user->id) }}" ><i class="fa fa-paste"></i> Edit</a>
            <form action="" method="POST" data-url="users" class="form-delete">
                @method("DELETE")
                @csrf
                <input type="hidden" value="{{$user->id}}" name="user_id">
                <button class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i> Xóa</button>
            </form>

        </td>
    </tr>
    @endforeach
    
    </tbody>
   
</table>
