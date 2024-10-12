<?php

namespace App\Classes;

use Illuminate\Support\Facades\DB;

class NestedSetBuild
{
    protected $param = "";
    protected $data = [];
    public function __construct($param = null)
    {
        $this->param = $param;
    }
    public function Get($target = "create", $id = null)
    {
        if ($target == "create") {
            $resuilt = DB::table($this->param ? $this->param : "post_catelogues")->where('deleted_at', Null)->get();
        } else if ($target == "parent") {
            $resuilt = DB::table($this->param ? $this->param : "post_catelogues")->where("id", "=", $id)->where('deleted_at', Null)->get();
        } else {
            $resuilt = DB::table($this->param ? $this->param : "post_catelogues")->where('deleted_at', Null)->get();
        
        }
    
        return $resuilt;
    }
    private function hasChild($data, $id)
    {
        foreach ($data as $item) {
            if ($item->parent_id == $id) {
                return true; // Ngừng kiểm tra ngay khi tìm thấy danh mục con
            }
        }
        return false; // Không tìm thấy danh mục con
    }
    public function _set($param)
    {
        return $this->param = $param;
    }
    public function getParentCatelogue($id)
    {
        $catelogue  = [];
        $data = $this->Get();
        $parent_id = $this->Get("parent", 2)[0]->parent_id;
        foreach ($data as $item) {
            if ($item->id == $parent_id) {
                Array_push($catelogue, $item->id);
            }
        }
        Array_push($catelogue, $id);
        return $catelogue;
    }
    public function renderDropdownEdit($data, $parentId = 0)
    {
        if (request()->id) {
            $id = request()->id;
        } else {
            $id = 0;
        }

        $resuilt = "";
        foreach ($data as $item) {
            if ($item->parent_id == $parentId) {
                if ($item->id == $id) {
                    $resuilt .= "<option value='$item->id' selected>" . str_repeat('---|', $item->level) . $item->name . "</option>";
                } else {
                    $resuilt .= "<option value='$item->id'>" . str_repeat('---|', $item->level) . $item->name . "</option>";
                }
                if ($this->hasChild($data, $item->id)) {
                    $resuilt .= $this->renderDropdown($data, $item->id);
                }
            }
        }

        return $resuilt;
    }
    public function renderDropdown($data, $parentId = 0, $target = "create")
    {   
        if (request()->id) {
            $id = request()->id;
        } else {
            $id = 0;
        }
        $resuilt = "";
        foreach ($data as $item) {
            if ($target == "edit" && $item->id == $id) {
                continue;
            }
            if ($item->parent_id == $parentId) {
                if ($item->id == request()->parent_id) {
                    $resuilt .= "<option value='$item->id' selected>" . str_repeat('---|', $item->level) . $item->name . "</option>";
                } else {
                    $resuilt .= "<option value='$item->id'>" . str_repeat('---|', $item->level) . $item->name . "</option>";
                }
                if ($this->hasChild($data, $item->id)) {
                    $resuilt .= $this->renderDropdown($data, $item->id, $target);
                }
            }
        }

        return $resuilt;
    }
    public function renderDropdownCreate($data, $parent = 0, $target = "create", $catelogues = [], $className)
    {
        if (request()->id) {
            $id = request()->id;
        } else {
            $id = 0;
        }

        $resuilt = "";
        if ($parent  == 0) {
            $resuilt = "<ul class='catelogue'>";
        } else {
            $resuilt = "<ul class='catelogue_child'>";
        }
        foreach ($data as $item) {
            if ($item->parent_id == $parent) {
                if ($target == "edit" && in_array($item->id, $catelogues)) {
                    $resuilt .= "<li>
                    <span> <input type='checkbox' checked name='$className' value='$item->id'> $item->name</span>
                     ";
                } else {
                    $resuilt .= " <li>
                    <span> <input type='checkbox' name='$className' value='$item->id'> $item->name</span>
                     ";
                }


                if ($this->hasChild($data, $item->id)) {
                    $resuilt .= $this->renderDropdownCreate($data, $item->id, $target, $catelogues, $className);
                }
                $resuilt .= "</li>";
            }
        }

        $resuilt .= "</ul>";

        return $resuilt;
    }
    public function renderListPostCatelogue($data)
    {
        $result = ""; // Chuỗi lưu HTML
        
        foreach ($data as $index => $item) {
            $index = $index + 1;
            $routeEdit = route('admin.post-catelogue.edit', [$item->id]);
            $result .= "<tr class='category-row' data-id='$item->id'>";
            $result .= "
                <td class='text-center'>$item->id</td>
                <td>" . str_repeat('---|', $item->level) . "$item->name</td>
                <td class='text-center' style='display: flex; justify-content: center; column-gap: 5px;'>
                    <a href='$routeEdit' class='btn btn-info'><i class='fa fa-pencil'></i></a>
                    <form action='' method='POST' class='form-delete'>
                        " . csrf_field() . method_field('DELETE') . "
                        <input type='hidden' value='$item->id' name='id'>
                        <button type='submit' class='btn btn-warning center'><i class='fa fa-trash-o'></i></button>
                    </form>
                </td>
            ";
            $result .= "</tr>";
    
            // Render danh mục con nếu có
            if (!empty($item->children)) {
                // Gọi lại hàm render cho các danh mục con
                $result .= $this->renderListPostCatelogue($item->children);
            }
        }
        
        return $result; // Trả về kết quả đã render
    }
    public function renderListProductCatelogue($data, $parentId = 0)
    {
        $resuilt = "<tr>";
        foreach ($data as $index => $item) {
            $index = $index + 1;
            if ($item->parent_id == $parentId) {
                $routeEdit = route('admin.product_catelogue.edit', [$item->id]);
                $resuilt .= "
                    <td>$index</td>
                    <td>" . str_repeat('---|', $item->level) . "$item->name</td>
                    <td class='text-center' style='display: flex; justify-content: center;column-gap: 5px;'>
                    <a href='$routeEdit' class='btn btn-info'><i class='fa fa-pencil'></i></a>
                    <form action='' method='POST' data-url='product-catelogue' class='form-delete'>
                    <input type='hidden' name = '_token' value='" . csrf_token() . "' />" .
                    "  <input type='hidden' value='$item->id' name='id'>
                        <button class='btn btn-warning center'><i class='fa fa-trash-o'></i></button>
                    </form>
                    </td>
                ";
                $resuilt .= "</tr>";
                if (!empty($item->children)) {
                    // Gọi lại hàm render cho các danh mục con
                    $resuilt .= $this->renderListPostCatelogue($item->children);
                }
            }
        }

        return $resuilt;
    }
}
