<div class="ibox-content_top">
    <form action="" method="GET" class="form_seach">
        <div class="form-group d-flex align-items-center">
            <div>
                <label for="seach" class="me-2">Tìm kiếm theo tên người dùng:</label>
                <input type="text" class="form-control" name="seach_text" @if (isset($_GET['seach_text']))
                    value="{{ $_GET['seach_text'] }}" @endif placeholder="Tìm kiếm">
            </div>
            <div>
                <label for="start_date">Từ ngày:</label>
                <input type="date" class="form-control" name="start_date" value="{{ request('start_date') }}">
            </div>
            <div>
                <label for="end_date">Đến ngày:</label>
                <input type="date" class="form-control" name="end_date" value="{{ request('end_date') }}">
            </div>
            <div>
                <label for="date_order">Sắp xếp theo:</label>
                <select name="date_order" class="form-control">
                    <option value="">Chọn thứ tự</option>
                    <option value="newest" {{ request('date_order') == 'newest' ? 'selected' : '' }}>Mới nhất</option>
                    <option value="oldest" {{ request('date_order') == 'oldest' ? 'selected' : '' }}>Cũ nhất</option>
                </select>
            </div>
            <div style="margin-top: 24px;">
            <button class="btn btn-primary seach"> <i class="fa-solid fa-magnifying-glass"></i> Tìm kiếm </button>
            {{-- <a href="{{ route('admin.contact.create') }}" class="btn btn-success"><i class="fa-solid fa-plus"></i> Thêm
                mới form liên hệ</a> --}}
            </div>
        </div>
    </form>

    <div class="total_record" >
        <div style="margin-top: 33px;">
            <a href="{{ route('admin.contact.trash') }}" class="btn btn-danger" data-toggle="tooltip" data-placement="top"
                title="Thùng rác"><i class="fa fa-trash-o"></i></a>
        </div>
        <small class="text-muted ms-2">(Chỉ có thể xoá phản hồi đã quá 30 ngày)</small>

    </div>
</div>
