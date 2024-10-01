<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentMethods;
use Illuminate\Support\Facades\DB;

class PaymentMethodsController extends Controller
{
    public $paymentMethods;
    public function __construct(){
        $this->paymentMethods = new PaymentMethods();
    }
    public function index(Request $request)
    {
        $title = "Quản lý phương thức thanh toán";
        $tablename = "Danh sách phương thức thanh toán";
        
        $search = $request->input('search');
        
        // Query tìm kiếm
        $query = DB::table('payment_methods');
        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }  
        $paymentMethods = $query->get();     
        return  view("backend.payment_methods.templates.list",compact("title","tablename","paymentMethods"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Thêm mới phương thức thanh toán";
        return view('backend.payment_methods.templates.create',compact('title'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if($request->isMethod('POST')){
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
