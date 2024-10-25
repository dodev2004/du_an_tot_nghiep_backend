<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AboutPage extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'title', 
        'content', 
        'status', 
        'image'
    ];
    protected $table = "about_pages";
}
