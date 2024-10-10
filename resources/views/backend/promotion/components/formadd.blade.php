<form id="promotionForm" action="{{ route('admin.promotions.store') }}" method="POST" class="form-add"
    style="background-color: white; padding:40px" novalidate>
    @csrf
    <div class="row">
        <div class="col-md-4">
            <h2>Thông tin khuyến mãi</h2>
            <span>
                Những trường có dấu ("*") là những trường bắt buộc và không được bỏ trống.
            </span>
        </div>
        <div class="col-md-8" style="padding:20px 0 0 50px">
            <div class="row" style="display: flex; flex-wrap:wrap">

                <div class="form-group col-md-6">
                    <label for="code">Mã:</label>
                    <input type="text" id="code" class="form-control" name="code" value="{{ old('code') }}" required>
                    @if ($errors->has('code'))
                        <p class="text-danger">{{ $errors->first('code') }}</p>
                    @endif
                </div>

                <div class="form-group col-md-6">
                    <label for="discount_type">Loại giảm giá:</label>
                    <select id="discount_type" class="form-control" name="discount_type" required>
                        <option value="percentage" {{ old('discount_type') == 'percentage' ? 'selected' : '' }}>Phần trăm</option>
                        <option value="fixed" {{ old('discount_type') == 'fixed' ? 'selected' : '' }}>Cố định</option>
                    </select>
                    @if ($errors->has('discount_type'))
                        <p class="text-danger">{{ $errors->first('discount_type') }}</p>
                    @endif
                </div>

                <div class="form-group col-md-6">
                    <label for="discount_value">Giá trị giảm:</label>
                    <input type="number" class="form-control" id="discount_value" name="discount_value" value="{{ old('discount_value') }}" required>
                    @if ($errors->has('discount_value'))
                        <p class="text-danger">{{ $errors->first('discount_value') }}</p>
                    @endif
                </div>

                <div class="form-group col-md-6">
                    <label for="status">Trạng thái:</label>
                    <select id="status" class="form-control" name="status" required>
                        <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Hoạt động</option>
                        <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Không hoạt động</option>
                    </select>
                    @if ($errors->has('status'))
                        <p class="text-danger">{{ $errors->first('status') }}</p>
                    @endif
                </div>

                <div class="form-group col-md-6">
                    <label for="start_date">Ngày bắt đầu:</label>
                    <input type="date" id="start_date" class="form-control" name="start_date" value="{{ old('start_date') }}" required>
                    @if ($errors->has('start_date'))
                        <p class="text-danger">{{ $errors->first('start_date') }}</p>
                    @endif
                </div>

                <div class="form-group col-md-6">
                    <label for="end_date">Ngày kết thúc:</label>
                    <input type="date" id="end_date" class="form-control" name="end_date" value="{{ old('end_date') }}" required>
                    @if ($errors->has('end_date'))
                        <p class="text-danger">{{ $errors->first('end_date') }}</p>
                    @endif
                </div>

                <div class="form-group col-md-6">
                    <label for="max_uses">Số lượt được sử dụng:</label>
                    <input type="number" class="form-control" id="max_uses" name="max_uses" value="{{ old('max_uses') }}" required>
                    <input type="hidden" id="used_count" class="form-control" name="used_count" value="0" readonly>
                    @if ($errors->has('max_uses'))
                        <p class="text-danger">{{ $errors->first('max_uses') }}</p>
                    @endif
                </div>

            </div>
            <div class="row text-right mt-4">
                <button type="submit" class="btn btn-primary">Thêm mới</button>
            </div>
        </div>

    </div>
</form>