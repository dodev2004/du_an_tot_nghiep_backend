<div class="ibox-content_top">

    <form method="GET" class="form_seach" style="width: 100%;">
        <div style="width: 100%; display: flex; align-items: center;justify-content: space-between;">
            <div style="display: flex; align-items: center;">
                <input type="text" class="form-control" name="seach_text" @if(isset($_GET["name"])) value="{{$_GET['name']}}" @endif placeholder="Tìm kiếm theo tên" style="margin-right: 10px;">
                <button class="btn btn-primary seach" style="margin: 0;"> <i class="fa-solid fa-magnifying-glass"></i> Tìm kiếm </button>
            </div>
            <div>
                <a style="margin: 0;" href="{{route("admin.post-catelogue.create")}}" class="btn btn-success">Thêm mới <i class="fa fa-plus" ></i> </a>
            </div>
        </div>
    </form>
    <div class="total_record">

    </div>
</div>