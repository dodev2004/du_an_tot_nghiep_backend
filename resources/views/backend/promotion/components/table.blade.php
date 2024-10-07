<table class="table table-bordered">
    <thead>
        <tr>
            <th>STT</th>
            <th>Mã</th>
            <th>Loại giảm giá</th>
            <th>Giá trị giảm</th>
            <th>Trạng thái</th>
            <th>Ngày bắt đầu</th>
            <th>Ngày kết thúc</th>
            <th>Số lượt sử dụng</th>
            <th>Số lượt đã sử dụng</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $index => $promotion)
            <tr>
                <td>{{$index+1}}</td>
                <td>{{ $promotion->code }}</td>
                <td>{{ $promotion->discount_type }}</td>
                <td>{{ $promotion->discount_value }}</td>
                <td>{{ $promotion->status }}</td>
                <td>{{ \Carbon\Carbon::parse($promotion->start_date)->format('d/m/Y') }}</td>
                <td>{{ $promotion->end_date ? \Carbon\Carbon::parse($promotion->end_date)->format('d/m/Y') : 'Không có' }}
                </td>

                <td>{{ $promotion->max_uses }}</td>
                <td>{{ $promotion->used_count }}</td>
                <td >
                    <a class="btn btn-sm btn-info" href="{{ route('admin.promotions.edit', $promotion->id) }}"><i
                            class="fa fa-paste"></i> </a>
                    <form action="" method="POST" data-url="promotions" class="form-delete">
                        @method('DELETE')
                        @csrf
                        <input type="hidden" value="{{ $promotion->id }}" name="id">
                        <button class="btn btn-sm btn-danger" data-id="{{ $promotion->id }}"">
                            <i class="fa-solid fa-trash"></i></button>
                    </form>

                </td>
            </tr>
        @endforeach
    </tbody>
</table>
