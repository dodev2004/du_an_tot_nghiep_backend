<!DOCTYPE html>
<html>
<head>
    <title>Đơn hàng không hoàn thành</title>
</head>
<body>
    <h2>Xin chào {{ $order->customer_name }},</h2>
    @foreach ($order->orderItems as $item)
    <div class="order-item">
        <p>Morden Home đã nhận được thông báo rằng đơn hàng {{ $item->product_name }} đã giao không thành công </p>
        <p>Lý do: Đơn hàng không thành công </p>
        <p>Cảm ơn bạn đã mua sắm với Morden Home!</p>
    </div>
    @endforeach
</body>
</html>