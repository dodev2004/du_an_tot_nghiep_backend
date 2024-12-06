<?php

namespace App\Http\Controllers\backend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        return view('backend.welcome.templates.index'); // Đường dẫn đến view lỗi
    }
}
