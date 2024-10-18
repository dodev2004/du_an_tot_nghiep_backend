<div class="ibox-content_top">

    <form action="" method="GET" class="form_seach">
        <div class="form-group d-flex align-items-center">
            <div>
                <label for="seach" class="me-2">Tìm kiếm theo tên quyền:</label>
                <input type="text" class="form-control" name="seach_text"
                    @if (isset($_GET['seach_text'])) value="{{ $_GET['seach_text'] }}" @endif placeholder="Tìm kiếm">
            </div>
            <div>
                <label for="group_permission_id">Nhóm quyền:</label>
                <select name="group_permission_id" class="form-control">
                    <option value="">Chọn nhóm quyền</option>
                    @foreach ($groupPermissions as $groupPermission)
                        <option value="{{ $groupPermission->id }}"
                            {{ request('group_permission_id') == $groupPermission->id ? 'selected' : '' }}>
                            {{ $groupPermission->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
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
                    <option value="">Chọn thứ tự</option>
                    <option value="newest" {{ request('date_order') == 'newest' ? 'selected' : '' }}>Mới nhất</option>
                    <option value="oldest" {{ request('date_order') == 'oldest' ? 'selected' : '' }}>Cũ nhất</option>
                </select>
            </div>
            <div style="margin-top: 24px;">
                <button class="btn btn-primary seach"> <i class="fa-solid fa-magnifying-glass"></i> Tìm kiếm </button>
                <a href="{{ route('admin.permission.create') }}" class="btn btn-success"><i
                        class="fa-solid fa-plus"></i> Thêm
                    mới quyền</a>
            </div>
        </div>
    </form>

    <div class="total_record">

        <div style="margin-top: 15px;">
            <a href="{{ route('admin.permission.trash') }}" class="btn btn-danger" data-toggle="tooltip"
                data-placement="top" title="Thùng rác"><i class="fa fa-trash-o"></i></a>
        </div>
    </div>
</div>