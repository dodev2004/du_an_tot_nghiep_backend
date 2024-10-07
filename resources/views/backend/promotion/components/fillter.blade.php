<form action="{{ route('admin.promotions') }}" method="GET" class="form_seach">
    <input type="text" class="form-control" name="search_text" 
        @if(request()->has('search_text')) 
            value="{{ request()->get('search_text') }}" 
        @endif 
        placeholder="Tìm kiếm theo tên">
    <select class="form-control" name="search_rule">
        <option value="">Tìm theo loại giảm giá</option>
        <option value="percentage" 
            {{ request()->get('search_rule') == 'percentage' ? 'selected' : '' }}>Theo phần trăm</option>
        <option value="fixed" 
            {{ request()->get('search_rule') == 'fixed' ? 'selected' : '' }}>Cố định</option>
    </select>
    <button class="btn btn-primary seach"> 
        <i class="fa-solid fa-magnifying-glass"></i> Tìm kiếm 
    </button> 
    <a href="{{ route('admin.promotions.create') }}" class="btn btn-success">
        <i class="fa-solid fa-plus"></i> Thêm mới mã giảm giá
    </a>
    
</form>


