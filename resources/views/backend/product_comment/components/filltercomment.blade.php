<h4>Bình luận của {{ $users->full_name }}</h4><br>
<div class="ibox-content_top">
    <form action="{{ route('admin.product_comment.user_comments', $users->id) }}" method="GET" class="form_search">
        <div class="form-group d-flex align-items-center">
            <div>
                <label for="keywords" class="me-2">Tìm kiếm</label>
                <input type="text" class="form-control" name="search_text" @if(isset($_GET["search_text"])) value="{{$_GET['search_text']}}" @endif placeholder="Tìm kiếm theo tên">
            </div>

            <div class="ms-2">
                <label for="start_date" class="me-2">Ngày bắt đầu:</label>
                <input type="date" name="start_date" class="form-control" value="{{ request()->start_date }}">
            </div>

            <div class="ms-2">
                <label for="end_date" class="me-2">Ngày kết thúc:</label>
                <input type="date" name="end_date" class="form-control" value="{{ request()->end_date }}">
            </div>

            <div class="ms-2">
                <label for="date_order" class="me-2">Sắp xếp theo:</label>
                <select name="date_order" class="form-control">
                    <option value="">Chọn thứ tự</option>
                    <option value="newest" {{ request()->date_order == 'newest' ? 'selected' : '' }}>Mới nhất</option>
                    <option value="oldest" {{ request()->date_order == 'oldest' ? 'selected' : '' }}>Cũ nhất</option>
                </select>
            </div>

            <div class="ms-2" style="margin-top: 23px;">
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass"></i> Tìm kiếm</button>
            </div>
        </div>
    </form>
        <div style="margin-top: 15px;">
            <a href="{{ route('admin.product_comment.trash') }}" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Thùng rác"><i class="fa fa-trash-o"></i></a>
        </div>
</div>
