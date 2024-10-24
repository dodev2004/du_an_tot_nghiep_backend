<form action="{{ route('admin.payment_methods.update', $paymentMethods->id) }}" method="POST" class="form-update"
    style="background-color: white; padding:40px" novalidate>
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-md-4">
            <h2>Thông tin phương thức thanh toán</h2>
            <span>
                Những trường có dấu ("*") là những trường bắt buộc và không được bỏ trống
            </span>

        </div>
        <div class="col-md-8" style="padding:20px 0 0 50px">
            <div class="row" style="display: flex; flex-wrap:wrap">
                <div class="form-group col-md-12">
                    <label for="">Tên phương thức thanh toán <span style="color: red;">*</span></label>
                    <input type="text" class="form-control" name="name" placeholder="Nhập tên phương thức thanh toán "
                        value="{{ $paymentMethods->name }}">
                    <p class=" text-danger message-error"></p>
                </div>

                <div class="form-group col-md-12">
                    <label for="">Mô tả</label>
                    <textarea name="description" cols="30" class="form-control" rows="10"> {{ $paymentMethods->description }}
                    </textarea>

                    <p class=" text-danger"></p>

                </div>

            </div>
        </div>
    </div>
    <div class="row text-right mt-4">
        <button type="submit" class="btn btn-primary">Sửa</button>
    </div>
</form>