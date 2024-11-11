<form action="{{ route('admin.role.store') }}" method="POST" class="form-add"
    style="background-color: white; padding:40px " novalidate>
    @csrf
    <div class="row ">
        <div class="col-md-12">
            <div>
                <div class="form-group">
                    <label>Tên vai trò <span style="color: red;">*</span></label>
                    <input type="text" class="form-control" id="name" name="name"
                        placeholder="Mời nhập tên vai trò" value="{{ old('name') }}">
                    <p class=" text-danger message-error"></p>
                </div>
                <div class="form-group">
                    <label>Mô tả vai trò <span style="color: red;">*</span></label>
                    <input type="text" class="form-control" id="description" name="description"
                        value="{{ old('description') }}" placeholder="Mời nhập mô tả">
                    <p class=" text-danger message-error"></p>
                </div>

                <div class="form-group">
                    <label for="permissions" style="font-size: 30px; font-weight: bold;">Chọn quyền</label><br>
                    <label style="font-size: 23px; font-weight: bold;">
                        <input type="checkbox" id="selectAllPermissions" />
                        Chọn tất cả
                    </label>
                    @foreach ($groupPermissions as $group)
                        <div class="permission-group">
                            <h5 style="font-weight: bold; font-size: 23px;">
                                <input type="checkbox" class="select-group-permission"
                                    data-group-id="{{ $group->id }}" />
                                {{ $group->name }}
                            </h5>
                            <div class="permissions-list">
                                @foreach ($group->permissions as $permission)
                                    <div class="form-check">
                                        <input type="checkbox"
                                            class="form-check-input group-permission-{{ $group->id }}"
                                            name="permissions[]" value="{{ $permission->id }}" id="permissions">
                                        <label class="form-check-label">{{ $permission->display_name }}</label>
                                    </div>
                                @endforeach
                            </div>
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
