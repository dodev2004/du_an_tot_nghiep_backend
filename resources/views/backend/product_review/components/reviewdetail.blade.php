<table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>Người dùng</th>
                <th>Đánh giá</th>
                <th>Số sao</th>
                <th>Mã đơn hàng</th>
                <th>Loại hàng</th>
                <th>Ngày</th>
                <th>Phản hồi khách hàng</th>
                <th>Trạng thái</th>
                <th>Hoạt động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $review)
            <tr>
                <td>
                    <a type="button" class="view-user-detail" data-toggle="tooltip" data-placement="top" title="Chi tiết người dùng"
                            data-full-name="{{ $review->orderItem->order->customer_name ?? ''}}" 
                            data-email="{{ $review->orderItem->order->email ?? ''}}" 
                            data-phone="{{ $review->orderItem->order->phone_number ?? ''}}" 
                            data-address="{{ $review->orderItem->order->shipping_address ?? ''}}" 
                            data-avatar="{{ asset($review->orderItem->order->user->avatar) ?? '' }}"
                            style="cursor: pointer;">
                            {{ $review->orderItem->order->user->username }}
                        </a>
                </td>

                <td style="width: 150px;">{{ $review->review }}</td>
                <td>
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= $review->rating)
                            <i class="fas fa-star text-warning"></i> <!-- Sao sáng (vàng) -->
                        @else
                            <i class="far fa-star text-secondary"></i> <!-- Sao tối (màu xám) -->
                        @endif
                    @endfor
                </td>
                <td style="text-align: center;">BND-{{ $review->orderItem->order_id }}</td>
                <td style="width: 150px;">Lựa chọn : {{implode(" x ",json_decode($review->orderitem->variant, true))}} </td>
                <td>{{ $review->created_at->format('d/m/Y') }}</td>
                <td style="width: 200px;">
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
                <td class="text-center">
                    <form name="form_status" action="">
                        @csrf
                        <input type="hidden" name="attribute" value="status">
                        <input type="hidden" name="table" value="{{$table}}">
                        <input type="checkbox" data-id="{{ $review->id }}" @if ($review['status']==1) checked @endif
                            class="js-switch js-switch_{{ $review->id }}" style="display: none;" data-switchery="true">
                    </form>

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
                            <div><strong>Số điện thoại:</strong></div>
                            <div style="border: 1px solid #ccc; padding: 8px; background-color: #f9f9f9; border-radius: 5px">
                                <span id="userPhone"></span>
                            </div>
                        </div>
                        <div>
                            <div><strong>Địa chỉ:</strong></div>
                            <div style="border: 1px solid #ccc; padding: 8px; background-color: #f9f9f9; border-radius: 5px">
                                <span id="userAddress"></span>
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

