<?php

namespace App\Http\Controllers\backend;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $breadcrumbs = [];

    public function index()
    {
        $title = "Quản lý khách hàng";
    $this->breadcrumbs[] = [
        "active" => true,
        "url" => route("admin.customer"),
        "name" => "Quản lý khách hàng"
    ];
    $table="users";
    $breadcrumbs = $this->breadcrumbs;
    $status = request()->input('status');
    $searchText = request()->input('seach_text');
    $startDate = request()->input('start_date');
    $endDate = request()->input('end_date');
    $dateOrder = request()->input('date_order');

    $query = User::with('orders')->withSum('orders', 'final_amount')->where('rule_id', 2);

    // Search by username
    if ($searchText) {
        $query->where('full_name', 'LIKE', '%' . $searchText . '%');
    }

    // Filter by date range
    if ($startDate) {
        $query->where('created_at', '>=', $startDate);
    }
    if ($endDate) {
        $query->where('created_at', '<=', $endDate);
    }
    if ($status !== null && $status !== '') {
        $query->where('status', $status);
    }
    // Sort by date
    if ($dateOrder === 'newest') {
        $query->orderBy('created_at', 'desc');
    } elseif ($dateOrder === 'oldest') {
        $query->orderBy('created_at', 'asc');
    }

    // Paginate the results
    $data = $query->paginate(10);


    return view('backend.customers.templates.index', compact('title', 'breadcrumbs', 'data','table'));

    

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $title = "Chi tiết tổng đơn mua hàng";
        array_push($this->breadcrumbs, [
            "active" => false,
            "url" => route("admin.contact"),
            "name" => "Quản lý khách hàng",
        ], [

            "active" => true,
            "url" => route("admin.contact.show", $id),
            "name" => "Chi tiết tổng đơn mua hàng",

        ]);
        $breadcrumbs = $this->breadcrumbs;
        $user = User::with(['orders.orderItems'])->withSum('orders', 'final_amount')->findOrFail($id);

        return view("backend.customers.templates.show", compact("title", "breadcrumbs", "user"));
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
