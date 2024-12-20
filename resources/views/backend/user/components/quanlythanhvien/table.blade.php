<table class="table table-bordered">
    <thead>
        <tr>
            <th>Tài khoản</th>
            <th>Họ và tên</th>
            <th>Email</th>
            <th>Số điện thoại</th>
            <th>Địa chỉ</th>
            <th>Vai trò</th>
            <th>Trạng thái</th>
            <th class="text-center">Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $index => $user)
            <tr>
                <td>{{ $user->username }}</td>
                <td>{{ $user->full_name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->phone ? $user->phone : 'Dữ liệu chưa có' }}</td>
                <td>{{ $user->address ? $user->address : 'Dữ liệu chưa có' }}</td>
                <td>
                    @if ($user->roles->isNotEmpty())
                        @foreach ($user->roles as $role)
                            <span class="badge badge-info">{{ $role->name }}</span>
                        @endforeach
                    @else
                        Không có vai trò
                    @endif
                </td>
                <td>
                @if(!$user->hasRole('admin'))

                    <form name="form_status" action="">
                        @csrf
                        <input type="hidden" name="attribute" value="status">
                        <input type="hidden" name="table" value="{{ $table }}">
                        <input type="checkbox" @if ($user->status == 1) checked @endif
                            data-id="{{ $user->id }}" class="js-switch js-switch_{{ $user->id }}"
                            style="display: none;" data-switchery="true">
                    </form>
                @endif
                </td>
                <td>
                    <div class="" style="display:flex;justify-content: center;column-gap: 12px">
                        <a type="button" class="view-user-detail btn btn-info" data-toggle="tooltip"
                            data-placement="top" title="Chi tiết người dùng"
                            data-full-name="{{ $user->full_name ?: null }}" data-email="{{ $user->email ?: null }}"
                            data-username="{{ $user->username ?: null }}" data-phone="{{ $user->phone ?: null }}"
                            data-address="{{ $user->address ?: null }}"
                            data-birthday="{{ \Carbon\Carbon::parse($user->birthday)->format('d/m/Y') ?: null }}"
                            data-province="{{ $user->province->name ?? null }}"
                            data-district="{{ $user->district->name ?? null }}"
                            data-ward="{{ $user->ward->name ?? null }}"
                            data-avatar="{{ $user->avatar ? asset($user->avatar) : null }}"
                            data-created_at="{{ $user->created_at ?? null }}" style="cursor: pointer;">
                            <i class="fa fa-eye"></i>
                        </a>
                        @if(!$user->hasRole('admin'))

                        <a class="btn btn-sm btn-info" href="{{ route('admin.users.edit', $user->id) }}"
                            title="Chỉnh sửa"><i class="fa fa-pencil"></i></a>
                        @else
                        <a href="{{ route('permission.denied') }}" class="btn btn-sm btn-info" title="Không có quyền">
                        <i class="fa fa-pencil"></i>
                        </a> {{-- Hiển thị nút xóa nhưng không cho phép --}}
                        @endif
                        @if(auth()->user()->hasPermission('deleteUser')&& $user->id != auth()->id()&&!$user->hasRole('admin'))

                        <form action="" method="POST" data-url="users" class="form-delete">
                            @method('DELETE')
                            @csrf
                            <input type="hidden" value="{{ $user->id }}" name="id">
                            <button class="btn btn-warning center" title="Xóa"><i class="fa fa-trash-o"></i></button>
                        </form>

                        @else
                        <a href="{{ route('permission.denied') }}" class="btn btn-warning center" title="Không có quyền">
                            <i class="fa fa-trash-o"></i>
                        </a> {{-- Hiển thị nút xóa nhưng không cho phép --}}
                        @endif
                    </div>

                </td>
            </tr>
        @endforeach

    </tbody>

</table>
<!-- Modal -->
<div class="modal fade" id="userDetailModal" tabindex="-1" role="dialog" aria-labelledby="userDetailModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width: 800px;">
            <div>
                <h5 id="userDetailModalLabel" style="font-size: 16px; padding: 10px">Chi Tiết Người Dùng</h5>
                <hr>
            </div>
            <div style="display: grid; grid-template-columns: 40% 60%; padding: 10px">
                <div style="text-align: center">
                    <div><strong>Avatar:</strong></div>
                    <div><img id="userAvatar" src="" alt="Avatar người dùng" width="77%" /></div>
                    <span id="avatarMessage"></span>
                </div>
                <div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px">
                        <div>
                            <div><strong>Tên đầy đủ:</strong></div>
                            <div
                                style="border: 1px solid #ccc; padding: 8px; background-color: #f9f9f9; border-radius: 5px">
                                <span id="userFullName"></span>
                            </div>
                        </div>
                        <div>
                            <div><strong>Email:</strong></div>
                            <div
                                style="border: 1px solid #ccc; padding: 8px; background-color: #f9f9f9; border-radius: 5px">
                                <span id="userEmail"></span>
                            </div>
                        </div>
                    </div>
                    <div style="margin-top: 10px; display: grid; grid-template-columns: 1fr 1fr; gap: 10px">
                        <div>
                            <div><strong>Tài khoản người dùng:</strong></div>
                            <div
                                style="border: 1px solid #ccc; padding: 8px; background-color: #f9f9f9; border-radius: 5px">
                                <span id="userName"></span>
                            </div>
                        </div>
                        <div>
                            <div><strong>Số điện thoại:</strong></div>
                            <div
                                style="border: 1px solid #ccc; padding: 8px; background-color: #f9f9f9; border-radius: 5px">
                                <span id="userPhone"></span>
                            </div>
                        </div>
                    </div>
                    <div style="margin-top: 10px; display: grid; grid-template-columns: 1fr 1fr; gap: 10px">
                        <div>
                            <div><strong>Địa chỉ:</strong></div>
                            <div
                                style="border: 1px solid #ccc; padding: 8px; background-color: #f9f9f9; border-radius: 5px">
                                <span id="userAddress"></span>
                            </div>
                        </div>
                        <div>
                            <div><strong>Ngày sinh:</strong></div>
                            <div
                                style="border: 1px solid #ccc; padding: 8px; background-color: #f9f9f9; border-radius: 5px">
                                <span id="userBirthday"></span>
                            </div>
                        </div>
                    </div>
                    <div style="margin-top: 10px; display: grid; grid-template-columns: 1fr 1fr; gap: 10px">
                        <div>
                            <div><strong>Tỉnh/Thành phố:</strong></div>
                            <div
                                style="border: 1px solid #ccc; padding: 8px; background-color: #f9f9f9; border-radius: 5px">
                                <span id="userProvince"></span>
                            </div>
                        </div>
                        <div>
                            <div><strong>Quận/Huyện:</strong></div>
                            <div
                                style="border: 1px solid #ccc; padding: 8px; background-color: #f9f9f9; border-radius: 5px">
                                <span id="userDistrict"></span>
                            </div>
                        </div>
                    </div>
                    <div style="margin-top: 10px; display: grid; grid-template-columns: 1fr 1fr; gap: 10px">
                        <div>
                            <div><strong>Phường/Xã:</strong></div>
                            <div
                                style="border: 1px solid #ccc; padding: 8px; background-color: #f9f9f9; border-radius: 5px">
                                <span id="userWard"></span>
                            </div>
                        </div>
                        <div>
                            <div><strong>Ngày tạo tài khoản:</strong></div>
                            <div
                                style="border: 1px solid #ccc; padding: 8px; background-color: #f9f9f9; border-radius: 5px">
                                <span id="created_at"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
