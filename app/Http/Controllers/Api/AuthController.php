<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register','forgotPassword']]);
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
    $provinceName = $user->province ? $user->province->name : null;
    $districtName = $user->district ? $user->district->name : null;
    $wardName = $user->ward ? $user->ward->name : null;
    // Kiểm tra và tạo đường dẫn URL đầy đủ cho ảnh đại diện
    if ($user->avatar) {
        $user->avatar_url = asset('storage/' . $user->avatar);
    } else {
        $user->avatar_url = null;
    }

    return response()->json([
            'id' => $user->id,
            'username' => $user->username,
            'avatar' => $user->avatar,
            'full_name' => $user->full_name,
            'email' => $user->email,
            'phone' => $user->phone,
            'address' => $user->address,
            "province_id" => $user->province_id,
            "district_id" => $user->district_id,
            "ward_id" => $user->ward_id,
            'birthday' => $user->birthday,
            'province' => $provinceName,
            'district' => $districtName,
            'ward' => $wardName,
            'avatar_url' => $user->avatar_url

    ]);
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
        'province_id' => 'sometimes|string|exists:provinces,code',
        'district_id' => 'sometimes|string|exists:districts,code',
        'ward_id' => 'sometimes|string|exists:wards,code',
        'address' => 'sometimes|string|max:255',
        'birthday' => 'sometimes|date',
        // 'avatar' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
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
        $user = auth()->user();
        
        $provinceName = $user->province ? $user->province->name : null;
        $districtName = $user->district ? $user->district->name : null;
        $wardName = $user->ward ? $user->ward->name : null;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'avatar' => $user->avatar,
                'full_name' => $user->full_name,
                'email' => $user->email,
                'phone' => $user->phone,
                'address' => $user->address,
                'birthday' => $user->birthday,
                'province' => $provinceName,
                'district' => $districtName,
                'ward' => $wardName,
            ]
        ]);
    }
    public function forgotPassword(Request $request)
    {
        // Xác thực email
        $request->validate([
            'email' => 'required|email'
        ]);

        // Tìm người dùng theo email
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'Không tìm thấy người dùng với email này.'], 404);
        }

        $newPassword = Str::random(8); // Tạo mật khẩu ngẫu nhiên dài 8 ký tự

        
        $user->password = Hash::make($newPassword); 
        $user->save();

        // Gửi email mật khẩu mới
        Mail::send('auths.email.new_password', ['newPassword' => $newPassword], function ($message) use ($user) {
            $message->to($user->email);
            $message->subject('Mật khẩu mới của bạn');
        });

        return response()->json(['message' => 'Mật khẩu mới đã được gửi đến email của bạn.'], 200);
    }

    public function changePassword(Request $request)
    {
            $request->validate([
            'password' => 'required|string',
            'new_password' => 'required|string|min:6',
        ]);
        $user = Auth::user();
        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Mật khẩu hiện tại không đúng.'], 400);
        }
        $user->password = Hash::make($request->new_password);
        $user->save();
        return response()->json(['message' => 'Đổi mật khẩu thành công.'], 200);
    }
}
