<!DOCTYPE html>
<html>
<head>
    <title>Đơn hàng không hoàn thành</title>
</head>
<body>
    <h2>Xin chào {{ $order->customer_name }},</h2>
    @foreach ($order->orderItems as $item)
    <div class="order-item">
        <p>Morden Home đã nhận được thông báo rằng đơn hàng {{ $item->product_name }} đã bị hủy </p>
        <p>Lý do: {{ $mesage ?? 'Đơn hàng bị hủy' }}</p>
        <p>Cảm ơn bạn đã mua sắm với Morden Home!</p>
    </div>
    @endforeach
</body>
</html>