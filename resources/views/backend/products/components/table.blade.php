<table class="table table-striped table-bordered table-hover dataTables-example" >
    <thead>
    <tr>
        <th></th>
       <th>Tên bài viết</th>
        <th class="text-center">Tác giả</th>
        <th class="text-center">Trạng thái</th>
        <th class="text-center" style="with:auto">Danh mục</th>
        <th class="text-center">Chỉnh sửa</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($data as $post)
      
        <td style="text-align: center">
             <a href="{{route('admin.post.edit',$post["id"])}}" class="btn btn-info"><i class="fa fa-pencil"></i></a>
            <form action="" method="POST" data-url="post" class="form-delete">
                @method("DELETE")
                @csrf
                <input type="hidden" value="{{$post["id"]}}" name="id">
                        <button class="btn btn-warning center"><i class="fa fa-trash-o"></i></button>
            </form>

        </td>
    </tr>
    @endforeach
    
    </tbody>
</table>
