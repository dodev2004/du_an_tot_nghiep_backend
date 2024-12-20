<form action="{{ route('admin.payment_methods.store') }}" method="POST" class="form-user_catelogue_create"
    style="background-color: white; padding:40px" novalidate enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-4">
            <h2>Thêm phương thức thanh toán</h2>
            <span>Những trường có dấu ("*") là những trường bắt buộc và không được bỏ trống</span>
        </div>
        <div class="col-md-8 " style="padding:20px 0 0 50px">
            <div class="row" style="display: flex; flex-wrap:wrap">
                <div class="form-group col-md-12">
                    <label for="name">Tên phương thức thanh toán <span style="color: red;">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
                    @if ($errors->has('name'))
                    <p class="text-danger">{{ $errors->first('name') }}</p>
                    @endif
                </div>
                <div class="form-group col-md-12">
                    <label for="description">Mô tả</label>
                    <textarea name="description" class="form-control" rows="10">{{ old('description') }}</textarea>
                    @if ($errors->has('description'))
                    <p class="text-danger">{{ $errors->first('description') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="text-right mt-4">
        <button type="submit" class="btn btn-primary">Thêm mới</button>
    </div>
</form>