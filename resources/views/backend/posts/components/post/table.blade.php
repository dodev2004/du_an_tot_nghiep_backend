<table class="table table-striped table-bordered table-hover" >
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
    @foreach ($data as $index => $post)
        <tr>
            <td class="text-center">{{$index+1}}</td>
            <td>
                <p style="margin-bottom: 0;font-weight: 600;font-size: 14px;">{{$post["title"]}}</p>
                <p style="font-size: 12px;margin-bottom: 0;" >Tin tức bóng đá liên quan đến các nhóm sản phẩm</p>
                <p style="font-size: 10px; font-weight: bold;margin-bottom:0">Ngày đăng : {{$post["created_at"]}}</p>
                <p style="font-size: 10px; font-weight: bold;">Ngày sửa : {{$post["created_at"]}}</p>
            </td>
            <td class="text-center">
               <p>{{$post["author"]}}</p>
            </td>
        <td class="text-center">
            <form name="form_status" action="">
                @csrf
                <input type="hidden" name="table" value="">
                <input type="checkbox"  data-id="{{$post["id"]}}" @if($post["status"] == 1) checked @endif class="js-switch js-switch_{{$post["id"]}}"  style="display: none;" data-switchery="true">
            </form>
        </td>
        <td>
            <span>
                @if($post["catelogues"]->count()> 0)
                @foreach($post["catelogues"] as $catelogue)
                <span class="label label-primary">{{$catelogue->name}}</span>
                @endforeach
                @else
                <span class="label label-info">Chưa có chuyên mục</span>
               
                @endif
            </span>
        </td>
        <td style="text-align: center">
                <div style="display: flex; justify-content: center;column-gap: 5px;" >

                    <a href="{{route('admin.post.edit',$post["id"])}}" class="btn btn-info"><i class="fa fa-pencil"></i></a>
                    <form action="" method="POST" data-url="post" class="form-delete">
                        @method("DELETE")
                        @csrf
                        <input type="hidden" value="{{$post["id"]}}" name="id">
                                <button class="btn btn-warning center"><i class="fa fa-trash-o"></i></button>
                    </form>
                </div>

        </td>
    </tr>
    @endforeach
    
    </tbody>
</table>
