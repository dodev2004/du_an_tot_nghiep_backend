<form action="{{ route('admin.role.store') }}" method="POST" class="form-add" style="background-color: white; padding:40px"
    novalidate>
    @csrf
    <div class="row">
        <div class="col-md-12">
            <div class="ibox-content">
                <div class="form-group">
                    <label>Tên vai trò</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                    <p class=" text-danger message-error"></p>
                </div>
                <div class="form-group">
                    <label>Mô tả</label>
                    <input type="text" class="form-control" id="description" name="description"
                        value="{{ old('description') }}">
                    <p class=" text-danger message-error"></p>
                </div>
                <div class="form-group">
                    <label for="permissions">Chọn quyền hạn</label>
                    @foreach ($groupPermissions as $group)
                        <div class="permission-group">
                            <h4>{{ $group->name }}</h4>
                            @foreach ($group->permissions as $permission)
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="permissions" name="permissions[]"
                                        value="{{ $permission->id }}" class="form-control">
                                    <label class="form-check-label">{{ $permission->name }}</label>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                    <p class="text-danger message-error"></p>
                </div>
                <button class="btn btn-success" type="submit">Thêm mới</button>
            </div>
        </div>

    </div>
    </div>

</form>
