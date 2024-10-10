<table class="table table-bordered">
            <thead>
                <tr>
                    <th>Người dùng</th>
                    <th>Bình luận</th>
                    <th>Sản phẩm</th>
                    <th>Ngày xóa</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $comment)
                    <tr>
                        <td>{{ $comment->user->full_name }}</td>
                        <td>{{ $comment->comment }}</td>
                        <td>{{ $comment->product->name }}</td>
                        <td>{{ $comment->deleted_at }}</td>
                        <td>
                            <form action="{{ route('admin.product_comment.restore', $comment->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-success">Khôi phục</button>
                            </form>
                            <form action="{{ route('admin.product_comment.hard_delete', $comment->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Xóa vĩnh viễn</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>