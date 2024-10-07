<form
    action="{{ isset($promotion) ? route('admin.promotions.update', $promotion->id) : route('admin.promotions.store') }}"
    method="POST" class="form-add" style="background-color: white; padding:40px" novalidate>
    @csrf
    @method('PUT')

    <div class="row">
        <div class="col-md-4">
            <h2>Thông tin khuyến mãi</h2>
            <span>
                Những trường có dấu ("*") là những trường bắt buộc và không được bỏ trống.
            </span>
        </div>
        <div class="col-md-8" style="padding:20px 0 0 50px">
            <div class="row" style="display: flex; flex-wrap:wrap">
                <!-- Mã giảm giá -->
                <div class="form-group col-md-6">
                    <label for="code">Mã giảm giá*</label>
                    <input type="text" name="code" class="form-control"
                        value="{{ old('code', isset($promotion) ? $promotion->code : '') }}" autocomplete="" required>
                    <p class="text-danger message-error"></p>
                </div>

                <!-- Loại giảm giá -->
                <div class="form-group col-md-6">
                    <label for="discount_type">Loại giảm giá*</label>
                    <select name="discount_type" class="form-control" required>
                        <option value="">Lựa chọn loại giảm giá</option>
                        <option value="percentage"
                            {{ old('discount_type', isset($promotion) && $promotion->discount_type == 'percentage' ? 'selected' : '') }}>
                            Phần trăm</option>
                        <option value="fixed"
                            {{ old('discount_type', isset($promotion) && $promotion->discount_type == 'fixed' ? 'selected' : '') }}>
                            Cố định</option>
                    </select>
                    <p class="text-danger message-error"></p>
                </div>

                <!-- Giá trị giảm -->
                <div class="form-group col-md-6">
                    <label for="discount_value">Giá trị giảm*</label>
                    <input type="number" name="discount_value" class="form-control"
                        value="{{ old('discount_value', isset($promotion) ? $promotion->discount_value : '') }}"
                        required>
                    <p class="text-danger message-error"></p>
                </div>

                <!-- Trạng thái -->
                <div class="form-group col-md-6">
                    <label for="status">Trạng thái*</label>
                    <select name="status" class="form-control" required>
                        <option value="">Chọn trạng thái</option>
                        <option value="active"
                            {{ old('status', isset($promotion) && $promotion->status == 'active' ? 'selected' : '') }}>
                            Hoạt động</option>
                        <option value="inactive"
                            {{ old('status', isset($promotion) && $promotion->status == 'inactive' ? 'selected' : '') }}>
                            Không hoạt động</option>
                    </select>
                    <p class="text-danger message-error"></p>
                </div>

                <div class="form-group col-md-6">
                    <label for="start_date">Ngày bắt đầu*</label>
                    <input type="date" name="start_date" class="form-control"
                        value="{{ old('start_date', isset($promotion) ? \Carbon\Carbon::parse($promotion->start_date)->format('Y-m-d') : '') }}" required>
                    <p class="text-danger message-error"></p>
                </div>
                
                <!-- Ngày kết thúc -->
                <div class="form-group col-md-6">
                    <label for="end_date">Ngày kết thúc*</label>
                    <input type="date" name="end_date" class="form-control"
                        value="{{ old('end_date', isset($promotion) ? \Carbon\Carbon::parse($promotion->end_date)->format('Y-m-d') : '') }}" required>
                    <p class="text-danger message-error"></p>
                </div>

                <!-- Số lượt sử dụng tối đa -->
                <div class="form-group col-md-6">
                    <label for="max_uses">Số lượt sử dụng tối đa*</label>
                    <input type="number" name="max_uses" class="form-control"
                        value="{{ old('max_uses', isset($promotion) ? $promotion->max_uses : '') }}" required>
                    <p class="text-danger message-error"></p>
                </div>

                <!-- Số lượt đã sử dụng -->
                <div class="form-group col-md-6">
                    <label for="used_count">Số lượt đã sử dụng</label>
                    <input type="number" name="used_count" class="form-control"
                        value="{{ old('used_count', isset($promotion) ? $promotion->used_count : 0) }}" readonly>
                    <p class="text-danger message-error"></p>
                </div>
            </div>
        </div>
    </div>
    <div class="row text-right mt-4">
        <button class="btn btn-primary">{{ isset($promotion) ? 'Cập nhật' : 'Thêm mới' }}</button>
    </div>
</form>
