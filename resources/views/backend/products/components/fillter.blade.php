<div class="ibox-content_top">
    <div class="form_seach" style="padding-bottom: 12px">
        <form method="GET"  class="row" >
          
            <div class="col-md-2 p-2" style="padding-right: 2px;!important">
                <input type="text" class="form-control" name="ky_tu" @if(isset($_GET["ky_tu"])) value="{{$_GET['ky_tu']}}" @endif placeholder="Tìm kiếm theo tên">
            </div>
            <div class="col-md-2 p-2" style="padding-right: 2px;!important">
                <input type="text" class="form-control" name="chuyen_muc" @if(isset($_GET["chuyen_muc"])) value="{{ $_GET["chuyen_muc"]}}" @endif placeholder="Tìm kiếm theo chuyên mục">
            </div>
            <div class="col-md-2 p-2" style="padding-right: 2px;!important">
                 <select name="trang_thai" id="" class="form-control">
                    <option value="">Tìm kiếm theo trạng thái</option>
                    <option  @if(isset($_GET["trang_thai"]) && $_GET["trang_thai"] == 1 ) selected @endif value="1">Hoạt động</option>
                    <option  @if(isset($_GET["trang_thai"]) && $_GET["trang_thai"] == 0) selected @endif value="0">Không hoạt động</option>
                 </select>
            </div>
            <div class="col-md-2 p-2">
              
                <div class="input-group date">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="datetime-local"
                        name="ngay_dang" @if(isset($_GET["ngay_dang"])) value="{{ $_GET["ngay_dang"]}}" @endif class="form-control">
                </div>
            </div>
            <div class="col-md-2" style="padding-left: 12px">
                <div class="d-flex">
                    <button type="submit" class="btn btn-primary seach"> <i class="fa-solid fa-magnifying-glass"></i> Tìm kiếm</button>
                    <a class="btn btn-primary" href="{{route("admin.product.create")}}">Thêm mới</a>
                </div>
            </div>
        </form>
    </div>
</div>
