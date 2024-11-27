@php

if (!function_exists('getStatusOption')) {
    function getStatusOption($order)
    {
        $statusOptions = [];
        if ($order->status === 1) {
            $statusOptions = [
                2 => 'Xác nhận đơn hàng',
                7 => 'Hủy đơn hàng',
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
        case 6: return 'green'; // Hoàn tất
        case 7: return '#DC3545'; // Hủy đơn
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
        case 7: return 'Hủy';
        default: return 'Không xác định';
    }
}
}
if (!function_exists('getOrderPaymentStatusLabel')) {
    function getOrderPaymentStatusLabel($status) {
    switch ($status) {
        case 1: return 'Chờ thanh toán';
        case 2: return 'Đã thanh toán';
        case 3: return 'Hoàn tiền';
        default: return 'Không xác định';
    }
}
}

@endphp
<table class="table table-striped table-bordered ">
    <thead>
        <tr>

            <th class="text-center">Mã đơn hàng</th>
            <th style="width: 200px" class="text-center">Khách hàng</th>

            <th class="text-end" style="width: 100px">Thành tiền</th>
            <th class="text-start">Chi phí khác</th>
            <th class="text-right" style="width: 100px">Tổng tiền</th>
            <th class="text-center">Thanh toán</th>
            <th class="text-center">Địa chỉ giao hàng</th>
            <th class="text-center">Tình trạng</th>
            <th class="text-start">Hành động</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($orders as $index => $order)
        @php
        $statusOptions = getStatusOption($order);
        @endphp
            <tr id="order-row-{{$order->id}}">
                <td class="text-center"><a href="{{route("admin.orders.details",$order->id)}}">BND-{{$order->id}}</a></td>
                <td class="text-start">
                    <b>{{$order->customer_name}}</b>
                    <br>
                    <b>SDT: {{$order->phone_number}}</b>
                    <br>
                    <b>Ngày lên đơn: </b> {{date_format($order->created_at,"d-m-Y")}}
                </td>
                <td class="text-end">
                    {{number_format($order->total_amount)}} đ
                </td>
                <td class="text-start">
                    <b>Phí ship: </b> : {{$order->shipping_fee ? number_format($order->shipping_fee,0,",") : 0}} đ
                    <br>
                    <b>Giảm giá:</b> {{$order->discount_amount ? number_format($order->discount_amount,0,",") : 0}} đ
                </td>
                <td class="text-right">
                    {{$order->final_amount ? number_format($order->final_amount,0,",") : 0}} đ
                </td>
                <td class="text-start">
                    <b>PTT: </b> {{$order->paymentMethod->name}}
                    <br>
                    <b>Trạng thái tanh toán :</b> <span class="payment_status"> {{getOrderPaymentStatusLabel($order->payment_status)}}</span>
                </td>
                <td class="text-center">
                    <b>Địa chỉ : </b> {{$order->shipping_address}}
                </td>
                </td>
                <td id="order-status-{{ $order->id }}" class="text-center"
                    style="color: {{ getStatusColor($order->status) }}">
                    {{ getOrderStatusLabel($order->status) }}
                </td>
                <td class="">
                    <div class="d-flex" style="display: flex; column-gap: 12px;justify-content: start">
                        <div class="btn-group btn-group-{{$order->id }}">
                            @if ($order->status != 6)
                                <button data-toggle="dropdown" class="btn btn-primary btn-sm dropdown-toggle" aria-expanded="true">
                                    Hành động <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" id="action-dropdown-{{ $order->id }}">
                                    @foreach ($statusOptions as $status => $label)
                                        <li><a href="#"
                                            onclick="updateOrderStatus({{ $status }}, {{ $order->id }})">{{ $label }}</a>
                                        </li>
                                    @endforeach
                                    @if ($order->status == 7)
                                        <li><a href="#" onclick="deleteOrder({{ $order->id }})">Xóa đơn hàng</a></li>
                                    @endif
                                </ul>
                            @else
                                <div id="order-status-{{ $order->id }}" class="text-center"
                                    style="color: {{ getStatusColor($order->status) }}">
                                    Đã hoàn thành
                                </div>
                            @endif
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

            
                    
                    statusCell.innerText = getOrderStatusLabel(status);
                    statusCell.style.color = getStatusColor(status);
                    
                    const payment_status = document.querySelector('.payment_status');
                    payment_status.innerText = getOrderPaymentStatusLabel(response.newPaymebnt_status);
                    if(response.newStatus)
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
    }
    else if (currentStatus === 5) {
        options = []
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
        case 6: return 'green'; // Hoàn tất
        case 7: return 'red';
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
        case 6: return 'Hoàn tất';
        case 7: return 'red';       // Trạng thái 6: Đơn hàng đã hoàn tất
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
function getOrderPaymentStatusLabel(value){
    console.log(value);
    
    switch (value) {
        case 1: return 'Chờ thanh toán';
        case 2: return 'Đã thanh toán';
        case 3: return 'Hoàn tiền';
        default: return 'Không xác định';
    }
}
$(document).ready(function() {
    // Cài đặt locale tiếng Việt cho Moment
    moment.locale('vi');

    $(function() {
        var start = moment().startOf('month'); // Ngày bắt đầu: đầu tháng
        var end = moment(); // Ngày kết thúc: hôm nay
        const typeFormat = 'D [Tháng] M, YYYY'; // Định dạng ngày

        // Hàm callback để cập nhật nội dung input với giá trị ngày được chọn
        function cb(start, end) {
            let content = 'Tháng này: ' + start.format(typeFormat) + ' - ' + end.format(typeFormat);
            let cont = start.format(typeFormat) + ' - ' + end.format(typeFormat);

            // Nếu ngày bắt đầu và kết thúc trùng nhau, chỉ hiển thị một ngày
            if (start.format(typeFormat) === end.format(typeFormat)) {
                cont = start.format(typeFormat);
            }

            // Gán giá trị mặc định vào input
            $('input[name="dates"]').val(content);

            // Lắng nghe sự kiện "Áp dụng" của daterangepicker
            $('input[name="dates"]').on('apply.daterangepicker', function(ev, picker) {
                if (!cont.includes(picker.chosenLabel)) {
                    cont = picker.chosenLabel + ': ' + cont;
                }
                $(this).val(cont);
            });
        }
        $('input[name="dates"]').daterangepicker({
            startDate: start,
            endDate: end,
            maxDate: moment(),
            locale: {
                format: typeFormat,
                applyLabel: "Áp dụng",
                cancelLabel: "Hủy",
                fromLabel: "Từ",
                toLabel: "Đến",
                customRangeLabel: "Tùy chỉnh",
                daysOfWeek: ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
                monthNames: [
                    "Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5",
                    "Tháng 6", "Tháng 7", "Tháng 8", "Tháng 9", "Tháng 10",
                    "Tháng 11", "Tháng 12"
                ],
                firstDay: 1
            },
            ranges: {
                'Hôm nay': [moment(), moment()],
                'Hôm qua': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                '7 ngày qua': [moment().subtract(7, 'days'), moment()],
                '30 ngày qua': [moment().subtract(29, 'days'), moment()],
                'Tháng này': [moment().startOf('month'), moment()],
                'Tháng trước': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                'Tất cả thời gian': [moment().subtract(10, 'year').startOf('day'), moment().endOf('day')]
            }
        }, cb);
        cb(start, end);

    });
});

</script>
