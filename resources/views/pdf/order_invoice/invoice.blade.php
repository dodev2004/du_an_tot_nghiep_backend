<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hóa Đơn Đơn Hàng</title>
    <style>
        @font-face {
            font-family: 'DejaVu';
            src: url('{{ public_path('fonts/DejaVuMathTeXGyre.ttf') }}') format('truetype');
        }

        @page {
            size: A4;
            margin: 20mm;
        }

        body {
            font-family: 'DejaVu', sans-serif !important;
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
    </style>
</head>

<body>
    <div class="container">
        <h1>Hóa Đơn Đơn Hàng</h1>

        <h3>Thông Tin Khách Hàng</h3>
        <p><strong>Họ Tên:</strong> Nguyễn Văn A</p>
        <p><strong>Địa Chỉ:</strong> Hà Nội, Việt Nam</p>
        <p><strong>Email:</strong> budev@gmail.com</p>
        <p><strong>Số Điện Thoại:</strong> 0123456789</p>

        <h3>Chi Tiết Đơn Hàng</h3>
        <table>
            <thead>
                <tr>
                    <th class="text-center">STT</th>
                    <th class="text-left">Hình Ảnh</th>
                    <th class="text-left">Thông Tin Sản Phẩm</th>
                    <th class="text-right">Giá</th>
                    <th class="text-right">Số Lượng</th>
                    <th class="text-right">Thành Tiền</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center">1</td>
                    <td class="text-left">
                        <img src="link_to_image" width="100" height="100" alt="Hình ảnh sản phẩm">
                    </td>
                    <td class="text-left">
                        <strong>Tên Sản Phẩm:</strong> Sản phẩm Cao Cấp<br>
                        <strong>Lựa Chọn:</strong> Gối sưởi x Màu đen
                    </td>
                    <td class="text-right">12,000 đ</td>
                    <td class="text-right">2</td>
                    <td class="text-right">24,000 đ</td>
                </tr>
            </tbody>
        </table>

        <div class="summary">
            <p class="text-right"><strong>Tạm Tính: 24,000 đ</strong></p>
            <p class="text-right"><strong>Khuyến Mãi: 2,000 đ</strong></p>
            <p class="text-right"><strong>Phí Giao Hàng: 100 đ</strong></p>
            <p class="text-right" style="font-weight: bold; font-size: 16px; color: #333;">Tổng Tiền: 21,900 đ</p>
        </div>

        <div class="footer">
            <p>Cảm ơn bạn đã mua sắm tại cửa hàng của chúng tôi!</p>
            <p>Địa chỉ cửa hàng: [Địa chỉ cửa hàng]</p>
            <p>Điện thoại: [Số điện thoại]</p>
        </div>
    </div>
</body>

</html>
