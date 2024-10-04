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
                    <input type="text" id="code" class="form-control" name="code" required>
                    <p class=" text-danger message-error"></p>
                </div>

                <div class="form-group col-md-6">
                    <label for="discount_type">Loại giảm giá:</label>
                    <select id="discount_type" class="form-control" name="discount_type" required>
                        <option value="percentage">Phần trăm</option>
                        <option value="fixed">Cố định</option>
                    </select>
                    <p class=" text-danger message-error"></p>
                </div>


                <div class="form-group col-md-6">
                    <label for="discount_value">Giá trị giảm:</label>
                    <input type="number" class="form-control" id="discount_value" name="discount_value" required>
                    <p class=" text-danger message-error"></p>
                </div>


                <div class="form-group col-md-6">
                    <label for="status">Trạng thái:</label>
                    <select id="status" class="form-control" name="status" required>
                        <option value="1">Hoạt động</option>
                        <option value="0">Không hoạt động</option>
                    </select>
                    <p class=" text-danger message-error"></p>
                </div>

                <div class="form-group col-md-6">
                    <label for="start_date">Ngày bắt đầu:</label>
                    <input type="datetime-local" id="start_date" class="form-control" name="start_date" required>
                    <p class=" text-danger message-error"></p>
                </div>

                <div class="form-group col-md-6">
                    <label for="end_date">Ngày kết thúc:</label>
                    <input type="datetime-local" id="end_date" class="form-control" name="end_date" required>
                    <p class=" text-danger message-error"></p>
                </div>
                <div class="form-group col-md-6">
                    <label for="max_uses">Số lượt được sử dụng:</label>
                    <input type="number" class="form-control" id="max_uses" name="max_uses" required>
                    <input type="hidden" id="used_count" class="form-control" name="used_count" value="0"
                        readonly>
                    <p class=" text-danger message-error"></p>
                </div>

            </div>
            <div class="row text-right mt-4">
                <button type="submit" class="btn btn-primary">Thêm mới</button>
            </div>
        </div>

    </div>
    </div>

</form>
