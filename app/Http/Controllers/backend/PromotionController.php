<?php

namespace App\Http\Controllers\Backend;


use Carbon\Carbon;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Repositories\Interfaces\PromotionRepositoryInterface as PromotionRepository;

class PromotionController extends Controller
{
    protected $promotions;
    protected $breadcrumbs = [];

    public function __construct(PromotionRepository $promotions)
    {
        $this->promotions = $promotions;
    }
    public function listPromotions(Request $request)
    {
        $title = "Quản lý mã giảm giá";
        $searchText = $request->get('search_text');
        $searchRule = $request->get('search_rule');
        $query = Promotion::query()->orderBy('created_at', 'desc');
        if (!empty($searchText)) {
            $query->where('code', 'LIKE', '%' . $searchText . '%');
        }
        if (!empty($searchRule)) {
            $query->where('discount_type', $searchRule);
        }
        $data = $query->paginate(10);

        $this->breadcrumbs[] = [
            "active" => true,
            "url" => route("admin.promotions"),
            "name" => "Quản lý mã giảm giá"
        ];

        $breadcrumbs = $this->breadcrumbs;
        return view("backend.promotion.templates.list", compact('data', 'breadcrumbs', 'title'));
    }


    public function create()
    {
        $title = "Quản lý mã giảm giá";
        array_push($this->breadcrumbs, [
            "active" => false,
            "url" => route("admin.promotions"),
            "name" => "Quản lý mã giảm giá",
        ], [
            "active" => true,
            "url" => route("admin.promotions.create"),
            "name" => "Thêm mã giảm giá",
        ]);
        $breadcrumbs = $this->breadcrumbs;
        return view("backend.promotion.templates.create", compact("title", "breadcrumbs"));
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'code' => 'required|string|unique:promotions',
            'discount_value' => 'required|numeric|min:0',
            'discount_type' => 'required|in:percentage,fixed',
            'status' => 'required|boolean',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'max_uses' => 'required|integer|min:1',
            'used_count' => 'integer|min:0',
            'gt_don_hang_toi_thieu' => 'required|numeric|min:0', // Thêm validate cho giá trị đơn hàng tối thiểu
            'gia_tri_giam_toi_da' => 'required_if:discount_type,percentage|numeric|min:0', // Thêm validate cho giá trị giảm tối đa
        ], [
            "code.required" => "Mã khuyến mãi không được để trống ",
            "code.unique" => "Mã khuyến mãi này đã tồn tại ",
            "discount_value.required" => "Giá trị giảm giá không được để trống",
            "discount_value.numeric" => "Giá trị giảm giá phải là số",
            "discount_type.required" => "Vui lòng chọn loại giảm giá",
            "status.required" => "Vui lòng chọn trạng thái",
            "start_date.required" => "Vui lòng chọn ngày bắt đầu",
            'start_date.after_or_equal' => 'Ngày bắt đầu phải sau hoặc bằng ngày hôm nay',
            "end_date.required" => "Vui lòng chọn ngày kết thúc",
            "end_date.after_or_equal" => "Ngày kết thúc phải sau hoặc bằng ngày bắt đầu",
            "max_uses.required" => "Vui lòng nhập số lượt sử dụng tối đa",
            "max_uses.min" => "Số lượt sử dụng tối đa phải lớn hơn 0",
            "gt_don_hang_toi_thieu.required" => "Giá trị đơn hàng tối thiểu không được để trống",
            "gt_don_hang_toi_thieu.numeric" => "Giá trị đơn hàng tối thiểu phải là số",
            "gt_don_hang_toi_thieu.min" => "Giá trị đơn hàng tối thiểu phải lớn hơn hoặc bằng 0",
            "gia_tri_giam_toi_da.required" => "Giá trị giảm tối đa không được để trống",
            "gia_tri_giam_toi_da.numeric" => "Giá trị giảm tối đa phải là số",
            "gia_tri_giam_toi_da.min" => "Giá trị giảm tối đa phải lớn hơn hoặc bằng 0"
        ]);
        if ($validatedData['discount_type'] == 'percentage' && $validatedData['discount_value'] > 100) {
            return redirect()->back()->withErrors(['discount_value' => 'Giá trị giảm giá không được vượt quá 100% khi loại giảm giá là phần trăm.'])->withInput();
        }
        Promotion::create($validatedData);
        return redirect()->route('admin.promotions')->with('success', 'Promotion added successfully.');
    }


    public function edit($id)
    {
        $promotion = $this->promotions->getPromotionById($id);
        $title = "Quản lý mã giảm giá";
        array_push($this->breadcrumbs, [
            "active" => false,
            "url" => route("admin.promotions"),
            "name" => "Quản lý mã giảm giá",
        ], [

            "active" => true,
            "url" => route("admin.promotions.create"),
            "name" => "Sửa mã giảm giá",

        ]);
        $breadcrumbs = $this->breadcrumbs;
        return view('backend.promotion.templates.edit', compact('promotion', 'breadcrumbs', 'title', 'id'));
    }
    public function update(Request $request, $id)
    {
       $validatedData = $request->validate([
            "code" => ["required", Rule::unique("promotions")->ignore($id)],
            "discount_value" => ["required", "numeric"],
            'discount_type' => 'required|in:percentage,fixed',
            "status" => ["required", "boolean"],
            'start_date' => 'required|date',
            "end_date" => ["required", "date", "after_or_equal:start_date"],
            "max_uses" => ["required", "integer", "min:1"],
            'gt_don_hang_toi_thieu' => 'required|numeric|min:0', // Thêm validate cho giá trị đơn hàng tối thiểu
            'gia_tri_giam_toi_da' => 'required_if:discount_type,percentage|numeric|min:0',
        ], [
            "code.required" => "Mã khuyến mãi không được để trống",
            "code.unique" => "Mã khuyến mãi này đã tồn tại",
            "discount_value.required" => "Giá trị giảm giá không được để trống",
            "discount_value.numeric" => "Giá trị giảm giá phải là số",
            "discount_type.required" => "Vui lòng chọn loại giảm giá",
            "status.required" => "Vui lòng chọn trạng thái",
            "start_date.required" => "Vui lòng chọn ngày bắt đầu",
            "end_date.required" => "Vui lòng chọn ngày kết thúc",
            "end_date.after_or_equal" => "Ngày kết thúc phải sau hoặc bằng ngày bắt đầu",
            "max_uses.required" => "Vui lòng nhập số lượt sử dụng tối đa",
            "max_uses.min" => "Số lượt sử dụng tối đa phải lớn hơn 0",
            "gt_don_hang_toi_thieu.required" => "Giá trị đơn hàng tối thiểu không được để trống",
    "gt_don_hang_toi_thieu.numeric" => "Giá trị đơn hàng tối thiểu phải là số",
    "gt_don_hang_toi_thieu.min" => "Giá trị đơn hàng tối thiểu phải lớn hơn hoặc bằng 0",
    "gia_tri_giam_toi_da.required" => "Giá trị giảm tối đa không được để trống",
    "gia_tri_giam_toi_da.numeric" => "Giá trị giảm tối đa phải là số",
    "gia_tri_giam_toi_da.min" => "Giá trị giảm tối đa phải lớn hơn hoặc bằng 0"
        ]);
        if ($validatedData['discount_type'] == 'percentage' && $validatedData['discount_value'] > 100) {
            return redirect()->back()->withErrors(['discount_value' => 'Giá trị giảm giá không được vượt quá 100% khi loại giảm giá là phần trăm.'])->withInput();
        }
        $promotion = $this->promotions->getPromotionById($id);
        $data = $request->only([
            "code",
            "discount_value",
            "discount_type",
            "status",
            "start_date",
            "end_date",
            "max_uses",
            'gt_don_hang_toi_thieu',
            'gia_tri_giam_toi_da',
        ]);
        $promotion->update($data);
        return redirect()->route('admin.promotions')->with('success', 'Cập nhật khuyến mãi thành công');
    }
    public function deletePromotion(Request $request, $id)
    {
        $id = $request->input('id');
        $promotion = Promotion::findOrFail($id);

        if ($promotion) {
            $promotion->delete();
            return response()->json(['message' => 'Khuyến mãi đã được xóa thành công', 'status' => 'success'], 200);
        } else {
            return response()->json(['message' => 'Không tìm thấy khuyến mãi', 'status' => 'error'], 404);
        }
    }
}
