<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
        "gooogle_id",
        "username",
        "password",
        "full_name",
        "phone",
        "province_id",
        "district_id",
        "ward_id",
        "address",
        "birthday",
        "avatar",
        "user_agent",
        "created_at",
        "updated_at",
        "role_id",
        "goooge_id",
        "last_login",
        "deleted_at"
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function product_comments()
    {
        return $this->hasMany(ProductComment::class, 'user_id'); // 'user_id' là khóa ngoại trong bảng product_comments
    }
    public function product_reviews()
    {
        return $this->hasMany(ProductReview::class, 'user_id'); // 'user_id' là khóa ngoại trong bảng product_reviews
    }
    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class,'customer_id');
    }
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_role', 'user_id', 'role_id');
    }
    public function permissions()
    {
        return $this->hasManyThrough(
            Permission::class, // Model mục tiêu
            Role::class,       // Model trung gian
            'user_id',         // Khóa ngoại trên bảng user_role
            'role_id',         // Khóa ngoại trên bảng permission_role
            'id',              // Khóa chính trên bảng users
            'id'               // Khóa chính trên bảng roles
        );
    }
    public function hasRole($roleName)
    {
        return $this->roles()->where('name', $roleName)->exists();
    }

    public function hasPermission($permissionName)
    {
        return $this->roles()->whereHas('permissions', function ($query) use ($permissionName) {
            $query->where('name', $permissionName);
        })->exists();
    }
}
