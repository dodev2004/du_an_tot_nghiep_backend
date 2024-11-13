<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\User;
use Carbon\Carbon;
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

        $query = Contact::with('user')
            ->orderBy('status', 'asc')
            ->orderBy('updated_at', 'asc');

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
        if (request()->input('trash')) {
            if ($startDate) {
                $query->where('deleted_at', '>=', $startDate);
            }
            if ($endDate) {
                $query->where('deleted_at', '<=', $endDate);
            }
            $data = $query->onlyTrashed()->paginate(5); // Nếu có trash thì chỉ lấy dữ liệu đã xóa mềm
            return view('backend.trash.trash_contact.templates.index', compact('breadcrumbs', "title", "data"));
        }

        // Paginate the results
        $data = $query->paginate(10);
        // Thêm cột 'is_updated_over_30_days' cho mỗi bản ghi
        $data->getCollection()->transform(function ($contact) {
            $contact->is_updated_over_30_days = $contact->updated_at && $contact->updated_at->lt(Carbon::now()->subDays(30));
            return $contact;
        });
        return view('backend.contacts.templates.index', compact('title', 'breadcrumbs', 'data'));
    }


    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     $title = "Quản lý form liên hệ";
    //     array_push($this->breadcrumbs, [
    //         "active" => false,
    //         "url" => route("admin.contact"),
    //         "name" => "Quản lý form liên hệ",
    //     ], [

    //         "active" => true,
    //         "url" => route("admin.contact.create"),
    //         "name" => "Thêm form liên hệ",

    //     ]);
    //     $breadcrumbs = $this->breadcrumbs;
    //     return view("backend.contacts.templates.create", compact("title", "breadcrumbs"));
    // }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         "title" => "required|string|max:50|regex:/^[\p{L}\s]+$/u", // Tên không được để trống, phải là chuỗi, không có ký tự đặc biệt

    //         "content" => "required|string", // Địa chỉ không được để trống, chỉ được phép chứa ký tự chữ, số, dấu cách, và một số ký tự đặc biệt

    //     ], [
    //         "title.required" => "Tên không được để trống",
    //         "title.string" => "Tên phải là chuỗi",
    //         "title.max" => "Tên không được vượt quá 50 ký tự",


    //         "content.required" => "Địa chỉ không được để trống",
    //         "content.string" => "Địa chỉ phải là chuỗi",
    //         "content.regex" => "Địa chỉ không được chứa ký tự đặc biệt không hợp lệ",


    //     ]);
    //     $data = $request->except('_token');
    //     $data['content'] = preg_replace('/<p>|<\/p>/', '', $request->content);
    //     $data['user_id'] = Auth::user()->id;
    //     if (Contact::create($data)) {
    //         return response()->json(["success", "Thêm mới thành công"]);
    //     } else {
    //         return response()->json(["error", "Thêm mới thất bại"]);
    //     }
    // }

    /**
     * Display the specified resource.
     */
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title = "Phản hồi";
        array_push($this->breadcrumbs, [
            "active" => false,
            "url" => route("admin.contact"),
            "name" => "Quản lý form liên hệ",
        ], [

            "active" => true,
            "url" => route("admin.contact.edit", $id),
            "name" => "Phản hồi",

        ]);
        $data = Contact::with('user')->where("id", "=", $id)->first();
        $user = User::find($data->user_id);
        $breadcrumbs = $this->breadcrumbs;
        return view("backend.contacts.templates.edit", compact("title", "breadcrumbs", "data", "user"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate(
            [
                "response" => "required|string|regex:/^[\p{L}\s0-9.,-]+$/u",
            ],
            [
                "response.required" => "Phản hồi không được để trống",
                "response.string" => "Phản hồi phải là chuỗi",
                "response.regex" => "Phản hồi không được chứa ký tự đặc biệt không hợp lệ",
            ]
        );
        $data = $request->except('_token', '_method', 'image');
        $data['response'] = preg_replace('/<p>|<\/p>/', '', $request->response);
        $data['status'] = 1;
        $contact = Contact::find($id);

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
        // dd(Contact::all());
        if ($contact->delete($request->id)) {
            return response()->json(["success", "Xóa thành công"]);
        } else {
            return response()->json(["error", "Xóa thất bại"]);
        }
    }

    public function force_destroy(Request $request)
    {
        // Tìm bản ghi đã bị xóa mềm bằng ID
        $contact = Contact::onlyTrashed()->find($request->id);

        // Kiểm tra nếu tồn tại và thực hiện xóa vĩnh viễn
        if ($contact) {
            $contact->forceDelete(); // Thực hiện xóa vĩnh viễn
            return response()->json(["success" => "Xóa vĩnh viễn thành công"]);
        } else {
            return response()->json(["error" => "Bản ghi không tồn tại"]);
        }
    }
    public function restore($id)
    {
        $contact = Contact::onlyTrashed()->findOrFail($id);
        $contact->restore(); // Khôi phục bình luận

        return redirect()->back()->with('success', 'form liên hệ đã được khôi phục thành công!');
    }
    public function trash()
    {
        $title = "Danh sách form liên hệ đã xóa";
        array_push($this->breadcrumbs, [
            "active" => true,
            "url" => route("admin.contact.trash"),
            "name" => "Danh sách form liên hệ đã xóa"
        ]);
        $breadcrumbs = $this->breadcrumbs;

        // Lấy các bình luận đã xóa mềm
        $data = Contact::onlyTrashed()->with('user')
            ->orderBy('status', 'asc')->paginate(10);

        return view("backend.trash.trash_contact.templates.index", compact("title", "breadcrumbs", "data"));
    }
}
