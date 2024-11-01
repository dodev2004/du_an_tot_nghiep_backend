<table class="table table-bordered">
    <thead>
        <tr>
            <th>Tên người dùng</th>
            <th>Email</th>
            <th>Địa chỉ</th>
            <th>Số điện thoại</th>
            <th>Nội dung</th>
            <th>Trạng thái</th>
            <th class="text-center">Thao tác</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $item)
            <tr>
                <td>
                    <p style="margin-bottom: 0;font-weight: 600;font-size: 14px;">{{ $item->user->full_name ?: 'không có dữ liệu' }}</p>
                </td>
                <th>
                    <p style="margin-bottom: 0;font-weight: 600;font-size: 14px;">{{ $item->user->email ?: 'không có dữ liệu' }}</p>
                </th>
                <th>
                    <p style="margin-bottom: 0;font-weight: 600;font-size: 14px;">{{ $item->user->address ?: 'không có dữ liệu' }}</p>
                </th>
                <th>
                    <p style="margin-bottom: 0;font-weight: 600;font-size: 14px;">{{ $item->user->phone ?: 'không có dữ liệu' }}</p>
                </th>
                <th>
                    <p
                        style="margin-bottom: 0; font-weight: 600; font-size: 14px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; width: 200px;">
                        {{ $item->content ?: 'không có dữ liệu' }}
                    </p>
                </th>
                <th>
                    <p style="margin-bottom: 0;font-weight: 600;font-size: 14px;">

                        @if ($item->status == 0)
                            <div class="icon-container">
                                <p style="margin-bottom: 0;font-weight: 600;font-size: 14px;"><i
                                        class="fas fa-hourglass-start text-warning"></i></p>
                            </div>
                        @elseif ($item->status == 1)
                            <div class="icon-container">
                                <p style="margin-bottom: 0;font-weight: 600;font-size: 14px;"><i
                                        class="fas fa-check-circle text-success"></i></p>
                            </div>
                        @endif

                    </p>
                </th>

                <th class="text-center">
                    <div style="display: flex; justify-content: center;column-gap: 5px;">

                        @if ($item->status == 0)
                            <a class="btn btn-sm btn-success" href="{{ route('admin.contact.edit', $item->id) }}"
                                data-toggle="tooltip" data-placement="top" title="Phản hồi">
                                <i class="fa fa-comment-dots"></i>
                            </a>
                        @elseif ($item->status == 1)
                            <a type="button" class="view-user-detail btn btn-info" data-toggle="tooltip"
                                data-placement="top" title="Chi tiết phản hồi" data-toggle="tooltip"
                                data-placement="top" title="Xem chi tiết" data-full-name="{{ $item->user->full_name }}"
                                data-email="{{ $item->user->email }}" data-username="{{ $item->user->username }}"
                                data-phone="{{ $item->user->phone }}" data-address="{{ $item->user->address }}"
                                data-content="{{ $item->content }}"
                                data-image="{{ $item->image != null ? asset($item->image) : null }}"
                                data-response="{{ $item->response }}" data-updated_at="{{ $item->updated_at }}"
                                style="cursor: pointer;">
                                <i class="fa fa-eye"></i>
                            </a>
                            <form action="" method="POST" data-url="contact" class="form-delete">
                                @method('DELETE')
                                @csrf
                                <input type="hidden" value="{{ $item->id }}" name="id">
                                <button class="btn btn-sm btn-danger btn-delete" title="Xoá"><i
                                        class="fa fa-trash-o"></i></button>
                            </form>
                        @endif

                    </div>
                </th>

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
                <h5 id="userDetailModalLabel" style="font-size: 16px; padding: 10px">Phản hồi</h5>
                <hr>
            </div>
            <div style="display: grid; grid-template-columns: 40% 60%; padding: 10px">
                <div style="text-align: center">
                    <div><strong>Ảnh:</strong></div>
                    <div>
                        <img id="image" src="" width="77%" />
                    </div>
                    <span id="imageMessage"></span>
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
                            <div><strong>Phản hồi lúc:</strong></div>
                            <div
                                style="border: 1px solid #ccc; padding: 8px; background-color: #f9f9f9; border-radius: 5px">
                                <span id="updated_at"></span>
                            </div>
                        </div>

                    </div>
                    <div style="margin-top: 10px; display: grid; grid-template-columns: 1fr 1fr; gap: 10px">
                        <div>
                            <div><strong>Nội dung:</strong></div>
                            <div
                                style="border: 1px solid #ccc; padding: 8px; background-color: #f9f9f9; border-radius: 5px">
                                <span id="content"></span>
                            </div>
                        </div>
                        <div>
                            <div><strong>Phản hồi:</strong></div>
                            <div
                                style="border: 1px solid #ccc; padding: 8px; background-color: #f9f9f9; border-radius: 5px">
                                <span id="response"></span>
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
