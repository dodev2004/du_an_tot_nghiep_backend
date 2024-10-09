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
                    <form action="{{ route('admin.product_comment.soft_delete', $comment->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger"><i class="fa fa-trash-o"></i> Xóa</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
