<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $breadcrumbs = [];

    public function index()
{
    $title = "Quản lý form liên hệ";
    $this->breadcrumbs[] = [
        "active" => true,
        "url" => route("admin.contact"),
        "name" => "Quản lý form liên hệ"
    ];
    $breadcrumbs = $this->breadcrumbs;

    $searchText = request()->input('seach_text');
    $startDate = request()->input('start_date');
    $endDate = request()->input('end_date');
    $dateOrder = request()->input('date_order');

    $query = Contact::with('user');

    // Search by username
    if ($searchText) {
        $query->whereHas('user', function ($query) use ($searchText) {
            $query->where('full_name', 'LIKE', '%' . $searchText . '%');
        });
    }

    // Filter by date range
    if ($startDate) {
        $query->where('created_at', '>=', $startDate);
    }
    if ($endDate) {
        $query->where('created_at', '<=', $endDate);
    }

    // Sort by date
    if ($dateOrder === 'newest') {
        $query->orderBy('created_at', 'desc');
    } elseif ($dateOrder === 'oldest') {
        $query->orderBy('created_at', 'asc');
    }

    // Paginate the results
    $data = $query->paginate(10);

    return view('backend.contacts.templates.index', compact('title', 'breadcrumbs', 'data'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Quản lý form liên hệ";
        array_push($this->breadcrumbs, [
            "active" => false,
            "url" => route("admin.contact"),
            "name" => "Quản lý form liên hệ",
        ], [

            "active" => true,
            "url" => route("admin.contact.create"),
            "name" => "Thêm form liên hệ",

        ]);
        $breadcrumbs = $this->breadcrumbs;
        return view("backend.contacts.templates.create", compact("title", "breadcrumbs"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "title" => "required|string|max:50|regex:/^[\p{L}\s]+$/u", // Tên không được để trống, phải là chuỗi, không có ký tự đặc biệt

            "content" => "required|string", // Địa chỉ không được để trống, chỉ được phép chứa ký tự chữ, số, dấu cách, và một số ký tự đặc biệt

        ], [
            "title.required" => "Tên không được để trống",
            "title.string" => "Tên phải là chuỗi",
            "title.max" => "Tên không được vượt quá 50 ký tự",


            "content.required" => "Địa chỉ không được để trống",
            "content.string" => "Địa chỉ phải là chuỗi",
            "content.regex" => "Địa chỉ không được chứa ký tự đặc biệt không hợp lệ",


        ]);
        $data = $request->except('_token');
        $data['content'] = preg_replace('/<p>|<\/p>/', '', $request->content);
        $data['user_id'] = Auth::user()->id;
        if (Contact::create($data)) {
            return response()->json(["success", "Thêm mới thành công"]);
        } else {
            return response()->json(["error", "Thêm mới thất bại"]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $title = "Chi tiết form liên hệ";
        array_push($this->breadcrumbs, [
            "active" => false,
            "url" => route("admin.contact"),
            "name" => "Quản lý form liên hệ",
        ], [

            "active" => true,
            "url" => route("admin.contact.show", $id),
            "name" => "Chi tiết form liên hệ",

        ]);
        $data = Contact::with('user')->where("id", "=", $id)->first();
        $user=User::find($data->user_id);
        $breadcrumbs = $this->breadcrumbs;
        return view("backend.contacts.templates.show", compact("title", "breadcrumbs", "data", "user"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(string $id)
    // {

    //     $title = "Sửa form liên hệ";
    //     array_push($this->breadcrumbs, [
    //         "active" => false,
    //         "url" => route("admin.contact"),
    //         "name" => "Quản lý form liên hệ",
    //     ], [

    //         "active" => true,
    //         "url" => route("admin.contact.edit", $id),
    //         "name" => "Sửa form liên hệ",

    //     ]);
    //     $data = Contact::query()->where("id", "=", $id)->first();

    //     $breadcrumbs = $this->breadcrumbs;
    //     return view("backend.contacts.templates.edit", compact("title", "breadcrumbs", "data", "id"));
    // }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, string $id)
    // {
    //     $request->validate([
    //         "name" => "required|string|max:255|regex:/^[\p{L}\s]+$/u", // Tên không được để trống, phải là chuỗi, không có ký tự đặc biệt
    //         "phone" => "required|numeric|digits_between:10,15", // Số điện thoại không được để trống, chỉ được nhập số và có độ dài từ 10 đến 15 chữ số
    //         "address" => "required|string|max:255|regex:/^[\p{L}\s0-9.,-]+$/u", // Địa chỉ không được để trống, chỉ được phép chứa ký tự chữ, số, dấu cách, và một số ký tự đặc biệt
    //         "map" => "required|string", // Map không được để trống, phải là chuỗi
    //     ], [
    //         "name.required" => "Tên không được để trống",
    //         "name.string" => "Tên phải là chuỗi",
    //         "name.max" => "Tên không được vượt quá 255 ký tự",
    //         "name.regex" => "Tên không được chứa ký tự đặc biệt",

    //         "phone.required" => "Số điện thoại không được để trống",
    //         "phone.numeric" => "Số điện thoại chỉ được nhập số",
    //         "phone.digits_between" => "Số điện thoại phải có độ dài từ 10 đến 15 chữ số",

    //         "address.required" => "Địa chỉ không được để trống",
    //         "address.string" => "Địa chỉ phải là chuỗi",
    //         "address.max" => "Địa chỉ không được vượt quá 255 ký tự",
    //         "address.regex" => "Địa chỉ không được chứa ký tự đặc biệt không hợp lệ",

    //         "map.required" => "Map không được để trống",
    //         "map.string" => "Map phải là chuỗi",
    //     ]);
    //     $data = $request->except('_token');
    //     $contact = Contact::find($id);
    //     $data['map'] = preg_replace('/<p>|<\/p>/', '', $request->map);
    //     if ($request->image == null) {
    //         $data['image'] = $contact->image;
    //     };
    //     if ($contact->update($data)) {
    //         return response()->json(["success", "Cập nhật thành công"]);
    //     } else {
    //         return response()->json(["error", "Cập nhật thất bại"]);
    //     }
    // }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(Request $request)
    // {
    //     $contact = Contact::find($request->id);
    //     if ($contact->delete($request->id)) {
    //         return response()->json(["success", "Xóa thành công"]);
    //     } else {
    //         return response()->json(["error", "Xóa thất bại"]);
    //     }
    // }
}
