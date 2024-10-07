<div class="form_seach d-flex justify-content-between align-items-center">
    <form action="{{ route('admin.payment_methods') }}" method="GET"
        class="d-flex align-items-center">
        <input type="text" class="form-control me-2" name="keywords"
            value="{{ request('keywords') }}" placeholder="Tìm kiếm theo tên"
            style="max-width: 250px;">
        <button type="submit" class="btn btn-primary me-2 seach">
            <i class="fa-solid fa-magnifying-glass"></i> Tìm kiếm
        </button>
    </form>
    <a href="{{ route('admin.payment_methods.create') }}" class="btn btn-success">
        <i class="fa-solid fa-plus"></i> Thêm mới phương thức thanh toán
    </a>
</div>