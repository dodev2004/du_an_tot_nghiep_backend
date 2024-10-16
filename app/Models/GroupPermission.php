<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GroupPermission extends Model
{
    use HasFactory;
    use SoftDeletes; // Sử dụng tính năng xóa mềm

    protected $fillable = ['name', 'description']; // Các cột có thể được gán hàng loạt
    protected $table = "group_permission";


    // Mối quan hệ: Một nhóm quyền có nhiều quyền
    public function permissions()
    {
        return $this->hasMany(Permission::class, 'group_permission_id');
    }
}
