<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DasboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware("guest")->prefix("/")->group(function(){
    Route::controller(AuthController::class)->group(function(){
        Route::get('auth/google', 'redirectToGoogle')->name('auth.google');
        Route::get('auth/google/callback', 'handleGoogleCallback');
        Route::get("/login","showLogin")->name("showLogin");
        Route::get("/register","showRegister")->name("showRegister");
        Route::post("/login/store","login")->name("login");
        Route::post("/login/register","register")->name("register");
        Route::get("/confirm_email","showConfirmEmail")->name("showConfirmEmail");
        Route::post("/confirm_email","sendResetLinkEmail")->name("confirmEmail");
        Route::post("/create-password","createPassword")->name("createPassword");
    });
});

Route::get('/password/reset/{token}', function (string $token) {
    return view('auths.reset_password', ['token' => $token]);
})->middleware('guest')->name('password.reset');

Route::middleware("auth")->prefix("/admin")->group(function(){
    Route::get("/dashboard",[DasboardController::class,"index"])->name("dashboard");
    Route::get("/logout",[AuthController::class,"logout"])->name("logout");
    Route::get("/showMessage",function(){
        return view("auths.showMessage");
    })->name("showMessage");
});
                    
Route::get("/",function(){
    return redirect()->route("dashboard");
});