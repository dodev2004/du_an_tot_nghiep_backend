<div class="ibox-content_top">
    <form action="{{ route('admin.payment_methods') }}" method="GET"
    class="form_seach">
        <input type="text" class="form-control me-2" name="keywords"
            value="{{ request('keywords') }}" placeholder="Tìm kiếm theo tên"
            style="max-width: 250px;">
        <button class="btn btn-primary seach"  type="submit" class="btn btn-primary me-2 seach">
            <i class="fa-solid fa-magnifying-glass"></i> Tìm kiếm
        </button>
        <a href="{{ route('admin.payment_methods.create') }}" class="btn btn-success">
            <i class="fa-solid fa-plus"></i> Thêm mới phương thức thanh toán
        </a>
    </form>
    
</div>