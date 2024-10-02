<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentMethods;
use Illuminate\Support\Facades\DB;

class PaymentMethodsController extends Controller
{
    public $paymentMethods;
    public function __construct()
    {
        $this->paymentMethods = new PaymentMethods();
    }
    public function index(Request $request)
{
    $title = "Quản lý phương thức thanh toán";
    $tablename = "Danh sách phương thức thanh toán";
    $keywords = $request->input('keywords');
    $query = PaymentMethods::query();
    if ($keywords) {
        $query->where('name', 'like', "%{$keywords}%");
    }
    $paymentMethods = $query->get();
    return view("backend.payment_methods.templates.list", compact("title", "tablename", "paymentMethods"));
}
    public function create()
    {
        $title = "Thêm mới phương thức thanh toán";
        return view('backend.payment_methods.templates.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        if ($request->isMethod('POST')) {
            $params = $request->except('_token');
            $this->paymentMethods->createPttt($params);
            return redirect()->route('admin.payment_methods');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title = "Sửa phương thức thanh toán";
        $paymentMethods = $this->paymentMethods->getDetailPaymentMethods($id);
        return view('backend.payment_methods.templates.edit', compact('title', 'paymentMethods'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if ($request->isMethod('PUT')) {
            $params = $request->except('_token', '_method');
            $this->paymentMethods->updatePaymentMethods($id, $params);
            return redirect()->route('admin.payment_methods');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Tìm phương thức thanh toán theo ID
        $paymentMethod = PaymentMethods::findOrFail($id);
    
        // Xóa phương thức thanh toán
        $paymentMethod->delete();
    
        // Thêm thông báo thành công vào session để SweetAlert2 hiển thị
        return redirect()->route('admin.payment_methods')
                         ->with('success', 'Phương thức thanh toán đã được xóa.');
    }
    

    

}
