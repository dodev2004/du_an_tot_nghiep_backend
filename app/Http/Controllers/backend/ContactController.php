<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;


class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $breadcrumbs = [];

    public function index()
    {
        $title = "Quản lý trang liên hệ";
        $this->breadcrumbs[] = [
            "active" => true,
            "url" => route("admin.contact"),
            "name" => "Quản lý trang liên hệ"
        ];
        $breadcrumbs = $this->breadcrumbs;
        $data = Contact::all();
        $item = Contact::query()->first();
        if ($item) {
            return view('backend.contacts.templates.index', compact('breadcrumbs', "title", "data", "item"));
        } else {
            return view('backend.contacts.templates.index', compact('breadcrumbs', "title", "data"));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Quản lý trang liên hệ";
        array_push($this->breadcrumbs, [
            "active" => false,
            "url" => route("admin.contact"),
            "name" => "Quản lý trang liên hệ",
        ], [

            "active" => true,
            "url" => route("admin.contact.create"),
            "name" => "Thêm trang liên hệ",

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
            "name" => "required|string|max:255|regex:/^[\p{L}\s]+$/u", // Tên không được để trống, phải là chuỗi, không có ký tự đặc biệt
            "phone" => "required|numeric|digits_between:10,15", // Số điện thoại không được để trống, chỉ được nhập số và có độ dài từ 10 đến 15 chữ số
            "address" => "required|string|max:255|regex:/^[\p{L}\s0-9.,-]+$/u", // Địa chỉ không được để trống, chỉ được phép chứa ký tự chữ, số, dấu cách, và một số ký tự đặc biệt
            "map" => "required|string", // Map không được để trống, phải là chuỗi
        ], [
            "name.required" => "Tên không được để trống",
            "name.string" => "Tên phải là chuỗi",
            "name.max" => "Tên không được vượt quá 255 ký tự",
            "name.regex" => "Tên không được chứa ký tự đặc biệt",

            "phone.required" => "Số điện thoại không được để trống",
            "phone.numeric" => "Số điện thoại chỉ được nhập số",
            "phone.digits_between" => "Số điện thoại phải có độ dài từ 10 đến 15 chữ số",

            "address.required" => "Địa chỉ không được để trống",
            "address.string" => "Địa chỉ phải là chuỗi",
            "address.max" => "Địa chỉ không được vượt quá 255 ký tự",
            "address.regex" => "Địa chỉ không được chứa ký tự đặc biệt không hợp lệ",

            "map.required" => "Map không được để trống",
            "map.string" => "Map phải là chuỗi",
        ]);
        $data=$request->except('_token');
        $data['map'] = preg_replace('/<p>|<\/p>/', '', $request->map);

        if (Contact::create($data)) {
            return response()->json(["success", "Thêm mới thành công"]);
        } else {
            return response()->json(["error", "Thêm mới thất bại"]);
        }
    }

    /**
     * Display the specified resource.
     */


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $title = "Sửa trang liên hệ";
        array_push($this->breadcrumbs, [
            "active" => false,
            "url" => route("admin.contact"),
            "name" => "Quản lý trang liên hệ",
        ], [

            "active" => true,
            "url" => route("admin.contact.edit", $id),
            "name" => "Sửa trang liên hệ",

        ]);
        $data = Contact::query()->where("id", "=", $id)->first();

        $breadcrumbs = $this->breadcrumbs;
        return view("backend.contacts.templates.edit", compact("title", "breadcrumbs", "data", "id"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            "name" => "required|string|max:255|regex:/^[\p{L}\s]+$/u", // Tên không được để trống, phải là chuỗi, không có ký tự đặc biệt
            "phone" => "required|numeric|digits_between:10,15", // Số điện thoại không được để trống, chỉ được nhập số và có độ dài từ 10 đến 15 chữ số
            "address" => "required|string|max:255|regex:/^[\p{L}\s0-9.,-]+$/u", // Địa chỉ không được để trống, chỉ được phép chứa ký tự chữ, số, dấu cách, và một số ký tự đặc biệt
            "map" => "required|string", // Map không được để trống, phải là chuỗi
        ], [
            "name.required" => "Tên không được để trống",
            "name.string" => "Tên phải là chuỗi",
            "name.max" => "Tên không được vượt quá 255 ký tự",
            "name.regex" => "Tên không được chứa ký tự đặc biệt",

            "phone.required" => "Số điện thoại không được để trống",
            "phone.numeric" => "Số điện thoại chỉ được nhập số",
            "phone.digits_between" => "Số điện thoại phải có độ dài từ 10 đến 15 chữ số",

            "address.required" => "Địa chỉ không được để trống",
            "address.string" => "Địa chỉ phải là chuỗi",
            "address.max" => "Địa chỉ không được vượt quá 255 ký tự",
            "address.regex" => "Địa chỉ không được chứa ký tự đặc biệt không hợp lệ",

            "map.required" => "Map không được để trống",
            "map.string" => "Map phải là chuỗi",
        ]);
        $data=$request->except('_token');
        $contact = Contact::find($id);
        $data['map'] = preg_replace('/<p>|<\/p>/', '', $request->map);
        if($request->image==null){
        $data['image']=$contact->image;
        };
        if ($contact->update($data)) {
            return response()->json(["success", "Cập nhật thành công"]);
        } else {
            return response()->json(["error", "Cập nhật thất bại"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $contact = Contact::find($request->id);
        if ($contact->delete($request->id)) {
            return response()->json(["success", "Xóa thành công"]);
        } else {
            return response()->json(["error", "Xóa thất bại"]);
        }
    }
}
