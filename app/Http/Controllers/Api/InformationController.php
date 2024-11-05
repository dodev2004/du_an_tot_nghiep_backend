<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Information;
use Illuminate\Http\Request;

class InformationController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function index()
    {
        $information = Information::all();
        if ($information->isEmpty()) {
            return response()->json(['message' => 'admin không có thông tin liên hệ'], 404);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Thông tin liên hệ của admin',
            'data' => $information,

        ], 200);
    }




}
