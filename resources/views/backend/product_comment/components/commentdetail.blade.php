<table class="table table-bordered">
    <thead>
        <tr>
            <th>Sản phẩm</th>
            <th>Bình luận</th>
            <th>Ngày tạo</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $comment)
            <tr>
                <td>{{ $comment->product->name }}</td>
                <td>{{ $comment->comment }}</td>
                <td>{{ $comment->created_at }}</td>
                
                <td>
                <form action="" method="POST" data-url="product-comment" style="text-align: center;" class="form-delete">
                            @method("DELETE")
                            @csrf
                            <input type="hidden" value="{{$comment->id}}" name="id">
                            <button class="btn btn-danger center"><i class="fa fa-trash-o"></i></button>
                        </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
