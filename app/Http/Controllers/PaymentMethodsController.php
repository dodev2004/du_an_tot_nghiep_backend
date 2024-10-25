<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentMethods;

class PaymentMethodsController extends Controller
{
    public $paymentMethods;
    protected $breadcrumbs = [];
    public function __construct()
    {
        $this->paymentMethods = new PaymentMethods();
    }
    public function index(Request $request)
    {
        $title = "Quản lý phương thức thanh toán";
        $data = PaymentMethods::all();
        $this->breadcrumbs[] = [
            "active" => true,
            "url" => route("admin.payment_methods"),
            "name" => "Quản lý phương thức thanh toán"
        ];
        $breadcrumbs = $this->breadcrumbs;
        $keywords = $request->input('keywords');
        $query = PaymentMethods::query();
        if ($keywords) {
            $query->where('name', 'like', "%{$keywords}%");
        }
        $paymentMethods = $query->get();
        return view("backend.payment_methods.templates.list", compact("title", "breadcrumbs", "paymentMethods"));
    }
    public function create()
    {
        $title = "Quản lý phương thức thanh toán";
        array_push($this->breadcrumbs, [
            "active" => false,
            "url" => route("admin.payment_methods"),
            "name" => "Quản lý phương thức thanh toán",
        ], [
            "active" => true,
            "url" => route("admin.payment_methods.create"),
            "name" => "Thêm phương thức thanh toán",
        ]);
        $breadcrumbs = $this->breadcrumbs;
        return view('backend.payment_methods.templates.create', compact('title', 'breadcrumbs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validatedData = $request->validate([
        'name' => 'required|string|max:255|unique:payment_methods,name,NULL,id,deleted_at,NULL',
    ], [
        'name.required' => 'Tên phương thức thanh toán không được để trống.',
        'name.unique' => 'Tên phương thức thanh toán đã tồn tại.',
        'name.max' => 'Tên phương thức thanh toán không được dài quá 255 ký tự.',
    ]);

    $params = $request->except('_token');
    $this->paymentMethods->createPttt($params);

    return redirect()->route('admin.payment_methods')->with('success', 'Phương thức thanh toán đã được thêm mới thành công.');
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
        $title = "Quản lý phương thức thanh toán";
        array_push($this->breadcrumbs, [
            "active" => false,
            "url" => route("admin.payment_methods"),
            "name" => "Quản lý phương thức thanh toán",
        ], [

            "active" => true,
            "url" => route("admin.payment_methods.create"),
            "name" => "Sửa phương thức thanh toán",

        ]);
        $breadcrumbs = $this->breadcrumbs;
        $paymentMethods = $this->paymentMethods->getDetailPaymentMethods($id);
        return view('backend.payment_methods.templates.edit', compact('title', 'paymentMethods', 'breadcrumbs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    if ($request->isMethod('PUT')) {
        try {
            $params = $request->except('_token', '_method');

            // Thêm validation nếu cần
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
            ]);

            $this->paymentMethods->updatePaymentMethods($id, $params);

            return response()->json([
                'success' => true,
                'message' => 'Cập nhật thành công',
                'redirect' => route('admin.payment_methods')
            ]); 
        } catch (\Exception $e) {
            // Xử lý lỗi, ví dụ: log lỗi, trả về response lỗi
            return response()->json([
                'success' => false,
                'message' => 'Đã xảy ra lỗi khi cập nhật.',
                'errors' => [
                    'name' => ['Lỗi validate tên (nếu có)'],
                    'description' => ['Lỗi validate mô tả (nếu có)'],
                    // ... các lỗi khác ...
                ]
            ], 500); // Trả về status code 500
        }
    }
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $paymentMethod = PaymentMethods::findOrFail($id);
        $paymentMethod->delete();
        return redirect()->route('admin.payment_methods')
            ->with('success', 'Phương thức thanh toán đã được xóa.');
    }
}
