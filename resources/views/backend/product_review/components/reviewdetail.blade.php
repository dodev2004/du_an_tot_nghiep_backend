<table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>Người dùng</th>
                <th>Đánh giá</th>
                <th>Số sao</th>
                <th>Ngày</th>
                <th>Phản hồi khách hàng</th>
                <th>Hoạt động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $review)
            <tr>
                <td>
                    <a type="button" class="view-user-detail" data-toggle="tooltip" data-placement="top" title="Chi tiết người dùng"
                            data-full-name="{{ $review->user->full_name ?? ''}}" 
                            data-username="{{ $review->user->username ?? ''}}" 
                            data-email="{{ $review->user->email ?? ''}}" 
                            data-reviewname="{{ $review->user->reviewname ?? ''}}" 
                            data-phone="{{ $review->user->phone ?? ''}}" 
                            data-address="{{ $review->user->address ?? ''}}" 
                            data-birthday="{{ $review->user->birthday ?? ''}}" 
                            data-province="{{ $review->user->province->name ?? ''}}" 
                            data-district="{{ $review->user->district->name ?? ''}}" 
                            data-ward="{{ $review->user->ward->name ?? ''}}" 
                            data-avatar="{{ asset($review->user->avatar) ?? '' }}"
                            style="cursor: pointer;">
                            {{ $review->user->username }}
                        </a>
                </td>
                <td>{{ $review->review }}</td>
                <td>
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= $review->rating)
                            <i class="fas fa-star text-warning"></i> <!-- Sao sáng (vàng) -->
                        @else
                            <i class="far fa-star text-secondary"></i> <!-- Sao tối (màu xám) -->
                        @endif
                    @endfor
                </td>
                
                <td>{{ $review->created_at->format('d/m/Y') }}</td>
                <td>
                    @if($review->comments->isNotEmpty())
                        <ul>
                            @foreach($review->comments as $comment)
                                <li>
                                     {{ $comment->comment }} 
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>Chưa có phản hồi nào.</p>
                    @endif
                </td>
                <td>
                    <center><a href="{{ route('product_comment.create', ['id' => $review->id]) }}" class="btn btn-sm btn-info"><i class="fa-solid fa-comment-dots"></i></a></center>
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
