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
                            <div class="form-group d-flex ">
                                <div>
                                    <form action="{{ route('admin.product_comment.restore', $comment->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-success">Khôi phục</button>
                                    </form>
                                </div>
                                <div>
                                    <form action="" method="POST" data-url="product-comment" style="text-align: center;" class="form-delete">
                                        @method("DELETE")
                                        @csrf
                                        <input type="hidden" value="{{$comment->id}}" name="id">
                                        <button class="btn btn-warning center"><i class="fa fa-trash-o"></i></button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>