<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Contact extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        "image",
        "content",
        "user_id",
        "response",
        "status"
    ];
    protected $dates = ['deleted_at'];
    protected $table = "contacts";
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
