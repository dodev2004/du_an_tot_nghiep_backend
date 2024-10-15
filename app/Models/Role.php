<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory;
    use SoftDeletes; // Sử dụng tính năng xóa mềm

    protected $fillable = ['name', 'description']; // Các cột có thể được gán hàng loạt

    // Mối quan hệ: Một vai trò có nhiều quyền
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_role', 'role_id', 'permission_id');
    }

    // Mối quan hệ: Một vai trò có nhiều người dùng
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_role', 'role_id', 'user_id');
    }
}
