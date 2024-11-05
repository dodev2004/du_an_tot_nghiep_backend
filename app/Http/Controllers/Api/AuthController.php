<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }
    
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    
        if ($validator->fails()) {
            $errors = $validator->errors();
            $customErrors = [];
    
            if ($errors->has('username')) {
                $customErrors['username'] = 'Tên người dùng đã tồn tại.';
            }
    
            if ($errors->has('email')) {
                $customErrors['email'] = 'Email đã tồn tại.';
            }
    
            if ($errors->has('password')) {
                $customErrors['password'] = 'Mật khẩu không hợp lệ.';
            }
    
            return response()->json($customErrors, 422);
        }
    
        // Tạo người dùng mới
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
    
        // Tạo token cho người dùng mới đăng ký
        $token = auth()->login($user);
    
        // Trả về thông tin người dùng và token
        return $this->respondWithToken($token);
    }

    public function login()
    {
        $credentials = request(['username', 'password']);

        if (! $token = auth("api")->attempt($credentials)) {
            return response()->json(['error' => 'Tài khoản hoặc mật khẩu không đúng'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function profile()
    {
        return response()->json(auth()->user());
    }
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // Xác thực dữ liệu
        $validatedData = $request->validate([
            'username' => 'sometimes|string|max:255|unique:users,username,' . $user->id,
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $user->id,
            'full_name' => 'sometimes|string|max:255',
            'phone' => 'sometimes|string|max:15',
            'province_id' => 'sometimes|integer|exists:provinces,id',
            'district_id' => 'sometimes|integer|exists:districts,id',
            'ward_id' => 'sometimes|integer|exists:wards,id',
            'address' => 'sometimes|string|max:255',
            'birthday' => 'sometimes|date',
            'avatar' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Xử lý ảnh đại diện
        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $validatedData['avatar'] = $path;
        }

        // Cập nhật thông tin người dùng
        $user->update($validatedData);

        return response()->json([
            'message' => 'Cập nhật hồ sơ thành công!',
            'user' => User::find($user->id), // Lấy dữ liệu mới nhất từ DB
        ], 200);
    }

    // public function logout()
    // {
    //     auth()->logout();

    //     return response()->json(['message' => 'Successfully logged out']);
    // }

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,

        ]);
    }
}
