<div class="ibox-content_top">
   
        <div class="form_seach">
            @php 

            @endphp
            <input type="text" class="form-control" name="seach_text" @if(isset($_GET["name"])) value="{{$_GET['name']}}" @endif placeholder="Tìm kiếm theo tên">
            <select type="text" class="form-control"   name="seach_rule" placeholder="Tìm kiếm theo vai trò">
                <option value="">Tìm theo vai trò</option>
                <option value="1">Quản trị viên</option>
            </select>
            <a class="btn btn-primary seach"> <i class="fa-solid fa-magnifying-glass"></i> Tìm kiếm </a> 
            <a href="{{route("admin.users.create")}}"  class="btn btn-success"><i class="fa-solid fa-plus"></i> Thêm người dùng</a>
        </div>
    <div class="total_record">
        <p>Tồn tại tổng <strong>{{$total}}</strong> tại trang thứ <strong>{{$data->currentPage()}}</strong></p>
    </div>
</div>