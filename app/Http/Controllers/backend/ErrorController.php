<?php

namespace App\Http\Controllers\backend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ErrorController extends Controller
{
    public function permissionDenied()
    {
        return view('backend.errors.templates.index'); // Đường dẫn đến view lỗi
    }
}
