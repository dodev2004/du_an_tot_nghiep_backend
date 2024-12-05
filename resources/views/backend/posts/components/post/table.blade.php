<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th>STT</th>
            <th>Tên bài viết</th>
            <th class="text-center">Nội dung</th>
            <th class="text-center">Trạng thái</th>
            <th class="text-center" style="width:auto">Danh mục</th>
            <th class="text-center">Hành động</th>


        </tr>
    </thead>
    <tbody>
        @foreach ($data as $index => $post)
        <tr>
            <td class="text-center">{{$index+1}}</td>
            <td>
                <p style="margin-bottom: 0;font-weight: 600;font-size: 14px;">{{$post->title}}</p>
                <p style="font-size: 10px; font-weight: bold;margin-bottom:0">Ngày đăng : {{$post->created_at}}</p>
                <p style="font-size: 10px; font-weight: bold;margin-bottom:0">Mô tả : {{ \Illuminate\Support\Str::limit(strip_tags($post->meta_description), 100) }}</p>

                <p style="font-size: 10px; font-weight: bold;">Ngày sửa : {{$post->updated_at}}</p>
            </td>
            <td class="text-start">
                {{ \Illuminate\Support\Str::limit(strip_tags($post->content), 100) }}
            </td>
            <td class="text-center">
                <form name="form_status" action="">
                    @csrf
                    <input type="hidden" name="attribute" value="status">
                    <input type="hidden" name="table" value="{{$table}}">
                    <input type="checkbox" data-id="{{$post["id"]}}" @if($post["status"]==1) checked @endif class="js-switch js-switch_{{$post["id"]}}" style="display: none;" data-switchery="true">
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
                <div style="display: flex; justify-content: center;column-gap: 5px;">

                    <a href="{{route('admin.post.edit',$post["id"])}}" class="btn btn-info" title="Chỉnh sửa"><i class="fa fa-pencil"></i></a>
                    @if(auth()->user()->hasPermission('deletePost'))

                    <form action="" method="POST" data-url="post" class="form-delete">
                        @method("DELETE")
                        @csrf
                        <input type="hidden" value="{{$post["id"]}}" name="id">
                        <button class="btn btn-warning center" title="Xóa"><i class="fa fa-trash-o"></i></button>
                    </form>
                    @else
                        <a href="{{ route('permission.denied') }}" class="btn btn-warning center" title="Không có quyền">
                            <i class="fa fa-trash-o"></i>
                        </a> {{-- Hiển thị nút xóa nhưng không cho phép --}}
                        @endif
                </div>

            </td>
        </tr>
        @endforeach

    </tbody>
</table>
