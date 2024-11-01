<table class="table table-bordered">
    <thead>
        <tr>
            <th>Người dùng</th>
            <th>Nhân viên phản hồi</th>
            <th>Bình luận</th>
            <th>Ngày tạo</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $comment)
        <tr>
            <td>
            <a type="button" class="view-user-detail" data-toggle="tooltip" data-placement="top" title="Chi tiết người dùng"
                    data-full-name="{{ $comment->review->user->full_name ?? ''}}" 
                    data-username="{{ $comnent->review->user->username ?? ''}}" 
                    data-email="{{ $comment->review->user->email ?? ''}}" 
                    data-username="{{ $comment->review->user->username ?? ''}}" 
                    data-phone="{{ $comment->review->user->phone ?? ''}}" 
                    data-address="{{ $comment->review->user->address ?? ''}}" 
                    data-birthday="{{ $comment->review->user->birthday ?? ''}}" 
                    data-province="{{ $comment->review->user->province->name ?? ''}}" 
                    data-district="{{ $comment->review->user->district->name ?? ''}}" 
                    data-ward="{{ $comment->review->user->ward->name ?? ''}}" 
                    data-avatar="{{ asset($comment->review->user->avatar) ?? '' }}"
                    style="cursor: pointer;">
                    {{ $comment->review->user->username }}
                </a>
            </td>
            <td>
                <a type="button" class="view-user-detail" data-toggle="tooltip" data-placement="top" title="Chi tiết người dùng"
                    data-full-name="{{ $comment->user->full_name ?? ''}}" 
                    data-username="{{ $comnent->user->username ?? ''}}" 
                    data-email="{{ $comment->user->email ?? ''}}" 
                    data-username="{{ $comment->user->username ?? ''}}" 
                    data-phone="{{ $comment->user->phone ?? ''}}" 
                    data-address="{{ $comment->user->address ?? ''}}" 
                    data-birthday="{{ $comment->user->birthday ?? ''}}" 
                    data-province="{{ $comment->user->province->name ?? ''}}" 
                    data-district="{{ $comment->user->district->name ?? ''}}" 
                    data-ward="{{ $comment->user->ward->name ?? ''}}" 
                    data-avatar="{{ asset($comment->user->avatar) ?? '' }}"
                    style="cursor: pointer;">
                    {{ $comment->user->username }}
                </a>
            </td>
            <td>{{ $comment->comment }}</td>
            <td>{{ $comment->created_at }}</td>

            <td>
                <form action="" method="POST" data-url="product-comment" style="text-align: center;"
                    class="form-delete">
                    @method("DELETE")
                    @csrf
                    <input type="hidden" value="{{$comment->id}}" name="id">
                    <button class="btn btn-danger center" data-toggle="tooltip" data-placement="top" title="Xóa"><i
                            class="fa fa-trash-o"></i></button>
                </form>
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
