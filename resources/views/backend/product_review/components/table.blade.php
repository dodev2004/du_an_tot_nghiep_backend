<table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>Người dùng</th>
                <th>Sản phẩm</th>
                <th>Đánh giá</th>
                <th>Số sao</th>
                <th>Ngày</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reviews as $review)
            <tr>
                <td>{{ $review->user->full_name }}</td> 
                <td>{{ $review->product->name }}</td>
                <td>{{ $review->review }}</td>
                <td>{{ $review->rating }}</td>
                <td>{{ $review->created_at->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>