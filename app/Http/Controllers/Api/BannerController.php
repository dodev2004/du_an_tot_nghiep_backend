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


    public function HomeBanner()
    {
        $banner = Banner::query()->select('id','title','content','image','page')->where('page','home')->get();

        if ($banner->isEmpty()) {
            return response()->json(['message' => 'không có banner'], 404);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'dữ liệu Banner',
            'data' => $banner,

        ], 200);
    }
    public function ProductBanner()
    {
        $banner = Banner::query()->select('id','title','content','image','page')->where('page','product')->get();

        if ($banner->isEmpty()) {
            return response()->json(['message' => 'không có banner'], 404);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'dữ liệu Banner',
            'data' => $banner,

        ], 200);
    }


}
