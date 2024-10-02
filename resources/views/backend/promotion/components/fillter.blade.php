<div class="ibox-content_top">
   
       <form action="" method="GET" class="form_seach">
        <input type="text" class="form-control" name="seach_text" @if(isset($_GET["name"])) value="{{$_GET['name']}}" @endif placeholder="Tìm kiếm theo tên">
            <select type="text" class="form-control"   name="seach_rule" placeholder="Tìm theo loại giảm giá">
                <option value="">Tìm theo loại giảm giá</option>
                <option value="1">Theo phần trăm</option>
            </select>
        <button class="btn btn-primary seach"> <i class="fa-solid fa-magnifying-glass"></i> Tìm kiếm </button> 
        <a href="{{route("admin.variant.create")}}"  class="btn btn-success"><i class="fa-solid fa-plus"></i> Thêm mới mã giảm giá</a>
       </form>
       
</div>