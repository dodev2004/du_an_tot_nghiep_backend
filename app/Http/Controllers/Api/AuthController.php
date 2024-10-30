<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }
    
    public function register(Request $request)
{
    // Xác thực các dữ liệu đầu vào
     $request->validate([
        'username' => 'required|string|max:255|unique:users',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:6|confirmed',
    ]);

    // Tạo người dùng mới
    $user = User::create([
        'username' => $request->username,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    // Tạo token cho người dùng mới đăng ký
    $token = auth()->guard('api')->login($user);

    // Trả về thông tin người dùng và token
    return $this->respondWithToken($token);
}

    public function login()
    {
        $credentials = request(['username', 'password']);

        if (! $token = auth()->guard('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function profile()
    {
        return response()->json(auth()->guard('api')->user());
    }

    // public function logout()
    // {
    //     auth()->logout();

    //     return response()->json(['message' => 'Successfully logged out']);
    // }

    public function refresh()
    {
        return $this->respondWithToken(auth()->guard('api')->refresh());
    }
    protected function respondWithToken($token)
{
    return response()->json([
        'access_token' => $token,
        'token_type' => 'bearer',
        'expires_in' => auth()->guard('api')->factory()->getTTL() * 60, // Sử dụng guard 'api' nếu JWT được cấu hình
    ]);
}
}
