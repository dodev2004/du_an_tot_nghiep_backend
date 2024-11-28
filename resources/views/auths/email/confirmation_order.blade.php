<!DOCTYPE html>
<html>
<head>
    <title>Xác nhận đã nhận hàng</title>
</head>
<body>
    <h2>Xin chào {{ $order->customer_name }},</h2>
    @foreach ($order->orderItems as $item)
    <div class="order-item">
        <p>Morden Home đã nhận được thông báo rằng bạn đã nhận hàng cho đơn hàng <b>{{ $item->product_name }}</b> .</p>
        <p>Bạn vui lòng ấn xác nhận đã nhận hàng</p>
        <p>Cảm ơn bạn đã mua sắm với Morden Home!</p>
    </div>
    @endforeach
</body>
</html>