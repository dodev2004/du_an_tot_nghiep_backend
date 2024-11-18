<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order; // Import model Order hoặc model tương ứng

class PaymentController extends Controller
{
    public function vnpay_payment(Request $request)
{
    
        $vnp_Url = env('VNPAY_URL');
        $vnp_Returnurl = env('VNPAY_RETURNURL');
        $vnp_TmnCode = env('VNPAY_TMN_CODE');
        $vnp_HashSecret = env('VNPAY_HASH_SECRET');

        // Lấy các tham số từ request
        $vnp_TxnRef = $request->input('order_id');
        $vnp_OrderInfo = $request->input('order_desc');
        $vnp_OrderType = $request->input('order_type');
        $vnp_Amount = $request->input('amount') * 100; // Đổi sang VND
        $vnp_Locale = $request->input('language');
        $vnp_BankCode = $request->input('bank_code');
        $vnp_IpAddr = $request->ip();

        // Thông tin người thanh toán
        $vnp_Bill_Mobile = $request->input('txt_billing_mobile');
        $vnp_Bill_Email = $request->input('txt_billing_email');
        $fullName = trim($request->input('txt_billing_fullname'));
        if (!empty($fullName)) {
            $name = explode(' ', $fullName);
            $vnp_Bill_FirstName = array_shift($name);
            $vnp_Bill_LastName = array_pop($name);
        }
        $vnp_Bill_Address = $request->input('txt_inv_addr1');
        $vnp_Bill_City = $request->input('txt_bill_city');
        $vnp_Bill_Country = $request->input('txt_bill_country');
        $vnp_Bill_State = $request->input('txt_bill_state');

        // Tạo mảng dữ liệu để gửi tới VNPay
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
            "vnp_Bill_Mobile" => $vnp_Bill_Mobile,
            "vnp_Bill_Email" => $vnp_Bill_Email,
            "vnp_Bill_FirstName" => $vnp_Bill_FirstName,
            "vnp_Bill_LastName" => $vnp_Bill_LastName,
            "vnp_Bill_Address" => $vnp_Bill_Address,
            "vnp_Bill_City" => $vnp_Bill_City,
            "vnp_Bill_Country" => $vnp_Bill_Country,
        ];

        if (!empty($vnp_BankCode)) {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (!empty($vnp_Bill_State)) {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }

        // Tạo dữ liệu hash để bảo mật thông tin
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

        // Thêm hash vào URL
        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        // Chuyển hướng đến VNPay để thanh toán
        if ($request->has('redirect')) {
            return redirect()->away($vnp_Url);
        } else {
            return response()->json(['code' => '00', 'message' => 'success', 'data' => $vnp_Url]);
        }
    
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