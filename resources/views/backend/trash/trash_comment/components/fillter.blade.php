<div class="ibox-content_top">
    <form action="{{ route('admin.product_comment.trash') }}" method="GET" class="form_search">
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
                <label for="from-control">Sắp xếp theo</label>
                <select class="form-control" name="date_order">
                    <option value="">Tất cả</option>
                    <option value="newest" 
                        {{ request()->get('date_order') == 'newest' ? 'selected' : '' }}>Mới nhất</option>
                    <option value="oldest" 
                        {{ request()->get('date_order') == 'oldest' ? 'selected' : '' }}>Cũ nhất</option>
                </select>
            </div>

            <div class="col-md-2">
                <button type="submit" class="btn btn-primary" style="margin-top: 24px;">
                    <i class="fa-solid fa-magnifying-glass"></i> Tìm kiếm
                </button>
            </div>
        </div>
    </form>
</div>
