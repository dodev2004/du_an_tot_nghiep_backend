<form action="{{route("admin.permission.update",$data->id)}}" method="POST" class="form-update" style="background-color: white; padding:40px" novalidate >
    @csrf
    @method("PUT")
    <div class="row">
        <div class="col-md-4">
                <h2>Thông tin nhóm quyền</h2>
                <span>
                    Những trường có dấu ("*") là những trường bắt buộc và không được bỏ trống
                </span>

        </div>
        <div class="col-md-8" style="padding:20px 0 0 50px">
            <div class="row" style="display: flex; flex-wrap:wrap">
                <div class="form-group col-md-6">
                    <label for="">Tên nhóm quyền*</label>
                    <input type="text"  name="name" class="form-control" value="{{old("name") ?? $data->name}}" autocomplete="">
                     <p  class=" text-danger message-error"></p>
                </div>
                <div class="form-group col-md-6">
                    <label for="">Miêu tả*</label>
                    <input type="text"  name="description" class="form-control" value="{{old("description") ?? $data->description}}" autocomplete="">
                    <p  class=" text-danger message-error"></p>
                </div>

            </div>
        </div>
    </div>
    <div class="row text-right mt-4">
          <button class="btn btn-primary">Sửa</button>
    </div>
</form>
