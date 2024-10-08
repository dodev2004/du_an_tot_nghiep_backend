<div class="ibox-content_top">

       <form action="" method="GET" class="form_seach">
        <input type="text" class="form-control" name="seach_text" @if(isset($_GET["seach_text"])) value="{{$_GET['seach_text']}}" @endif placeholder="Tìm kiếm theo tên">
        <button class="btn btn-primary seach"> <i class="fa-solid fa-magnifying-glass"></i> Tìm kiếm </button>
        <a href="{{route("admin.brand.create")}}"  class="btn btn-success"><i class="fa-solid fa-plus"></i> Thêm mới nhãn hàng</a>
       </form>

<div class="total_record">
    <p>Tồn tại tổng <strong>{{$data->count()}}
        {{-- </strong> tại trang thứ <strong>{{$data->currentPage()}}</strong> --}}
    </p>
</div>
</div>
