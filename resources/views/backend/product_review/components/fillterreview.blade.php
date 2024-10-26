<div class="ibox-content_top">  
    <form action="{{ route('admin.product_review.user_reviews',['id' => $users->id]) }}" method="GET" class="form_search">
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
                <label for="from-control">Ngày bắt đầu</label>
                <input type="date" class="form-control" name="start_date" 
                    @if(request()->has('start_date')) 
                        value="{{ request()->get('start_date') }}" 
                    @endif 
                    placeholder="Ngày bắt đầu">
            </div>

            <div class="col-md-2">
            <label for="from-control">Ngày kết thúc</label>
                <input type="date" class="form-control" name="end_date" 
                    @if(request()->has('end_date')) 
                        value="{{ request()->get('end_date') }}" 
                    @endif 
                    placeholder="Ngày kết thúc">
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
                <label for="from-control">Lọc sao</label>
                <select class="form-control" name="rating">
                    <option value="">Tất cả</option>
                    <option value="1" {{ request()->get('rating') == '1' ? 'selected' : '' }}>1 Sao</option>
                    <option value="2" {{ request()->get('rating') == '2' ? 'selected' : '' }}>2 Sao</option>
                    <option value="3" {{ request()->get('rating') == '3' ? 'selected' : '' }}>3 Sao</option>
                    <option value="4" {{ request()->get('rating') == '4' ? 'selected' : '' }}>4 Sao</option>
                    <option value="5" {{ request()->get('rating') == '5' ? 'selected' : '' }}>5 Sao</option>
                </select>
            </div>
            <div class="col-md-2" style="margin-top: 23px;">
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-magnifying-glass"></i> Tìm kiếm
                </button>
            </div>
        </div>
    </form>
</div>
