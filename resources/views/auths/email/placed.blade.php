<!DOCTYPE html>
<html>
<head>
    <title>Thông tin đơn hàng</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f9;
            padding: 20px;
        }
        h1 {
            color: #4CAF50;
            text-align: center;
        }
        .order-details {
            background-color: #fff;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        p {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="order-details">
        <h1>Đơn hàng của bạn đã được đặt thành công!</h1>
        <p>Cảm ơn bạn đã mua sắm tại cửa hàng của chúng tôi!</p>

        <table>
            <tr>
                <th>Thông tin</th>
                <th>Chi tiết</th>
            </tr>
            <tr>
                <td>Tên khách hàng</td>
                <td>{{ $order->customer_name }}</td>
                <td></td> 
            </tr>
            <tr>
                <td>Địa chỉ đặt hàng</td>
                <td>{{ $order->shipping_address }}</td>
                <td></td> 
            </tr>
            <tr>
                <td>Số điện thoại</td>
                <td>{{ $order->phone_number }}</td>
                <td></td> 
            </tr>
            @foreach ($order->orderItems as $item)
                <tr>
                    <td>Tên sản phẩm</td>
                    <td>{{ $item->product_name }}</td>
                </tr>
                <tr>
                    <td>Số lượng</td>
                    <td>{{ $item->quantity }}</td>
                </tr>
                <tr>
                    <td>Giá tiền</td>
                    <td>{{ number_format($item->price, 0, ',', '.') }} VND</td>
                </tr>
            @endforeach
            <tr>
                <td>Mã giảm giá</td>
                <td>{{ $order->discount_code }}</td>
            </tr>
            <tr>
                <td>Số tiền giảm giá</td>
                <td>{{ number_format($order->discount_amount, 0, ',', '.') }} VND</td>
            </tr>
            <tr>
                <td>Phí vận chuyển</td>
                <td>{{ number_format($order->shipping_fee, 0, ',', '.') }} VND</td>
            </tr>
            <tr>
                <td>Số tiền cuối cùng</td>
                <td>{{ number_format($order->final_amount, 0, ',', '.') }} VND</td>
            </tr>
            <tr>
                <td>Ghi chú</td>
                <td>{{ $order->note }}</td>
            </tr>
        </table>
    </div>
</body>
</html>
