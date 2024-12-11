<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Order;

use App\Models\Product;
use App\Mail\CancelOrder;
use App\Mail\CancelOrderAdmin;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderReceivedConfirmation;

class OrderController extends Controller
{
    public $paymentMethods;
    protected $breadcrumbs = [];

    public function index(Request $request)
    {
        $title = "Quản lý đơn hàng";
        $orders = Order::with(['user', 'orderItems', 'promotion', 'paymentMethod']);

        if ($request->has("dates") && $request->dates) {
            // Giải mã chuỗi từ request
            $dates = urldecode($request->input('dates'));

            // Loại bỏ phần text "Tháng này: " để lấy khoảng ngày thực tế
            if (strpos($dates, ': ') !== false) {
                $dateRange = explode(': ', $dates)[1];
            } else {
                $dateRange = $dates;
            }

            // Tách khoảng ngày bắt đầu và kết thúc
            $dateParts = explode(' - ', $dateRange);

            // Kiểm tra nếu chỉ có ngày bắt đầu
            if (count($dateParts) === 1) {
                $start = trim($dateParts[0]);
                // Chuyển đổi định dạng ngày từ "d [Tháng] m, Y" sang đối tượng Carbon
                $startDate = Carbon::createFromFormat('d \T\h\á\n\g m, Y', $start);

                // Chuyển đổi sang định dạng Y-m-d
                $startDateFormatted = $startDate->format('Y-m-d');

                // Lọc đơn hàng theo ngày bắt đầu, không giới hạn ngày kết thúc
                $orders->where('created_at', '>=', $startDateFormatted);
            } else {
                // Nếu có cả ngày bắt đầu và kết thúc
                [$start, $end] = $dateParts;

                // Loại bỏ khoảng trắng dư thừa
                $start = trim($start);
                $end = trim($end);

                // Chuyển đổi định dạng ngày từ "d [Tháng] m, Y" sang đối tượng Carbon
                $startDate = Carbon::createFromFormat('d \T\h\á\n\g m, Y', $start);
                $endDate = Carbon::createFromFormat('d \T\h\á\n\g m, Y', $end);

                // Chuyển đổi sang định dạng Y-m-d
                $startDateFormatted = $startDate->format('Y-m-d');
                $endDateFormatted = $endDate->format('Y-m-d');

                // Lọc đơn hàng theo khoảng thời gian
                $orders->whereBetween("created_at", [$startDateFormatted, $endDateFormatted]);
            }
        }
        if($request->has("trang_thai") && $request->trang_thai){
          
            $orders->where("status", $request->trang_thai);
        }
        if($request->has("ma_don_hang") && $request->ma_don_hang){
            $orders->where("id", $request->ma_don_hang);
        }
        // Thêm breadcrumbs
        $this->breadcrumbs[] = [
            "active" => true,
            "url" => route("admin.orders"),
            "name" => "Quản lý đơn hàng"
        ];
        $breadcrumbs = $this->breadcrumbs;

        // Lấy từ khóa tìm kiếm


        // Nếu có từ khóa tìm kiếm, thêm điều kiện
        if ($request->has("ma_don_hang") && $request->ma_don_hang) {

            $ma_don_hang = str_replace("BND-","",strtoupper($request->ma_don_hang));

            $orders->where('id', '=', trim($ma_don_hang)); // Thay 'some_column' bằng tên cột bạn muốn tìm kiếm
        }

        // Phân trang kết quả và giữ lại tham số truy vấn
        $orders = $orders->orderBy('created_at', 'desc')->paginate(5)->withQueryString();
        return view("backend.orders.templates.index", compact("title", "breadcrumbs", 'orders'));
    }
    function convertVietnameseDateToStandard($date)
    {
        // Các tên tháng tiếng Việt để thay thế bằng số
        $vietnameseMonths = [
            'Tháng 1' => '01',
            'Tháng 2' => '02',
            'Tháng 3' => '03',
            'Tháng 4' => '04',
            'Tháng 5' => '05',
            'Tháng 6' => '06',
            'Tháng 7' => '07',
            'Tháng 8' => '08',
            'Tháng 9' => '09',
            'Tháng 10' => '10',
            'Tháng 11' => '11',
            'Tháng 12' => '12',
        ];

        // Thay thế "Tháng X" bằng số tháng tương ứng và loại bỏ dấu phẩy
        foreach ($vietnameseMonths as $key => $value) {

            $date = str_replace($key, $value, $date);
        }
        dd($date);
        $date = trim(str_replace(',', '', $date));

        // Tách các thành phần ngày, tháng, năm bằng khoảng trắng
        $parts = preg_split('/\s+/', $date); // Tách ngày, tháng, năm

        // Đảm bảo định dạng d-m-Y (ngày-tháng-năm)
        return $parts[0] . '-' . $parts[1] . '-' . $parts[2];
    }
    public function update(Request $request)
    {
        // Tìm đơn hàng theo ID
        $order = Order::find($request->order_id);
        $mesage = "";
        if($request->has("reason")){
            $mesage = $request->reason;
        }
        else {
            $mesage = "Hoàn đơn hàng";
        }
        
        if ($order) {
            if ($request->status == 7 || $request->status == 8) {
                if($order->status == 1 || $order->status == 4 ){
                    if ($order->payment_status === 2) {
                        $order->payment_status = 3;
                        Mail::to($order->email)->send(new CancelOrderAdmin($order, $mesage)); 
    
                    }
                    foreach ($order->orderItems as $item) {
                    
                        if ($item->product_variants_id) {
                            $variant = ProductVariant::find($item->product_variants_id);
                            if ($variant) {
                               
                                $variant->stock += $item->quantity;
                                $variant->save();
                            }
                        } else {
                            $product = Product::find($item->product_id);
                            if ($product) {
                                $product->stock += $item->quantity;
                                $product->save();
                            }
                        }
                    }
                }
                else {
                    return response()->json(['success' => false]);
                }
              
            }
            if($order->status == 7 || $order->status == 8){
                return response()->json(['success' => false]);
            }
            else {
                if ($request->status == 5) {
                    if ($order->payment_status == 1) {
                        $order->payment_status = 2;
                    }
                    Mail::to($order->email)->send(new OrderReceivedConfirmation($order)); 
                }
                $order->status = $request->status;
                $order->save();
                return response()->json(['success' => true, 'newStatus' => $order->status, "newPaymebnt_status" => $order->payment_status]);
            }
            

            
        }

        return response()->json(['success' => false]);
    }

    public function show($id, Request $request)
    {

        $title = "Chi tiết đơn hàng";
        
        $this->breadcrumbs[] = [
            "active" => true,
            "url" => route("admin.orders"),
            "name" => "Quản lý đơn hàng"
        ];
        $breadcrumbs = $this->breadcrumbs;
        $orders = Order::with(['customer', 'orderItems.product', 'promotion', 'paymentMethod'])->find($id);

        return view("backend.orders.templates.detail", compact("title", "breadcrumbs", 'orders'));
    }
    public function exportPdf($orderId)
    {
        // Lấy thông tin đơn hàng
        $orders = Order::with(['customer', 'orderItems.product', 'promotion', 'paymentMethod'])->find($orderId);

        // Tạo view để hiển thị thông tin đơn hàng
        $pdf = Pdf::loadView('pdf.order_invoice.invoice', compact('orders'));
        // $pdf->setOptions([
        //     'isHtml5ParserEnabled' => true,
        //     'isRemoteEnabled' => true,
        // ]);
        // Trả về file PDF cho người dùng tải về
        return $pdf->stream('hoadon_donhang_' . $orders->id . '.pdf');
    }
    public function destroy($id)
    {
        $order = Order::with('orderItems')->find($id);

        if ($order) {
        
            $order->orderItems()->delete();
    
         
            $order->delete();
    
            return response()->json(['success' => true]);
        }
    
        return response()->json(['success' => false, 'message' => 'Order not found']);
    }
}
