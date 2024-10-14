<table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên thành phố</th>
                    <th>Phí ship</th>
                    <th>Trọng lượng tối đa</th>
                    <th>Ngày xóa</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $item)
                    <tr>
                        <td>{{ $item->province->code }}</td>
                        <td>{{ $item->province->name }}</td>
                        <td>{{ $item->fee }}</td>
                        <td>{{ $item->weight_limit }}</td>
                        <td>{{ $item->deleted_at }}</td>
                        <td>
                            <form action="{{ route('admin.shipping_fee.restore', $item->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-success"><i class="fa fa-undo"></i></button>
                            </form>
                            <form action="" method="POST" data-url="shipping-fee" class="form-delete" style="display: inline;">
                                @method('DELETE')
                                @csrf
                                <input type="hidden" value="{{ $item->id }}" name="id">
                                <button class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
