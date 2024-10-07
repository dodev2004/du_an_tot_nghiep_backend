<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentMethods;
use Illuminate\Support\Facades\DB;

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
        $paymentMethod = PaymentMethods::findOrFail($id);
        $paymentMethod->delete();
        return redirect()->route('admin.payment_methods')
            ->with('success', 'Phương thức thanh toán đã được xóa.');
    }
}
