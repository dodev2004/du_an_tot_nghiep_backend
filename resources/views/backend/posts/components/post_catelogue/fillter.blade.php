<div class="ibox-content_top">
   
        <form method="GET" class="form_seach">
            <input type="text" class="form-control" name="seach_text" @if(isset($_GET["name"])) value="{{$_GET['name']}}" @endif placeholder="Tìm kiếm theo tên">
            <button class="btn btn-primary seach"> <i class="fa-solid fa-magnifying-glass"></i> Tìm kiếm </button> 
            <a style="margin-bottom: 20px" href="{{route("admin.post-catelogue.create")}}" class="btn btn-success">Thêm mới chuyên mục <i class="fa fa-plus"></i> </a>
        </form>
    <div class="total_record">
    
    </div>
</div>