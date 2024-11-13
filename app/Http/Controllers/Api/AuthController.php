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
    $user = auth()->user();

    // Kiểm tra và tạo đường dẫn URL đầy đủ cho ảnh đại diện
    if ($user->avatar) {
        $user->avatar_url = asset('storage/' . $user->avatar);
    } else {
        $user->avatar_url = null;
    }

    return response()->json($user);
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
        // Chuyển đường dẫn thành URL đầy đủ
        $validatedData['avatar'] = asset('storage/' . $path);
    }

    // Cập nhật thông tin người dùng
    $user->update($validatedData);

    return response()->json([
        'message' => 'Cập nhật hồ sơ thành công!',
        'user' => $user, // Trả về dữ liệu người dùng với URL ảnh đại diện
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
        $user =auth()->user();
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user'=>[
                'username'=>$user->username,
                'avatar'=>$user->avatar,
                'full_name'=>$user->full_name,
                'email'=>$user->email,
                'phone'=>$user->phone,
                'address'=>$user->address,
                'birthday'=>$user->birthday
            ]

        ]);
    }
}
