<?php

namespace App\Http\Controllers\backend;
use App\Http\Controllers\Controller;

use App\Repositories\Interfaces\ProvinceRepositoryInterface as ProvinceRepository;
use App\Services\Interfaces\UserServiceInterface as UserService;
use App\Repositories\Interfaces\DistrictRepositoryInterface as DistrictRepository;
use App\Repositories\Interfaces\WardRepositoryInterface as WardRepository;

use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $users;
    protected $provinces, $districts, $wards;
    protected $breadcrumbs = [];
    public function __construct(UserService $users, ProvinceRepository $province, DistrictRepository $district, WardRepository $ward)
    {
        $this->users = $users;
        $this->provinces = $province;
        $this->districts = $district;
        $this->wards = $ward;
    }

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

    $query = User::with('orders')->orderBy('created_at', 'desc')->withSum('orders', 'final_amount')->where('rule_id', 2);

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
    // public function show(string $id)
    // {
    //     $title = "Chi tiết khách hàng và đơn mua hàng";
    //     array_push($this->breadcrumbs, [
    //         "active" => false,
    //         "url" => route("admin.customer"),
    //         "name" => "Quản lý khách hàng",
    //     ], [

    //         "active" => true,
    //         "url" => route("admin.customer.show", $id),
    //         "name" => "Chi tiết khách hàng và đơn mua hàng",

    //     ]);
    //     $breadcrumbs = $this->breadcrumbs;
    //     $user = User::with(['orders.orderItems','province', 'district', 'ward'])->withSum('orders', 'final_amount')->findOrFail($id);

    //     return view("backend.customers.templates.show", compact("title", "breadcrumbs", "user"));
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title = "Sửa thông tin khách hàng";
        array_push($this->breadcrumbs, [
            "active" => false,
            "url" => route("admin.customer"),
            "name" => "Quản lý khách hàng",
        ], [

            "active" => true,
            "url" => route("admin.customer.edit", $id),
            "name" => "Sửa thông tin khách hàng",

        ]);
        $breadcrumbs = $this->breadcrumbs;
        $data = User::query()->where("id", "=", $id)->first();
        $provinces = $this->provinces->all();
        $districts = $this->provinces->findDistrictByIdProvince($data->province_id);
        $wards = $this->districts->findwardsByIdDistrict($data->district_id);
        return view("backend.customers.templates.edit", compact("title", "breadcrumbs", "data", "id", 'provinces',"districts", "wards"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->except(["_token", "role_id"]);
        $request->validate([
            "email" => "required|email|max:255", // Email không được để trống, phải đúng định dạng email, và không quá 255 ký tự
            "full_name" => "required|string|max:255|regex:/^[\p{L}\s]+$/u", // Họ tên không được để trống, chỉ chứa chữ và dấu cách
            "username" => "required|string|max:50|alpha_num", // Tên đăng nhập không được để trống, chỉ chứa chữ và số, không quá 50 ký tự
            "birthday" => "required|date", // Ngày sinh không được để trống, phải là định dạng ngày hợp lệ
            "province_id" => "required|", // ID tỉnh/thành không được để trống, phải là số nguyên
            "district_id" => "required|", // ID quận/huyện không được để trống, phải là số nguyên
            "ward_id" => "required|", // ID phường/xã không được để trống, phải là số nguyên
            "address" => "required|string|max:255|regex:/^[\p{L}\s0-9.,-]+$/u", // Địa chỉ không được để trống, chỉ được chứa chữ, số và một số ký tự đặc biệt
            "phone" => "required|numeric|digits_between:10,15", // Số điện thoại không được để trống, chỉ chứa số và độ dài từ 10 đến 15 chữ số
        ], [
            "email.required" => "Email không được để trống",
            "email.email" => "Email không đúng định dạng",
            "email.max" => "Email không được vượt quá 255 ký tự",

            "full_name.required" => "Họ tên không được để trống",
            "full_name.string" => "Họ tên phải là chuỗi",
            "full_name.max" => "Họ tên không được vượt quá 255 ký tự",
            "full_name.regex" => "Họ tên không được chứa ký tự đặc biệt",

            "username.required" => "Tên đăng nhập không được để trống",
            "username.string" => "Tên đăng nhập phải là chuỗi",
            "username.max" => "Tên đăng nhập không được vượt quá 50 ký tự",
            "username.alpha_num" => "Tên đăng nhập chỉ được chứa chữ và số",

            "birthday.required" => "Ngày sinh không được để trống",
            "birthday.date" => "Ngày sinh không đúng định dạng ngày",

            "province_id.required" => "Tỉnh/Thành không được để trống",


            "district_id.required" => "Quận/Huyện không được để trống",


            "ward_id.required" => "Phường/Xã không được để trống",


            "address.required" => "Địa chỉ không được để trống",
            "address.string" => "Địa chỉ phải là chuỗi",
            "address.max" => "Địa chỉ không được vượt quá 255 ký tự",
            "address.regex" => "Địa chỉ không được chứa ký tự đặc biệt không hợp lệ",

            "phone.required" => "Số điện thoại không được để trống",
            "phone.numeric" => "Số điện thoại chỉ được nhập số",
            "phone.digits_between" => "Số điện thoại phải có độ dài từ 10 đến 15 chữ số",
        ]);
        $customer = User::find($id);
        if($request->avatar==null){
        $data['avatar']=$customer->avatar;
        };
        if ($customer->update($data)) {
            return response()->json(["success", "Cập nhật thành công"]);
        } else {
            return response()->json(["error", "Cập nhật thất bại"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
