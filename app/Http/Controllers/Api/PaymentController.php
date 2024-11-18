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
    $vnp_TmnCode = "PK8BCC9J";
    $vnp_HashSecret = env('VNP_HASH_SECRET');
    
    $vnp_TxnRef = $request->order_id;
    $vnp_OrderInfo = $request->order_desc;
    $vnp_OrderType = $request->order_type;
    $vnp_Amount = $request->total_price * 100; // Nhân với 100 để chuyển sang đơn vị VND
    $vnp_Locale = "VN";
    $vnp_BankCode = $request->bank_code ?? "NCB";
    $vnp_IpAddr = $request->ip();
    $vnp_ExpireDate = date('YmdHis', strtotime('+15 minutes')); // 15 phút hết hạn

    if ($vnp_Amount < 500000 || $vnp_Amount > 100000000000) {
        return response()->json([
            'success' => false,
            'message' => 'Invalid transaction amount. Amount range is from 5.000 to 1.000.000.000 VND'
        ], 400);
    }

    $inputData = [
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
    ];

    if (!empty($vnp_BankCode)) {
        $inputData['vnp_BankCode'] = $vnp_BankCode;
    }

    ksort($inputData);
    $hashdata = urldecode(http_build_query($inputData)); // Không mã hóa khi tính chữ ký
    $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
    $query = http_build_query($inputData) . '&vnp_SecureHash=' . $vnpSecureHash;

    $vnp_Url .= "?" . $query;

    return response()->json([
        'success' => true,
        'payment_url' => $vnp_Url
    ]);
}

public function vnpay_return(Request $request)
{
    $vnp_HashSecret = env('VNP_HASH_SECRET');
    $inputData = [];
    $data = $request->all();
    dd($data);
    // Extract vnp_ parameters
    foreach ($data as $key => $value) {
        if (substr($key, 0, 4) == "vnp_") {
            $inputData[$key] = $value;
        }
    }

    // Check if 'vnp_SecureHash' exists and remove it for verification
    $vnp_SecureHash = $inputData['vnp_SecureHash'] ?? null;
    unset($inputData['vnp_SecureHash']);

    // Sort parameters and build hash data
    ksort($inputData);
    $hashData = urldecode(http_build_query($inputData));

    // Generate secure hash using VNP_HASH_SECRET
    $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

    // Verify the signature
    if ($secureHash === $vnp_SecureHash) {
        // Check if 'vnp_ResponseCode' exists before using it
        if (isset($inputData['vnp_ResponseCode']) && $inputData['vnp_ResponseCode'] == '00') {
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