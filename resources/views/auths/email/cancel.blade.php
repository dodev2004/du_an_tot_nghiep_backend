<!DOCTYPE html>
<html>
<head>
    <title>Đơn hàng đã hủy</title>
</head>
<body>
    <h2>Xin chào {{ $order->customer_name }},</h2>
    @foreach ($order->orderItems as $item)
    <div class="order-item">
        <p>Morden Home đã nhận được thông báo rằng đơn hàng <b>{{ $item->product_name }}</b> đã bị hủy.</p>
        <p>Chúng tôi xin gửi lại số tiền {{ number_format($order->final_amount, 0, ',', '.') }} VND</p>
        <p>Cảm ơn bạn đã mua sắm với Morden Home!</p>
    </div>
    @endforeach
</body>
</html>