<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;


    protected $table = 'user_role'; // Đặt tên bảng nếu không theo quy tắc mặc định

    // Mối quan hệ: Liên kết người dùng và vai trò
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
