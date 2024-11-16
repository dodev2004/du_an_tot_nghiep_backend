<?php

use App\Http\Controllers\ajax\GetLocaitonAjax;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\AboutController;
use App\Http\Controllers\api\BrandController;
use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\api\ContactController;
use App\Http\Controllers\Api\ProductCatelogueController;

use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\PromotionController;


use App\Http\Controllers\Api\InformationController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PostCatelogueController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\ProductReviewController;
use App\Http\Controllers\backend\AttributeController;


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
Route::group(['middleware' => ['api'], 'prefix' => 'auth'], function () {
    // Các route không yêu cầu đăng nhập
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
});

Route::middleware(['api', 'jwt.auth'])->group(function () {
    // Các route yêu cầu đăng nhập
    Route::get('auth/profile', [AuthController::class, 'profile']);
    Route::post('auth/refresh', [AuthController::class, 'refresh']);
    Route::post('auth/update-profile', [AuthController::class, 'updateProfile']);

    Route::get('/favorites', [FavoriteController::class, 'index']);
    Route::post('/favorites/toggle', [FavoriteController::class, 'toggleFavorite']);

    Route::apiResource('orders', OrderController::class);
    Route::put('/orders/{id}/complete-status', [OrderController::class, 'completeOrderStatus']);
    

    Route::get('/cart', [CartController::class, 'index']); // Lấy danh sách giỏ hàng
    Route::post('/cart', [CartController::class, 'store']); // Thêm sản phẩm vào giỏ hàng
    Route::put('/cart/{id}', [CartController::class, 'update']); // Cập nhật số lượng
    Route::delete('/cart/{id}', [CartController::class, 'destroy']); // Xóa sản phẩm khỏi giỏ hàng
});

Route::get("/attribute",[AttributeController::class,"getAll"])->name("api.attribute");
Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::get('/chi-tiet-san-pham/{id}', [ProductController::class, 'show']);
    Route::get('/showOne/{id}', [ProductController::class, 'showOne']);
    Route::get('/san-pham-noi-bat', [ProductController::class, 'spNoiBat']);
    Route::get('/splq', [ProductController::class, 'spLienQuan']);
});


// Lấy giảm giá
Route::get('/promotions', [PromotionController::class, 'index']);
Route::post('/promotions', [PromotionController::class, 'store']);
Route::get('/promotions/{id}', [PromotionController::class, 'show']);
Route::put('/promotions/{id}', [PromotionController::class, 'update']);
Route::delete('/promotions/{id}', [PromotionController::class, 'destroy']);
// Lấy mã giảm giá
Route::get('/brands', [BrandController::class, 'index']);
Route::post('/brands', [BrandController::class, 'store']);
Route::get('/brands/{id}', [BrandController::class, 'show']);
Route::put('/brands/{id}', [BrandController::class, 'update']);
Route::delete('/brands/{id}', [BrandController::class, 'destroy']);
// Thông tin chung
Route::get('/information', [InformationController::class, 'index']);
Route::get('/banners-home', [BannerController::class, 'HomeBanner']);
Route::get('/banners-product', [BannerController::class, 'ProductBanner']);
// Bài viết
Route::apiResource('posts', PostController::class);
Route::get('/posts/related-posts/{id}', [PostController::class, 'relatedPosts']);
Route::apiResource('post-catelogues', PostCatelogueController::class);

// Đánh giá
Route::get('products/{id}/reviews', [ProductReviewController::class, 'index']);
Route::post('/products/{id}/reviews', [ProductReviewController::class, 'store']);
Route::get('/products/{id}/reviews/{reviewId}', [ProductReviewController::class, 'show']);
// Thông tin liên hệ
Route::get('/contacts', [ContactController::class, 'index']);
Route::post('/contacts', [ContactController::class, 'store']);
Route::get('/contacts/{id}', [ContactController::class, 'show']);
Route::put('/contacts/{id}', [ContactController::class, 'update']);
Route::delete('/contacts/{id}', [ContactController::class, 'destroy']);
//Giowis thieu 
Route::get('/about', [AboutController::class, 'index']);
Route::post('/about', [AboutController::class, 'store']);
Route::get('/about/{id}', [AboutController::class, 'show']);
Route::put('/about/{id}', [AboutController::class, 'update']);
Route::delete('/about/{id}', [AboutController::class, 'destroy']);


Route::get('/product-catalogues', [ProductCatelogueController::class, 'index']);


Route::get("/getLocaion", [GetLocaitonAjax::class, "index"]);
Route::get("/getAllProvinces",[GetLocaitonAjax::class,"getAllProvinces"]);