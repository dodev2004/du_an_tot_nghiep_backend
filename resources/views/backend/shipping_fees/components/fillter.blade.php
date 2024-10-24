<div class="ibox-content_top">
    <form action="" method="GET" class="form_seach">
        <div class="form-group d-flex align-items-center">
            <div >
                <label for="seach" class="me-2">Tìm kiếm theo tên:</label>
                <input type="text" class="form-control" name="seach_text"
                    @if (isset($_GET['seach_text'])) value="{{ $_GET['seach_text'] }}" @endif
                    placeholder="Tìm kiếm">
            </div>
            <div>
                <label for="status">Sắp xếp theo:</label>
                <select name="status" class="form-control">
                    <option value="">Trạng thái</option>
                    <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Hoạt động</option>
                    <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Không hoạt động</option>
                </select>
            </div>
            <div style="margin-top: 24px;">
            <button class="btn btn-primary seach"> <i class="fa-solid fa-magnifying-glass"></i> Tìm kiếm </button>
            <a href="{{route("admin.shipping_fee.create")}}"  class="btn btn-success"><i class="fa-solid fa-plus"></i> Thêm mới phí ship</a>
            </div>
        </div>
    </form>

    <div class="total_record">

        <div style="margin-top: 15px;">
            <a href="{{ route('admin.shipping_fee.trash') }}" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Thùng rác"><i class="fa fa-trash-o"></i></a>
        </div>
    </div>
</div>

