<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionRole extends Model
{
    use HasFactory;


    protected $table = 'permission_role'; // Đặt tên bảng nếu không theo quy tắc mặc định

    // Mối quan hệ: Liên kết quyền và vai trò
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function permission()
    {
        return $this->belongsTo(Permission::class, 'permission_id');
    }
}
