<form
    action="{{ isset($promotion) ? route('admin.promotions.update', $promotion->id) : route('admin.promotions.store') }}"
    method="POST" class="form-add" style="background-color: white; padding:40px" novalidate>
    @csrf
    @if(isset($promotion))
    @method('PUT')
    @endif

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
                    <label for="code">Mã giảm giá <span style="color: red;">*</span></label>
                    <input type="text" name="code" class="form-control"
                        value="{{ old('code', isset($promotion) ? $promotion->code : '') }}" autocomplete="" required>
                    @if($errors->has('code'))
                    <p class="text-danger">{{ $errors->first('code') }}</p>
                    @endif
                </div>

                <!-- Loại giảm giá -->
                <div class="form-group col-md-6">
                    <label for="discount_type">Loại giảm giá <span style="color: red;">*</span></label>
                    <select name="discount_type" class="form-control" required>
                        <option value="">Lựa chọn loại giảm giá</option>
                        <option value="percentage"
                            {{ old('discount_type', isset($promotion) && $promotion->discount_type == 'percentage' ? 'selected' : '') }}>
                            Phần trăm</option>
                        <option value="fixed"
                            {{ old('discount_type', isset($promotion) && $promotion->discount_type == 'fixed' ? 'selected' : '') }}>
                            Cố định</option>
                    </select>
                    @if($errors->has('discount_type'))
                    <p class="text-danger">{{ $errors->first('discount_type') }}</p>
                    @endif
                </div>

                <!-- Giá trị giảm -->
                <div class="form-group col-md-6">
                    <label for="discount_value">Giá trị giảm <span style="color: red;">*</span></label>
                    <input type="number" name="discount_value" class="form-control"
                        value="{{ old('discount_value', isset($promotion) ? $promotion->discount_value : '') }}"
                        required>
                    @if($errors->has('discount_value'))
                    <p class="text-danger">{{ $errors->first('discount_value') }}</p>
                    @endif
                </div>

                <!-- Trạng thái -->
                <div class="form-group col-md-6">
                    <label for="status">Trạng thái <span style="color: red;">*</span></label>
                    <select name="status" class="form-control" required>
                        <option value="">Chọn trạng thái</option>
                        <option value="1" {{ old('status', $promotion->status) == 1 ? 'selected' : '' }}>Hoạt động
                        </option>
                        <option value="0" {{ old('status', $promotion->status) == 0 ? 'selected' : '' }}>Không hoạt động
                        </option>
                    </select>
                    @if($errors->has('status'))
                    <p class="text-danger">{{ $errors->first('status') }}</p>
                    @endif
                </div>

                <div class="form-group col-md-6">
                    <label for="start_date">Ngày bắt đầu*</label>
                    <input type="datetime-local" name="start_date" class="form-control"
                    value="{{ old('start_date', isset($promotion) ? Carbon\Carbon::parse($promotion->start_date)->format('Y-m-d\TH:i') : '') }}" required>
                    @if($errors->has('start_date'))
                    <p class="text-danger">{{ $errors->first('start_date') }}</p>
                    @endif
                </div>

                <div class="form-group col-md-6">
                    <label for="end_date">Ngày kết thúc*</label>
                    <input type="datetime-local" name="end_date" class="form-control"
                    value="{{ old('end_date', isset($promotion) ? Carbon\Carbon::parse($promotion->end_date)->format('Y-m-d\TH:i') : '') }}" required>
                    @if($errors->has('end_date'))
                    <p class="text-danger">{{ $errors->first('end_date') }}</p>
                    @endif
                </div>


                <div class="form-group col-md-6">
                    <label for="max_uses">Số lượt sử dụng tối đa <span style="color: red;">*</span></label>
                    <input type="number" name="max_uses" class="form-control"
                        value="{{ old('max_uses', isset($promotion) ? $promotion->max_uses : '') }}" required>
                    @if($errors->has('max_uses'))
                    <p class="text-danger">{{ $errors->first('max_uses') }}</p>
                    @endif
                </div>

                <div class="form-group col-md-6">
                    <label for="used_count">Số lượt đã sử dụng </label>
                    <input type="number" name="used_count" class="form-control"
                        value="{{ old('used_count', isset($promotion) ? $promotion->used_count : 0) }}" readonly>
                </div>
            </div>
        </div>
    </div>
    <div class="row text-right mt-4">
        <button class="btn btn-primary">{{ isset($promotion) ? 'Cập nhật' : 'Thêm mới' }}</button>
    </div>
</form>
