<h4>Bình luận của {{ $users->full_name }}</h4><br>
<div class="ibox-content_top">
    <form action="{{ route('admin.product_comment.user_comments', ['id' => $users->id]) }}" method="GET" class="form_search">
        <div class="row">

            <div class="col-md-2">
                <label for="from-control">Tìm kiếm</label>
                <input type="text" class="form-control" name="search_text" 
                    @if(request()->has('search_text')) 
                        value="{{ request()->get('search_text') }}" 
                    @endif 
                    placeholder="Tìm kiếm">
            </div>

            <div class="col-md-2">
                <label for="from-control">Từ ngày</label>
                <input type="date" class="form-control" name="start_date" 
                    @if(request()->has('start_date')) 
                        value="{{ request()->get('start_date') }}" 
                    @endif 
                    placeholder="Ngày bắt đầu">
            </div>

            <div class="col-md-2">
            <label for="from-control">Đến ngày</label>
                <input type="date" class="form-control" name="end_date" 
                    @if(request()->has('end_date')) 
                        value="{{ request()->get('end_date') }}" 
                    @endif 
                    placeholder="Ngày kết thúc">
            </div>

            <div class="col-md-2">
                <label for="from-control">Sắp xếp theo</label>
                <select class="form-control" name="date_order">
                    <option value="">Tất cả bình luận</option>
                    <option value="newest" 
                        {{ request()->get('date_order') == 'newest' ? 'selected' : '' }}>Mới nhất</option>
                    <option value="oldest" 
                        {{ request()->get('date_order') == 'oldest' ? 'selected' : '' }}>Cũ nhất</option>
                </select>
            </div>

            <div class="col-md-2" style="margin-top: 23px;">
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-magnifying-glass"></i> Tìm kiếm
                </button>
            </div>
        </div>
    </form>
    
    <div class="col-md-2" style="margin-top: 23px; text-align: center">
        <a href="{{ route('admin.product_comment.trash') }}" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Thùng rác"><i class="fa fa-trash-o"></i></a>
    </div>
</div>
