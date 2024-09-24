<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Backend\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\backend\RegisterRequest;
use App\Mail\RegisterMailed;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use App\Services\Interfaces\UserServiceInterface;
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller
{
    public $userService;
    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
        
    }
    public function login(){
        return view("backend.auth.templates.login");
    }
    public function auth(LoginRequest $request ){
        $dataCheck = $request->only([
            "email","password"
        ]);
       if(Auth::attempt($dataCheck,true)){
          $request->session()->regenerate();
          return redirect()->route("admin.dashboard");
       }
       else {
        return redirect()->route('admin.login')->with("message","Tài khoản hoặc mật khẩu không chính xác");
       }
    }
    public function register(){
        return view("backend.auth.templates.register");
    }
    public function registerToken(RegisterRequest $request){
       
    //    Mail::to($request->email)->send(new RegisterMailed($url));
       if($this->userService->create($request->except("_token"))){
        if(Auth::attempt($request->only(["email","password"]),true)){
            $request->session()->regenerate();
            return redirect()->route("admin.dashboard");
        }
        return back()->with("message","Tài khoản đã được đăng ký vui lòng xác nhận thôn qua tín nhắn email")->withInput();
       }
       else {
        return back()->with("message","Tài khoản đăng ký thất bại vui lòng thử lại trong giây lát")->withInput();
       }
       
    }
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route("admin.login");
    }
    public function forgetPassword(){
        return view("backend.auth.templates.confirmemail");
    }
    public function confirmEmail(Request $request){
        $request->validate([
            "email"=>"required|email"
        ],[
            "email.required"=> "Email không được để trống",
            "email.email"=> "Email có định dạng sai"
        ]);
        $status = Password::sendResetLink(
            $request->only('email')
        );
        return $status === Password::RESET_LINK_SENT 
        ? back()->with(['status' => __($status)]) 
        : back()->withErrors(['email' => __($status)]);
    }
    public function showResetForm(Request $request){
        return view('backend.auth.templates.reset')->with([
            'token' => $request->token,
            'email' => $request->email,
        ]);
    }
    public function resetPassword(Request $request){
        $rules = [
            "email"=> "required|email",
            "password"=>"required|min:8",
            "re-password" => "required|min:8|same:password",
        ];
        $messages = [
            "email.required"=> "Email không được để trống",
            "email.email"=> "Email có đ��nh dạng sai",
            "password.required"=> "Mật khẩu không được để trống",
            "password.min8"=> "Mật khẩu phải dài hơn 8 kí tự",
            "re-password.required"=> "Xác nhận mật khẩu không được để trống",
            "re-password.min8"=> "Xác nhận mật khẩu phải dài hơn 8 kí tự",
            "re-password.same"=> "Xác nhận mật khẩu không trùng với mật khẩu"
        ];
        $request->validate($rules, $messages);
        $status = Password::reset(
            $request->only('email', 'password', 're-password', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();

                Auth::login($user);
            }

        );
        return $status === Password::PASSWORD_RESET
        ? redirect()->route('admin.login')->with('status', __($status))
        : back()->withErrors(['email' => [__($status)]]);
    }
}
