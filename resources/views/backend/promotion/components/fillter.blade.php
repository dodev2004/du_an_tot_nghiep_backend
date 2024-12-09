<div style="display: flex;justify-content: space-between; margin-bottom: 10px">
    <form action="{{ route('admin.promotions') }}" method="GET" class="form_seach">
        <input type="text" class="form-control" name="search_text" @if(request()->has('search_text'))
        value="{{ request()->get('search_text') }}"
        @endif
        placeholder="Tìm kiếm theo tên">
        <button class="btn btn-primary seach">
            <i class="fa-solid fa-magnifying-glass"></i> Tìm kiếm
        </button>


    </form>
    <a href="{{ route('admin.promotions.create') }}" class="btn btn-success">
        <i class="fa-solid fa-plus"></i> Thêm mới
    </a>
</div>