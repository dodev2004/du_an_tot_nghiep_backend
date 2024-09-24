<div class="ibox-content_top">
   
       <form action="" method="GET" class="form_seach">
        <input type="text" class="form-control" name="keywords" @if(isset($_GET["keywords"])) value="{{$_GET['keywords']}}" @endif placeholder="Tìm kiếm theo tên">
        <button class="btn btn-primary seach"> <i class="fa-solid fa-magnifying-glass"></i> Tìm kiếm </button> 
        <a href="{{route("admin.variant_catelogue.create")}}"  class="btn btn-success"><i class="fa-solid fa-plus"></i> Thêm mới danh mục</a>
       </form>
       
<div class="total_record">
    <p>Tồn tại tổng <strong>{{$data->count()}}</strong> tại trang thứ <strong>{{$data->currentPage()}}</strong></p>
</div>
</div>