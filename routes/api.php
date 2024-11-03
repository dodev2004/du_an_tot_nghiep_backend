<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AboutController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\PromotionController;
use App\Http\Controllers\backend\AttributeController;
use App\Http\Controllers\api\BrandController;
use App\Http\Controllers\api\ContactController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('register', [AuthController::class,'register']);
    Route::post('login', [AuthController::class,'login']);
    Route::get('profile', [AuthController::class,'profile']);
    // Route::post('logout', [AuthController::class,'logout']);
    Route::post('refresh', [AuthController::class,'refresh']);
    Route::post('update-profile', [AuthController::class, 'updateProfile']);
});

Route::get("/attribute",[AttributeController::class,"getAll"])->name("api.attribute");
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{id}', [ProductController::class, 'show']);
    Route::get('/products/showOne/{id}', [ProductController::class, 'showOne']);
    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{id}', [ProductController::class, 'update']);
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);


Route::get('/promotions', [PromotionController::class, 'index']);
Route::post('/promotions', [PromotionController::class, 'store']);
Route::get('/promotions/{id}', [PromotionController::class, 'show']);
Route::put('/promotions/{id}', [PromotionController::class, 'update']);
Route::delete('/promotions/{id}', [PromotionController::class, 'destroy']);

Route::get('/brands', [BrandController::class, 'index']);
Route::post('/brands', [BrandController::class, 'store']);
Route::get('/brands/{id}', [BrandController::class, 'show']);
Route::put('/brands/{id}', [BrandController::class, 'update']);
Route::delete('/brands/{id}', [BrandController::class, 'destroy']);

Route::get('/contacts', [ContactController::class, 'index']);
Route::post('/contacts', [ContactController::class, 'store']);
Route::get('/contacts/{id}', [ContactController::class, 'show']);
Route::put('/contacts/{id}', [ContactController::class, 'update']);
Route::delete('/contacts/{id}', [ContactController::class, 'destroy']);

Route::get('/about', [AboutController::class, 'index']);
Route::post('/about', [AboutController::class, 'store']);  
Route::get('/about/{id}', [AboutController::class, 'show']);
Route::put('/about/{id}', [AboutController::class, 'update']);
Route::delete('/about/{id}', [AboutController::class, 'destroy']);
