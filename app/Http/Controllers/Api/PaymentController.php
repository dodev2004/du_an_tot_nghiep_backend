<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order; // Import model Order hoặc model tương ứng
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function vnpay_payment(Request $request)
    {

        
        $order_item = $request->orderItems;
        foreach ($order_item as $item) {
            $stock = null;
            $productName = null;
    
            if ($item['product_variants_id']) {
                $variant = ProductVariant::find($item['product_variants_id']);
                $stock = $variant->stock;
                $productName = $variant->product->name;
            } else {
                $product = Product::find($item['product_id']);
                $stock = $product->stock;
                $productName = $product->name;
            }
            if ($item['quantity'] > $stock) {
                return response()->json([
                    'error' => "Sản phẩm '{$productName}' không đủ số lượng trong kho.",
                ], 400);
            }
        }
        error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = route("vnpay.return");
        $vnp_TmnCode = env('VNP_TMN_CODE'); // Mã website tại VNPAY
        $vnp_HashSecret = env('VNP_HASH_SECRET'); // Chuỗi bí mật
        
        $vnp_TxnRef = "BND-" . time(); // Tăng ID lên 1 để sử dụng làm mã đơn hàng
        $vnp_OrderInfo ="Thanh toán đơn hàng :  BND-$vnp_TxnRef"; // Thông tin đơn hàng
        $vnp_OrderType = "Đồ gỗ"; // Loại đơn hàng
        $vnp_Amount = $request->total_price * 100; // Số tiền thanh toán (nhân với 100 để chuyển sang đơn vị VNĐ)
        $vnp_Locale = "vn"; // Ngôn ngữ
        $vnp_BankCode ="NCB"; // Mã ngân hàng
        $vnp_IpAddr = $request->ip(); // Địa chỉ IP của khách hàng
        $vnp_ExpireDate = date('YmdHis', strtotime('+15 minutes')); // Thời gian hết hạn

        // Tạo dữ liệu để gửi qua POST
        $postData = [
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
            "vnp_ExpireDate" => $vnp_ExpireDate,
            "order_item" => json_encode($order_item)
        ];

        // Tạo hash dữ liệu
        ksort($postData);
        $hashdata = http_build_query($postData, '', '&', PHP_QUERY_RFC3986);
      
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $postData['vnp_SecureHash'] = $vnpSecureHash;
        }

        // Trả về URL thanh toán cho frontend
        $paymentUrl = $vnp_Url . '?' . http_build_query($postData);

        return response()->json([
            'success' => true,
            'payment_url' => $paymentUrl
        ]);
    }

    public function vnpay_return(Request $request)
    {
        $vnp_HashSecret = env('VNP_HASH_SECRET');
        $inputData = [];
        $data = $request->all();

        foreach ($data as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = ($key == 'vnp_Amount') ? (int) $value : $value;
            }
        }
        if (isset($data['order_item'])) {
            $inputData['order_item'] = $data['order_item'];
        }
    

        $vnp_SecureHash = $inputData['vnp_SecureHash'] ?? null;
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $hashdata = http_build_query($inputData, '', '&', PHP_QUERY_RFC3986);
     
        if (isset($vnp_HashSecret)) {
            $secureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
        }
       
        if ($secureHash === $vnp_SecureHash) {
            $order_item = json_decode($inputData['order_item'], true);
        foreach ($order_item as $item) {
            $stock = null;
            $productName = null;
    
            if ($item['product_variants_id']) {
                $variant = ProductVariant::find($item['product_variants_id']);
                $stock = $variant->stock;
                $productName = $variant->product->name;
            } else {
                $product = Product::find($item['product_id']);
                $stock = $product->stock;
                $productName = $product->name;
            }
            if ($item['quantity'] > $stock) {
                return response()->json([
                    'error' => "Sản phẩm '{$productName}' không đủ số lượng trong kho.",
                ], 400);
            }
        }
            if (isset($inputData['vnp_ResponseCode']) && $inputData['vnp_ResponseCode'] == '00') {
                try {
                    return redirect()->away(env('FRONTEND_URL') . 'order-success?' . http_build_query([
                        'status' => 'success',
                        'orderId' => $inputData["vnp_TxnRef"],
                        'amount' => $inputData['vnp_Amount'] / 100,
                        'message' => 'Thanh toán thành công'
                    ]));
                } catch (\Exception $e) {
                    DB::rollBack();
                    return redirect()->away(env('FRONTEND_URL') . 'order-success?' . http_build_query([
                        'status' => 'error',
                        'message' => 'Lỗi xử lý thanh toán'
                    ]));
                }
            }
        }

        return redirect()->away(env('FRONTEND_URL') . 'order-success?' . http_build_query([
            'status' => 'failure',
            'message' => 'Thanh toán thất bại hoặc bị hủy'
        ]));
    }
}