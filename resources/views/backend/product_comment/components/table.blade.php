<table class="table table-bordered">
    <thead>
        <tr>
            <th>Người dùng</th>
            <th>Số lượng sản phẩm</th>
            <th>Số lượng bình luận</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
            <tr>
                <td>
                    <a type="button" class="view-user-detail" data-toggle="tooltip" data-placement="top" title="Chi tiết người dùng"
                        data-full-name="{{ $user->full_name }}" 
                        data-email="{{ $user->email }}" 
                        data-username="{{ $user->username }}" 
                        data-phone="{{ $user->phone }}" 
                        data-address="{{ $user->address }}" 
                        data-birthday="{{ $user->birthday }}" 
                        data-province="{{ $user->province_id }}" 
                        data-district="{{ $user->district_id }}" 
                        data-ward="{{ $user->ward_id }}" 
                        data-avatar="{{ asset($user->avatar) }}"
                        style="cursor: pointer;">
                        {{ $user->full_name }}
                    </a>
                </td>
                <td>{{ $user->product_count }}</td>
                <td>{{ $user->product_comments_count }}</td> 
                <td>
                    <center><a class="btn btn-sm btn-info" href="{{ route('admin.product_comment.user_comments', $user->id) }}" data-toggle="tooltip" data-placement="top" title="Xem chi tiết"><i class="fa fa-paste"></i></a></center>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<!-- Modal -->
<div class="modal fade" id="userDetailModal" tabindex="-1" role="dialog" aria-labelledby="userDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userDetailModalLabel">Chi Tiết Người Dùng</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>Tên đầy đủ:</strong> <span id="userFullName"></span></p>
                <p><strong>Email:</strong> <span id="userEmail"></span></p>
                <p><strong>Tên người dùng:</strong> <span id="userName"></span></p>
                <p><strong>Số điện thoại:</strong> <span id="userPhone"></span></p>
                <p><strong>Địa chỉ:</strong> <span id="userAddress"></span></p>
                <p><strong>Ngày sinh:</strong> <span id="userBirthday"></span></p>
                <p><strong>Tỉnh/Thành phố:</strong> <span id="userProvince"></span></p>
                <p><strong>Quận/Huyện:</strong> <span id="userDistrict"></span></p>
                <p><strong>Phường/Xã:</strong> <span id="userWard"></span></p>
                <p><strong>Avatar:</strong> <img id="userAvatar" src="" alt="Avatar" style="max-width: 100px;"></p>
                <!-- Thêm các trường khác nếu cần -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
