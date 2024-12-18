<!DOCTYPE html>
<html lang="vi">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Hóa Đơn Đơn Hàng</title>
    <style>
     @page{
         size: A4;
   
     }

        body {
            font-family: "DejaVu Sans", sans-serif;
            margin: 0;
            padding: 0;
            color: #555;
            background-color: #f9f9f9;
        }

        .container {
            max-width: 100%;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h1,
        h2 {
            color: #333;
            text-align: center;
            margin-bottom: 10px;
        }

        h3 {
            color: #777;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            color: #333;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .summary {
            margin-top: 20px;
            padding: 10px;
            border-top: 2px solid #333;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #777;
        }

        .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo img {
            width: 150px;
            /* Chiều rộng logo */
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Hóa Đơn Đơn Hàng</h1>

        <h3>Thông Tin Khách Hàng</h3>
        <p><strong>Họ Tên:</strong> {{$orders->customer_name}}</p>
        <p><strong>Địa Chỉ:</strong> {{$orders->shipping_address}}</p>
        <p><strong>Email:</strong> {{$orders->customer->email}}</p>
        <p><strong>Số Điện Thoại:</strong> {{$orders->phone_number}}</p>

        <h3>Chi Tiết Đơn Hàng</h3>
        <table>
            <thead>
                <tr>
                    <th class="text-center">STT</th>
                    <th class="text-left">Thông Tin Sản Phẩm</th>
                    <th class="text-right">Giá</th>
                    <th class="text-right">Số Lượng</th>
                    <th class="text-right">Thành Tiền</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders->orderItems  as $index => $item)
                <tr>
                    <td class="text-center">{{$index + 1}}</td>
                    <td class="text-left">
                        <strong>Tên Sản Phẩm:</strong>  {{$item->product->name}} <br>
                        @if($item->variant)
                        <strong>Loại:</strong> {{implode("x",json_decode($item->variant, true))}}
                        @endif
                    </td>
                    <td class="text-right">{{number_format($item->price,0)}} đ</td>
                    <td class="text-right">{{$item->quantity}}</td>
                    <td class="text-right">{{number_format($item->total,0)}} đ</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="summary">
            <p class="text-right"><strong>{{number_format($orders->total_amount)}} đ</strong></p>
            <p class="text-right"><strong>{{ $orders->discount_amount ? number_format($orders->discount_amount) : 0}} đ</strong></p>
            <p class="text-right"><strong>{{ $orders->shipping_fee ? number_format($orders->shipping_fee) : 0}} đ</strong></p>
            <p class="text-right" style="font-weight: bold; font-size: 16px; color: #333;">Tổng Tiền:{{ $orders->final_amount ? number_format($orders->final_amount) : 0}} đ</p>
        </div>

        <div class="footer">
            <p>Cảm ơn bạn đã mua sắm tại cửa hàng của chúng tôi!</p>
            <p>Địa chỉ cửa hàng: Phụng Châu, Chương Mỹ, Hà Nội</p>
            <p>Điện thoại: 0987654321</p>
        </div>
    </div>
</body>

</html>
