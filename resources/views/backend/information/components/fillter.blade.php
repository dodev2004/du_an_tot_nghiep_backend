<div class="ibox-content_top">

    {{-- <form action="" method="GET" class="form_seach">
        <input type="text" class="form-control" name="keywords" @if(isset($_GET["keywords"])) value="{{$_GET['keywords']}}"
    @endif placeholder="Tìm kiếm theo tên">
    <button class="btn btn-primary seach"> <i class="fa-solid fa-magnifying-glass"></i> Tìm kiếm </button>
    <a href="{{route("admin.brand.create")}}" class="btn btn-success"><i class="fa-solid fa-plus"></i> Thêm mới</a>
    </form>
</div> --}}

<th class="text-center">
    @if (isset($item))

    @else
    <a href="{{route("admin.information.create")}}" class="btn btn-success"><i class="fa-solid fa-plus"></i> Thêm mới
        trang liên hệ</a>

    @endif

</th>



</div>