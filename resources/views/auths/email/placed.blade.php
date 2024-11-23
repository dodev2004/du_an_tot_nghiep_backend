<!DOCTYPE html>
<html>
<head>
    <title>Thông tin đơn hàng</title>
</head>
<body>
    <h1>Đơn hàng của bạn đã được đặt thành công!</h1>
    <p>Tên khách hàng: {{ $order->customer_name }}</p>
    <p>Số điện thoại: {{ $order->phone_number }}</p>
    <p>Mã giảm giá: {{ $order->discount_code }}</p>
    <p>Tổng tiền: {{ $order->total_amount }}</p>
    <p>Số tiền giảm giá: {{ $order->discount_amount }}</p>
    <p>Địa chỉ đặt hàng: {{ $order->shipping_address }}</p>
    <p>Phí vận chuyển: {{ $order->shipping_fee }}</p>
    <p>Số tiền cuối cùng: {{ $order->final_amount }}</p>
    <p>Ghi chú: {{ $order->note }}</p>
    <p>Cảm ơn bạn đã mua sắm tại cửa hàng của chúng tôi!</p>
</body>
</html>
