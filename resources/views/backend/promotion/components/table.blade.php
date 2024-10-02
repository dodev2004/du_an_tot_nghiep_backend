<table class="table table-bordered">
    <thead>
        <tr>
            <th></th>
            <th>Mã</th>
            <th>Loại giảm giá</th>
            <th>Giá trị giảm</th>
            <th>Trạng thái</th>
            <th>Ngày bắt đầu</th>
            <th>Ngày kết thúc</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $promotion)
            <tr>
                <td><input type="checkbox"></td>
                <td>{{ $promotion->code }}</td>
                <td>{{ $promotion->discount_type }}</td>
                <td>{{ $promotion->discount_value }}</td>
                <td>
                    <form name="form_status" action="">
                        @csrf
                        <input type="hidden" name="table" value="{{$table}}">
                        <input type="checkbox" @if($promotion->status == 1) checked @endif data-id="{{$promotion->id}}" class="js-switch js-switch_{{$promotion->id}}" style="display: none;" data-switchery="true">
                    </form>
                    
                </td>
                <td>{{ $promotion->start_date }}</td>
                <td>{{ $promotion->end_date ?? 'Không có' }}</td>
                <td>
                    <a class="btn btn-sm btn-info"  href="#" ><i class="fa fa-paste"></i> Edit</a>
                    <form action="" method="POST" data-url="promotions" class="form-delete">
                        @method("DELETE")
                        @csrf
                        <input type="hidden" value="{{$promotion->id}}" name="id">
                        <button class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i> Xóa</button>
                    </form>
        
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
