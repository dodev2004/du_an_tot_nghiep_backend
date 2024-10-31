<form action="{{ route('admin.role.store') }}" method="POST" class="form-add" style="background-color: white; padding:40px "
    novalidate>
    @csrf
    <div class="row ">
        <div class="col-md-12" style="width: 500px; border: 1px solid #ddd; border-radius: 8px;margin-left: 300px ; padding: 20px ">
            <div >
                <div class="form-group">
                <label>Tên vai trò <span style="color: red;">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Mời nhập tên vai trò" value="{{ old('name') }}">
                    <p class=" text-danger message-error"></p>
                </div>
                <div class="form-group">
                    <label>Mô tả vai trò <span style="color: red;">*</span></label>
                    <input type="text" class="form-control" id="description" name="description"
                        value="{{ old('description') }}" placeholder="Mời nhập mô tả">
                    <p class=" text-danger message-error"></p>
                </div>
                <label>
                    <input type="checkbox" id="selectAllPermissions" />
                    Chọn tất cả
                </label>
                <div class="form-group">
                    <label for="permissions">Chọn quyền hạn</label>
                    @foreach ($groupPermissions as $group)
                        <div class="permission-group">
                            <h5 style="font-weight: bold">{{ $group->name }}</h5>
                            @foreach ($group->permissions as $permission)
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="permissions" name="permissions[]"
                                        value="{{ $permission->id }}" class="form-control">
                                    <label class="form-check-label">{{ $permission->name }}</label>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                    <p class="text-danger message-error-permissions"></p>
                </div>

            </div>
            <button class="btn btn-success" style=" float: right; margin-right: 50px" type="submit">Thêm mới</button>
        </div>

    </div>
    </div>

</form>
