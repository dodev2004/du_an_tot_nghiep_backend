<form action="{{route("admin.permission.store")}}" method="POST" class="form-add" style="background-color: white; padding:40px" novalidate >
    @csrf
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
                    <label for="">Tên quyền*</label>
                    <input type="text"  name="name" class="form-control" value="{{old("name")}}" autocomplete="">
                     <p  class=" text-danger message-error"></p>
                </div>
                <div class="form-group col-md-6">
                    <label for="">Tên hiển thị*</label>
                    <input type="text"  name="display_name" class="form-control" value="{{old("display_name")}}" autocomplete="">
                     <p  class=" text-danger message-error"></p>
                </div>
                <div class="form-group col-md-6">
                    <label for="">Miêu tả*</label>
                    <input type="text"  name="description" class="form-control" value="{{old("description")}}" autocomplete="">
                    <p  class=" text-danger message-error"></p>
                </div>
                <div class="form-group col-md-6">
                    <label for="group_permission_id">Tên nhóm quyền*</label>
                    <select name="group_permission_id" class="form-control" required>
                        <option value="" disabled selected>Chọn nhóm quyền</option>
                        @foreach($groupPermissions as $groupPermission)
                            <option value="{{ $groupPermission->id }}">{{ $groupPermission->name }}</option>
                        @endforeach
                    </select>
                    <p class="text-danger message-error"></p>
                </div>

            </div>
        </div>
    </div>
    <div class="row text-right mt-4">
          <button class="btn btn-primary">Thêm mới</button>
    </div>
</form>
