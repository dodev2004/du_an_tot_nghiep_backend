<div class="ibox-content_top">
    <div class="form_seach" style="padding-bottom: 12px">
        <form method="GET"  class="row" >
          
            <div class="col-md-2 p-2" style="padding-right: 2px;!important">
                <input type="text" class="form-control" name="keywords" @if(isset($_GET["keywords"])) value="{{$_GET['keywords']}}" @endif placeholder="Tìm kiếm theo tên">
            </div>
            <div class="col-md-6" style="padding-left: 12px">
                <div class="d-flex">
                    <button type="submit" class="btn btn-primary seach"> <i class="fa-solid fa-magnifying-glass"></i> Tìm kiếm </button>
                    <a href="{{ route('admin.post.create') }}" class="btn btn-success"><i class="fa-solid fa-plus"></i> Thêm mới bài
                        viết</a>
                </div>
            </div>
        </form>
    </div>
</div>
