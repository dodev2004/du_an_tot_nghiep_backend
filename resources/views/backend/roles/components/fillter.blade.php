<div class="ibox-content_top">
  <form action="" method="GET" class="form_seach">
    <div class="form-group d-flex align-items-center">
      <div>
         <label for="seach" class="me-2">Tìm kiếm theo vai trò:</label>
        <input type="text" class="form-control" name="seach_text" @if (isset($_GET['seach_text'])) value="{{ $_GET['seach_text'] }}" @endif placeholder="Nhập vai trò">
      </div>
      <!-- <div>
        <label for="start_date">Ngày bắt đầu:</label>
        <input type="date" class="form-control" name="start_date" value="{{ request('start_date') }}">
      </div>
      <div>
        <label for="end_date">Ngày kết thúc:</label>
        <input type="date" class="form-control" name="end_date" value="{{ request('end_date') }}">
      </div>
      <div>
        <label for="date_order">Sắp xếp theo:</label>
        <select name="date_order" class="form-control">
          <option value="" hidden>Chọn thứ tự</option>
          <option value="newest" {{ request('date_order') == 'newest' ? 'selected' : '' }}>Mới nhất</option>
          <option value="oldest" {{ request('date_order') == 'oldest' ? 'selected' : '' }}>Cũ nhất</option>
        </select>
      </div> -->
      <div>
        <label for="status">Trạng thái:</label>
        <select name="status" class="form-control">
            <option value="">Toàn Bộ</option>
            <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Hoạt động</option>
            <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Không hoạt động</option>
        </select>
    </div>
      <div style="margin-top: 24px;">
        <button class="btn btn-primary seach"> <i class="fa-solid fa-magnifying-glass"></i> Tìm kiếm </button>
      </div>
    </div>
  </form>


  <div class="total_record">

    <div style="margin-top: 15px;">
      <a href="{{ route('admin.role.create') }}" class="btn btn-info"><i class="fa-solid fa-plus"></i> Thêm
        mới</a>
      <a href="{{ route('admin.role.trash') }}" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Thùng rác"><i class="fa fa-trash-o"></i></a>
    </div>
  </div>

</div>
