<form action="{{ route('admin.role.store') }}" method="POST" class="form-update"
    style="background-color: white; padding:40px" novalidate>
    @csrf
    <div class="row">
        <div class="col-md-12" style="width: 500px; border: 1px solid #ddd; border-radius: 8px;margin-left: 300px ; padding: 20px ">
            <div class="ibox-content">
                <div class="form-group">
                    <label>Tên vai trò <span style="color: red;">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $role->name }}">
                    <p class=" text-danger message-error"></p>
                </div>
                <div class="form-group">
                    <label>Mô tả <span style="color: red;">*</span></label>
                    <input type="text" class="form-control" id="description" name="description" value="{{ $role->description }}">
                    <p class=" text-danger message-error"></p>
                </div>
                <div class="form-group">
                    <label for="permissions">Chọn quyền hạn</label>
                    @foreach ($groupPermissions as $group)
                        <div class="permission-group">
                            <h5 style="font-weight: bold">{{ $group->name }}</h5>
                            @foreach ($group->permissions as $permission)
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" class="form-control" id="permissions" name="permissions[]"
                                    value="{{ $permission->id }}" {{ in_array($permission->id, old('permissions', $rolePermissions)) ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ $permission->name }}</label>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                    {{-- <select multiple class="form-control" id="permissions" name="permissions[]" required>
                        <!-- Hiển thị quyền theo từng nhóm quyền -->
                        @foreach ($groupPermissions as $group)
                            <optgroup label="{{ $group->name }}">
                                @foreach ($group->permissions as $permission)
                                    <option value="{{ $permission->id }}"
                                        {{ in_array($permission->id, old('permissions', $rolePermissions)) ? 'selected' : '' }}>
                                        {{ $permission->name }}
                                    </option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select> --}}
                    <p class="text-danger message-error"></p>
                </div>
                <button class="btn btn-success" style=" float: right; margin-right: 50px" type="submit">Cập nhật</button>
            </div>
        </div>

    </div>
    </div>

</form>
