<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function index()
    {
        $banner = Banner::query()->select('title','content','image')->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Thông tin người dùng',
            'data' => [
                'banner' => $banner,
            ]
        ], 200);
    }


}
