<form action="{{route("admin.shipping_fee.update",$data->id)}}" method="POST" class="form-update" style="background-color: white; padding:40px" novalidate >
    @csrf
    @method("PUT")
    <div class="row">
        <div class="col-md-4">
                <h2>Thông tin nhãn hàng</h2>
                <span>
                    Những trường có dấu ("*") là những trường bắt buộc và không được bỏ trống
                </span>

        </div>
        <div class="col-md-8" style="padding:20px 0 0 50px">
            <div class="row" style="display: flex; flex-wrap:wrap">
                <div class="form-group col-md-4">
                    <label for="">Tên thành phố*</label>
                    <select name="province_code" id="" class="form-control">
                        <option value="">- Chọn thành phố -</option>
                        @foreach($provinces as $province)
                            <option value="{{$province->code}}"  {{ $data->province_code == $province->code ? 'selected' : '' }}>{{$province->name}}</option>
                        @endforeach
                    </select>
                     <p  class=" text-danger message-error"></p>
                </div>
                <div class="form-group col-md-4">
                    <label for="">phí ship</label>
                    <input type="number"  name="fee" class="form-control" value="{{$data->fee}}" autocomplete="">
                    <p  class=" text-danger message-error"></p>
                </div>
                <div class="form-group col-md-4">
                    <label for="">trọng lượng tối đa</label>
                    <input type="number"  name="weight_limit" class="form-control" value="{{$data->weight_limit}}" autocomplete="">
                    <p  class=" text-danger message-error"></p>
                </div>

            </div>
        </div>
    </div>
    <div class="row text-right mt-4">
          <button class="btn btn-primary">Sửa</button>
    </div>
</form>
