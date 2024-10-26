<table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>Tài khoản</th>
                <th>Người dùng</th>
                <th>Số lượng sản phẩm</th>
                <th>Số lượt đánh giá</th>
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
                        data-province="{{ $user->province->name }}" 
                        data-district="{{ $user->district->name }}" 
                        data-ward="{{ $user->ward->name }}" 
                        data-avatar="{{ asset($user->avatar) }}"
                        style="cursor: pointer;">
                        {{ $user->username }}
                    </a>
                </td>
                <td>{{ $user->full_name }}</td> 
                <td>{{ $user->product_count }}</td>
                <td>{{ $user->review_count }}</td> 
                <td>
                    <center><a class="btn btn-sm btn-info" href="{{ route('admin.product_review.user_reviews', $user->id) }}" data-toggle="tooltip" data-placement="top" title="Xem chi tiết"><i class="fa fa-paste"></i></a></center>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modal -->
<div class="modal fade" id="userDetailModal" tabindex="-1" role="dialog" aria-labelledby="userDetailModalLabel" aria-hidden="true">
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
                </div>
                <div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px">
                        <div>
                            <div><strong>Tên đầy đủ:</strong></div>
                            <div style="border: 1px solid #ccc; padding: 8px; background-color: #f9f9f9; border-radius: 5px">
                                <span id="userFullName"></span>
                            </div>
                        </div>
                        <div>
                            <div><strong>Email:</strong></div>
                            <div style="border: 1px solid #ccc; padding: 8px; background-color: #f9f9f9; border-radius: 5px">
                                <span id="userEmail"></span>
                            </div>
                        </div>
                    </div>
                    <div style="margin-top: 10px; display: grid; grid-template-columns: 1fr 1fr; gap: 10px">
                        <div>
                            <div><strong>Tên người dùng:</strong></div>
                            <div style="border: 1px solid #ccc; padding: 8px; background-color: #f9f9f9; border-radius: 5px">
                                <span id="userName"></span>
                            </div>
                        </div>
                        <div>
                            <div><strong>Số điện thoại:</strong></div>
                            <div style="border: 1px solid #ccc; padding: 8px; background-color: #f9f9f9; border-radius: 5px">
                                <span id="userPhone"></span>
                            </div>
                        </div>
                    </div>
                    <div style="margin-top: 10px; display: grid; grid-template-columns: 1fr 1fr; gap: 10px">
                        <div>
                            <div><strong>Địa chỉ:</strong></div>
                            <div style="border: 1px solid #ccc; padding: 8px; background-color: #f9f9f9; border-radius: 5px">
                                <span id="userAddress"></span>
                            </div>
                        </div>
                        <div>
                            <div><strong>Ngày sinh:</strong></div>
                            <div style="border: 1px solid #ccc; padding: 8px; background-color: #f9f9f9; border-radius: 5px">
                                <span id="userBirthday"></span>
                            </div>
                        </div>
                    </div>
                    <div style="margin-top: 10px; display: grid; grid-template-columns: 1fr 1fr; gap: 10px">
                        <div>
                            <div><strong>Tỉnh/Thành phố:</strong></div>
                            <div style="border: 1px solid #ccc; padding: 8px; background-color: #f9f9f9; border-radius: 5px">
                                <span id="userProvince"></span>
                            </div>
                        </div>
                        <div>
                            <div><strong>Quận/Huyện:</strong></div>
                            <div style="border: 1px solid #ccc; padding: 8px; background-color: #f9f9f9; border-radius: 5px">
                                <span id="userDistrict"></span>
                            </div>
                        </div>
                    </div>
                    <div style="margin-top: 10px">
                        <div><strong>Phường/Xã:</strong></div>
                        <div style="border: 1px solid #ccc; padding: 8px; background-color: #f9f9f9; border-radius: 5px">
                            <span id="userWard"></span>
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