<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Rules\Captcha;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Jobs\SendPasswordResetEmail;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
class AuthController extends Controller
{
    public function showLogin()
    {
        $title = "Đăng nhập tài khoản";

        return view("auths.login", compact("title"));
    }
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
    public function handleGoogleCallback()
    {
        try {

            $user = Socialite::driver('google')->user();

            $finduser = User::where('google_id', $user->id)->orWhere('email', $user->email)->first();

            if ($finduser) {
                if ($finduser->google_id) {
                    $finduser->google_id = $user->id;
                    $finduser->save();
                }
                Auth::login($finduser);
                request()->session()->regenerate();
                return redirect()->intended('dashboard');
            } else {
                return redirect()->route("login")->with(["message" => "Tài khoản chưa tồn tại"]);
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
    public function login(Request $request)
    {
        if ($request->isMethod("POST")) {
            $request->validate([
                "username" => "required",
                "password" => "required",
                "g-recaptcha-response" => new Captcha(),
            ], [
                "required" => ":attribute không được để trống",
            ], [
                "username" => "Tên đăng nhập",
                "password" => "Mật khẩu",
                "g-recaptcha-response" => "Xác nhận captcha",
            ]);
            $data = $request->except("_token", "g-recaptcha-response");
            $user = User::query()->where("username", $data["username"])->first();
            if ($user && Hash::check($data["password"], $user->password)) {
                Auth::login($user);
                request()->session()->regenerate();
                return redirect()->route("showMessage");
            } else if ($user && !Hash::check($data["password"], $user->password)) {
                return redirect()->route("showLogin")->with('message', "Tài khoản mật khẩu không đúng !");
            } else {
                return redirect()->route("showLogin")->with('message', "Tài khoản mật khẩu không tồn tại !");
            }
        }
    }

    public function showRegister()
    {
        $title = "Đăng ký tài khoản";

        return view("auths.register", compact("title"));
    }

    public function register(Request $request)
    {
        if ($request->isMethod("POST")) {
            $request->validate([
                "username" => "required|unique:users,username",
                "email" => "required|unique:users,email",
                "password" => "required|min:8",
                "g-recaptcha-response" => new Captcha(),
            ], [
                "required" => ":attribute không được để trống",
                "unique" => ":attribute đã tồn tại",
                "min" => "Mật khẩu phải có ít nhất 8 ký tự",
            ], [
                "username" => "Tên đăng nhập",
                "email" => "Email",
                "password" => "Mật khẩu",
            ]);
            $data = $request->except("_token", "g-recaptcha-response");
            $user = User::query()->create([
                "username" => $data["username"],
                "password" => Hash::make($data["password"]),
                "email" => $data["email"]
            ]);
            if ($user) {
                Auth::login($user);
                request()->session()->regenerate();
                return redirect()->route("showMessage");
            }
        }
    }
    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route("showLogin");
    }
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        if(User::query()->where("email", "=", $request->email)->first()){
            $status = Password::sendResetLink($request->only('email'));
            
            if ($status === Password::RESET_LINK_SENT) {
                $user = User::query()->where("email", "=", $request->email)->first();
                $token = app('auth.password.broker')->createToken($user);
        
                Mail::to($request->email)->send(new ResetPasswordMail($token,$user->email));

                return back()->with(['status' => __($status)]);
            } else {
                return back()->withErrors(['email' => __($status)]);
            }
        } else {
            return back()->withErrors(['email' => "Email của bạn chưa tồn tại"]);
        }
      

        
    }
    public function showConfirmEmail(){
        $title = "Quên mật khẩu";
        return view("auths.confirm_email",compact("title"));
    }
    public function createPassword(Request $request){
        $request->validate([
            'password' => 'required|min:8',
            "re_password" => "required|same:password"
        ],[
            "required" => ":attribute không được để trống",
            "password.min" => "Mật khẩu phải dài hơn 8 ký tự",
            "re_password.same" => "Mật khẩu không trùng khớp",
           
        ],[
            "password" => "Mật khẩu"
        ]);
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
                    ? redirect()->route('showLogin')->with('status', __($status))
                    : back()->withErrors(['email' => [__($status)]]);
    }

}