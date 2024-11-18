<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order; // Import model Order hoặc model tương ứng

class PaymentController extends Controller
{
    public function vnpay_payment(Request $request)
    {
        error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = route("vnpay.return");
        $vnp_TmnCode = env('VNP_TMN_CODE'); // Mã website tại VNPAY
        $vnp_HashSecret = env('VNP_HASH_SECRET'); // Chuỗi bí mật
        
        $vnp_TxnRef = $request->order_id; // Mã đơn hàng
        $vnp_OrderInfo = $request->order_desc; // Thông tin đơn hàng
        $vnp_OrderType = $request->order_type; // Loại đơn hàng
        $vnp_Amount = $request->total_price * 100; // Số tiền thanh toán (nhân với 100 để chuyển sang đơn vị VNĐ)
        $vnp_Locale = "vn"; // Ngôn ngữ
        $vnp_BankCode = $request->bank_code ?? "NCB"; // Mã ngân hàng
        $vnp_IpAddr = $request->ip(); // Địa chỉ IP của khách hàng
        $vnp_ExpireDate = date('YmdHis', strtotime('+15 minutes')); // Thời gian hết hạn

        $inputData = array(
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
            "vnp_ExpireDate" => $vnp_ExpireDate
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret); // Hash dữ liệu
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        return response()->json([
            'success' => true,
            'payment_url' => $vnp_Url
        ]);
    }

    public function vnpay_return(Request $request)
    {
        $vnp_HashSecret = env('VNP_HASH_SECRET'); // Chuỗi bí mật

        $inputData = array();
        $data = $request->all();
        foreach ($data as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }

        $vnp_SecureHash = $inputData['vnp_SecureHash'];
        unset($inputData['vnp_SecureHash']);

        ksort($inputData);
        $hashData = "";
        foreach ($inputData as $key => $value) {
            $hashData .= urlencode($key) . "=" . urlencode($value) . '&';
        }
        $hashData = trim($hashData, '&');

        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

        if ($secureHash === $vnp_SecureHash) {
            if ($inputData['vnp_ResponseCode'] == '00') {
                return response()->json([
                    'success' => true,
                    'message' => 'Thanh toán thành công!',
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Thanh toán không thành công!'
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Chữ ký không hợp lệ!'
            ]);
        }
    }
}