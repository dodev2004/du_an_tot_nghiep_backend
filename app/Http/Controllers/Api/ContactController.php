<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function index()
    {
        // Lấy thông tin người dùng hiện tại và chọn các trường cần thiết
        // $user = Auth::user();
        // $userData = $user ? [
        //     'full_name' => $user->full_name,
        //     'phone' => $user->phone,
        //     'email' => $user->email,
        // ] : null;

        // Lấy toàn bộ danh sách contact
        $contacts = Contact::all();
        $contacts->map(function ($contact) {
            if ($contact->image) {
                $contact->image = asset('storage/' . $contact->image); // Tạo URL đầy đủ cho ảnh
            }
            return $contact;
        });

        // Trả về response JSON bao gồm cả user và contacts
        return response()->json([
            'status' => 'success',
            'message' => 'Thông tin người dùng và danh sách liên hệ',
            'data' => [
                // 'user' => $userData,
                'contacts' => $contacts
            ]
        ], 200);
    }
    public function show($id)
    {
        // Lấy thông tin chi tiết một chương trình khuyến mãi
        $contact = Contact::find($id);
        if (!$contact) {
            return response()->json(['message' => 'contact not found'], 404);
        }
        return response()->json($contact);
    }



    /**
     * Store a newly created resource in storage.
     */


    public function store(Request $request)
    {
        // Xác thực dữ liệu
        $request->validate([
            "content" => "required|string|regex:/^[\p{L}\s]+$/u", // Địa chỉ không được để trống, chỉ chứa ký tự chữ và dấu cách
            "image" => "nullable|max:2048", // Ảnh không bắt buộc, chỉ chấp nhận các định dạng ảnh, tối đa 2MB
        ], [
            "content.required" => "Địa chỉ không được để trống",
            "content.string" => "Địa chỉ phải là chuỗi",
            "content.regex" => "Địa chỉ không được chứa ký tự đặc biệt không hợp lệ",
            "image.max" => "Ảnh không được vượt quá 2MB",
        ]);

        $data = $request->except('_token');
        // $data['content'] = preg_replace('/<p>|<\/p>/', '', $request->content);
        // $data['user_id'] = Auth::user()->id;

        // Xử lý file ảnh nếu có
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('contact', 'public'); // Lưu ảnh vào thư mục 'images' trong storage/public
            $data['image'] = $imagePath; // Lưu đường dẫn ảnh vào cơ sở dữ liệu
        }

        if (Contact::create($data)) {
            return response()->json(["status" => 'success', "message" => "Thêm mới thành công"], 201);
        } else {
            return response()->json(["status" => 'error', "message" => "Thêm mới thất bại"], 500);
        }
    }





    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Xác thực dữ liệu
        $request->validate(
            [
                "response" => "required|string|regex:/^[\p{L}\s]+$/u", // Phản hồi không được để trống, chỉ chứa ký tự chữ và dấu cách

            ],
            [
                "response.required" => "Phản hồi không được để trống",
                "response.string" => "Phản hồi phải là chuỗi",
                "response.regex" => "Phản hồi không được chứa ký tự đặc biệt không hợp lệ",

            ]
        );

        // Lấy dữ liệu từ request và loại bỏ các trường không cần thiết
        $data = $request->except('_token', '_method', 'image');
        $data['response'] = preg_replace('/<p>|<\/p>/', '', $request->response);
        $data['status'] = 1;

        // Tìm kiếm bản ghi liên quan đến ID
        $contact = Contact::find($id);

        if (!$contact) {
            return response()->json(["status" => 'error', "message" => "Không tìm thấy bản ghi"], 404);
        }

        // Xử lý file ảnh nếu có
        // Cập nhật dữ liệu
        if ($contact->update($data)) {
            return response()->json(["status" => 'success', "message" => "Cập nhật thành công"], 200);
        } else {
            return response()->json(["status" => 'error', "message" => "Cập nhật thất bại"], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        // Tìm bản ghi theo ID
        $contact = Contact::find($request->id);

        // Kiểm tra xem bản ghi có tồn tại không
        if (!$contact) {
            return response()->json(["status" => 'error', "message" => "Không tìm thấy bản ghi"], 404);
        }

        // Xóa bản ghi
        if ($contact->delete()) {
            // Nếu có ảnh liên quan, xóa ảnh từ storage
            if ($contact->image) {
                Storage::disk('public')->delete($contact->image);
            }
            return response()->json(["status" => 'success', "message" => "Xóa thành công"], 200);
        } else {
            return response()->json(["status" => 'error', "message" => "Xóa thất bại"], 500);
        }
    }
}
