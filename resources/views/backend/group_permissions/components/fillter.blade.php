<div class="ibox-content_top">

       <form action="" method="GET" class="form_seach">
        <input type="text" class="form-control" name="seach_text" @if(isset($_GET["seach_text"])) value="{{$_GET['seach_text']}}" @endif placeholder="Tìm kiếm theo tên">
        <button class="btn btn-primary seach"> <i class="fa-solid fa-magnifying-glass"></i> Tìm kiếm </button>

       </form>

<div class="total_record">

    {{-- <div style="margin-top: 15px;">
    <a href="{{route("admin.group_permission.create")}}"  class="btn btn-success"><i class="fa-solid fa-plus"></i> Thêm mới</a>
        <a href="{{ route('admin.group_permission.trash') }}" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Thùng rác"><i class="fa fa-trash-o"></i></a>
    </div> --}}
</div>
</div>
