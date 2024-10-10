<table class="table table-bordered">
    <thead>
        <tr>
            <th>STT</th>
            <th>Người dùng</th>
            <th>Số lượng sản phẩm</th>
            <th>Số lượng bình luận</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $key => $user)
            <tr>
                <td>{{ $key + 1 }}</td> 
                <td>{{ $user->full_name }}</td>
                <td>{{ $user->product_count }}</td>
                <td>{{ $user->product_comments_count }}</td> 
                <td>
                    <a class="btn btn-sm btn-info" href="{{ route('admin.product_comment.user_comments', $user->id) }}">Xem chi tiết</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
