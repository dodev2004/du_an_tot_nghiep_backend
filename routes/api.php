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

use App\Http\Controllers\Api\InformationController;


use App\Http\Controllers\Api\PostCatelogueController;
use App\Http\Controllers\Api\PostController;

use App\Http\Controllers\Api\ProductReviewController;


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

});

Route::get("/products",[ProductController::class,"index"]);
Route::get("/products/{slug}",[ProductController::class,"index"]);
Route::get('/products/showOne/{id}', [ProductController::class, 'showOne']);
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

Route::get('/contacts', [ContactController::class, 'index'])->middleware('auth:api');
Route::post('/contacts', [ContactController::class, 'store'])->middleware('auth:api');
Route::get('/contacts/show', [ContactController::class, 'show'])->middleware('auth:api');
Route::get('/contacts/show/{id}', [ContactController::class, 'showOne'])->middleware('auth:api');
Route::put('/contacts/{id}', [ContactController::class, 'update'])->middleware('auth:api');
// Route::delete('/contacts/{id}', [ContactController::class, 'destroy'])->middleware('auth:api');

Route::get('/information', [InformationController::class, 'index'])->middleware('auth:api');

Route::get('/about', [AboutController::class, 'index']);


Route::apiResource('posts', PostController::class);

Route::apiResource('post-catelogues', PostCatelogueController::class);

Route::get('products/{id}/reviews', [ProductReviewController::class, 'index']);
Route::post('/products/{id}/reviews', [ProductReviewController::class, 'store']);
Route::get('/products/{id}/reviews/{reviewId}', [ProductReviewController::class, 'show']);

