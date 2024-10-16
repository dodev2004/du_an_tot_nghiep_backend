<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    use HasFactory;
    use SoftDeletes; // Sử dụng tính năng xóa mềm

    protected $fillable = ['name', 'description','display_name', 'group_permission_id']; // Các cột có thể được gán hàng loạt

    // Mối quan hệ: Một quyền thuộc về một nhóm quyền
    public function groupPermission()
    {
        return $this->belongsTo(GroupPermission::class, 'group_permission_id');
    }

    // Mối quan hệ: Một quyền có thể thuộc nhiều vai trò
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'permission_role', 'permission_id', 'role_id');
    }
}
