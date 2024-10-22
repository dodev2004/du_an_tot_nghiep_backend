@php

if (!function_exists('getStatusOption')) {
    function getStatusOption($order)
    {
        $statusOptions = [];
        if ($order->status === 1) {
            $statusOptions = [
                2 => 'Xác nhận đơn hàng',
                6 => 'Hủy đơn hàng',
            ];
        } elseif ($order->status === 2) {
            $statusOptions = [
                3 => 'Xử lý đơn hàng',
            ];
        } elseif ($order->status === 3) {
            $statusOptions = [
                4 => 'Xác nhận giao hàng',
            ];
        } elseif ($order->status === 4) {
            $statusOptions = [
                5 => 'Đã giao hàng',
            ];
        } elseif ($order->status === 5) {
            $statusOptions = [
                6 => 'Hoàn tất',
            ];
        }
        return $statusOptions;
}

}
if (!function_exists('getStatusColor')) {
    function getStatusColor($status) {
    switch ($status) {
        case 1: return '#FFC107'; // Đang chờ xử lý
        case 2: return '#28A745'; // Đã xác nhận
        case 3: return '#007BFF'; // Đang xử lý
        case 4: return '#17A2B8'; // Xác nhận giao hàng
        case 5: return '#28A745'; // Đã giao hàng
        case 6: return '#DC3545'; // Hủy đơn
        default: return '#000000'; // Mặc định
    }
}
}

if (!function_exists('getOrderStatusLabel')) {
    function getOrderStatusLabel($status) {
    switch ($status) {
        case 1: return 'Chờ xử lý';
        case 2: return 'Đã xác nhận';
        case 3: return 'Đang xử lý';
        case 4: return 'Xác nhận giao hàng';
        case 5: return 'Đã giao hàng';
        case 6: return 'Hoàn tất';
        default: return 'Không xác định';
    }
}
}

@endphp
<table class="table table-striped table-bordered ">
    <thead>
        <tr>
            <th class="text-center">STT</th>
            <td class="text-center">Mã đơn hàng</td>
            <th style="width: 200px" class="text-center">Khách hàng</th>

            <th class="text-center">Thành tiền</th>
            <th class="text-center">Chi phí khác</th>
            <th class="text-center">Tổng tiền</th>
            <th class="text-center">Thanh toán</th>
            <th class="text-center">Địa chỉ giao hàng</th>
            <th class="text-center">Tình trạng</th>
            <th class="text-center">Hành động</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($orders as $order)
        @php
        $statusOptions = getStatusOption($order);
        @endphp
            <tr id="order-row-{{$order->id}}">
                <td class="text-center">1</td>
                <td class="text-center"><a href="">BND-2323123</a></td>
                <td class="text-start">
                    <b>Nguyễn văn A</b>
                    <br>
                    <span>0321321331</span>
                    <br>
                    <b>Ngày lên đơn: </b> 31/10/2004
                </td>
                <td class="text-center">
                    2,200,000 đ
                </td>
                <td class="text-center">
                    <b>Phí ship: </b> : 12đ
                    <br>
                    <b>Giảm giá:</b> 12đ
                </td>
                <td class="text-center">
                    2,200,000 đ
                </td>
                <td class="text-start">
                    <b>PTT: </b> Thanh toán onl
                    <br>
                    <b>Trạng thái tanh toán :</b> Đã thanh toán
                </td>
                <td class="text-center">
                    <b>Địa chỉ : </b> Nam Hài - Nam Phương tiến
                </td>
                </td>
                <td id="order-status-{{ $order->id }}" class="text-center"
                    style="color: {{ getStatusColor($order->status) }}">
                    {{ getOrderStatusLabel($order->status) }}
                </td>
                <td class="text-end">
                    <div class="d-flex" style="display: flex; column-gap: 12px;justify-content: end">
                        <div class="btn-group btn-group-{{$order->id }}">
                            <button data-toggle="dropdown" class="btn btn-primary btn-sm dropdown-toggle" aria-expanded="true">
                                Hành động <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" id="action-dropdown-{{ $order->id }}">
                                @foreach ($statusOptions as $status => $label)
                                    <li><a href="#"
                                            onclick="updateOrderStatus({{ $status }}, {{ $order->id }})">{{ $label }}</a>
                                    </li>
                                @endforeach
                                <li class="divider"></li>
                                <li><a href="#" onclick="deleteOrder({{ $order->id }})">Xóa đơn hàng</a></li>
                            </ul>
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<script>
    function updateOrderStatus(status, orderId) {
        if (!confirm("Bạn có chắc chắn muốn thay đổi trạng thái đơn hàng này không?")) {
            return;
        }


        $.ajax({
            url: '/admin/orders/update-order-status',
          type: 'PUT',
            dataType: 'json',
            data: {
                _token: '{{ csrf_token() }}',
                order_id: orderId,
                status: status
            },
            success: function(response) {
                if (response.success) {

                    const statusCell = document.getElementById('order-status-' + orderId);
                    const actionDropdown = document.getElementById('action-dropdown-' + orderId);

                    console.log(response);
                    
                    statusCell.innerText = getOrderStatusLabel(status);
                    statusCell.style.color = getStatusColor(status);

                    if (status === 6) {
                
                          $(`.btn-group-${orderId}`).remove(); 
                     }
                    updateDropdown(actionDropdown, status, orderId);
                } else {
                    alert('Cập nhật trạng thái thất bại!');
                }
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                alert('Có lỗi xảy ra. Vui lòng thử lại.');
            }
        });
    }

    // Hàm cập nhật dropdown dựa trên trạng thái đơn hàng
    function updateDropdown(actionDropdown, currentStatus, orderId) {
    actionDropdown.innerHTML = ''; // Xóa nội dung hiện tại của dropdown
    let options = [];

    // Tùy chọn dựa trên trạng thái hiện tại
    if (currentStatus === 1) {
        options.push({
            status: 2,
            label: 'Xác nhận đơn hàng'
        });
        options.push({
            status: 6,
            label: 'Hủy đơn hàng'
        });
    } else if (currentStatus === 2) {
        options.push({
            status: 3,
            label: 'Xử lý đơn hàng'
        });
    } else if (currentStatus === 3) {
        options.push({
            status: 4,
            label: 'Xác nhận giao hàng'
        });
    } else if (currentStatus === 4) {
        options.push({
            status: 5,
            label: 'Đã giao hàng'
        });
    } else if (currentStatus === 5) {
        options.push({
            status: 6,
            label: 'Hoàn tất'
        });
    }

    // Thêm các tùy chọn vào dropdown
    options.forEach(function(option) {
        actionDropdown.innerHTML +=
            `<li><a href="#" onclick="updateOrderStatus(${option.status}, ${orderId})">${option.label}</a></li>`;
    });

    // Luôn thêm tùy chọn xóa đơn hàng
    actionDropdown.innerHTML +=
        `<li><a href="#" onclick="deleteOrder(${orderId})">Xóa đơn hàng</a></li>`;
}
    function getStatusColor(status) {
    switch (status) {
        case 1: return '#FFC107'; // Đang chờ xử lý
        case 2: return '#28A745'; // Đã xác nhận
        case 3: return '#007BFF'; // Đang xử lý
        case 4: return '#17A2B8'; // Xác nhận giao hàng
        case 5: return '#28A745'; // Đã giao hàng
        case 6: return '#DC3545'; // Hủy đơn
        default: return '#000000'; // Mặc định
    }
}
function getOrderStatusLabel(status) {
    switch (status) {
        case 1: return 'Chờ xử lý';         // Trạng thái 1: Đơn hàng đang chờ xử lý
        case 2: return 'Đã xác nhận';       // Trạng thái 2: Đơn hàng đã được xác nhận
        case 3: return 'Đang xử lý';        // Trạng thái 3: Đơn hàng đang được xử lý
        case 4: return 'Xác nhận giao hàng'; // Trạng thái 4: Đơn hàng đã được xác nhận giao hàng
        case 5: return 'Đã giao hàng';      // Trạng thái 5: Đơn hàng đã được giao
        case 6: return 'Hoàn tất';          // Trạng thái 6: Đơn hàng đã hoàn tất
        default: return 'Không xác định';   // Trạng thái không xác định
    }
}
function deleteOrder(orderId) {
    if (confirm('Bạn có chắc chắn muốn xóa đơn hàng này không?')) {
        $.ajax({
            url: '/admin/orders/' + orderId, // Đường dẫn đến API xóa đơn hàng
            type: 'DELETE', // Sử dụng phương thức DELETE
            dataType: 'json',
            data: {
                _token: '{{ csrf_token() }}' // Đừng quên thêm CSRF token
            },
            success: function(response) {
                if (response.success) {
                    // Cập nhật giao diện sau khi xóa thành công
                    alert('Đơn hàng đã được xóa thành công!');
                    // Có thể xóa hàng trong bảng hoặc làm mới trang
                    $('#order-row-' + orderId).remove(); // Xóa dòng tương ứng với đơn hàng
                } else {
                    alert('Có lỗi xảy ra trong quá trình xóa đơn hàng!');
                }
            },
            error: function() {
                alert('Có lỗi xảy ra trong quá trình xóa đơn hàng!');
            }
        });
    }
}
</script>
