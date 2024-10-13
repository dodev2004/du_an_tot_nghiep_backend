<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DasboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ajax\ChangeStatusAjax;
use App\Http\Controllers\ajax\GetLocaitonAjax;
use App\Http\Controllers\Backend\AboutPageController;
use App\Http\Controllers\backend\AttributeController;
use App\Http\Controllers\backend\AttributeValueController;
use App\Http\Controllers\backend\BrandController;
use App\Http\Controllers\backend\ContactController;
use App\Http\Controllers\backend\DashBoardController;
use App\Http\Controllers\backend\InformationController;
use App\Http\Controllers\backend\PostController;
use App\Http\Controllers\backend\ProductCatelogueController;

use App\Http\Controllers\backend\ProductController;
use App\Http\Controllers\backend\ProductCommentController;
use App\Http\Controllers\backend\ProductReviewController;
use App\Http\Controllers\Backend\UserCatelogueController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\PaymentMethodsController;

use App\Http\Controllers\PostCatelogueController;
use App\Http\Controllers\Backend\PromotionController;

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
    Route::get("/dashboard",[DashBoardController::class,"index"])->name("admin.dashboard");
    Route::get("/logout",[AuthController::class,"logout"])->name("logout");
    Route::get("/showMessage",function(){
        return view("auths.showMessage");
    })->name("showMessage");
    Route::prefix('users')->group(function(){
        Route::get("list",[UserController::class,"listGroupMember"])->name("admin.users");
        Route::put("list/change_status",[UserController::class,"updateUserStatus"])->name("admin.users.user_status");
        Route::get("create",[UserController::class,"create"])->name("admin.users.create");
        Route::post("store",[UserController::class,"store"])->name("admin.users.store");
        Route::get("edit/{id}",[UserController::class,"editUser"])->name("admin.users.edit");
        Route::put("update/{id}",[UserController::class,'updateUser'])->name("admin.users.update");
        Route::delete("delete",[UserController::class,'deleteUser'])->name("admin.users.delete");
    });
    Route::prefix("user_catelogue")->group(function(){
        Route::get("list",[UserCatelogueController::class,"listGroupMember"])->name("admin.user_catelogue");
        Route::get("create",[UserCatelogueController::class,"create"])->name("admin.user_catelogue.create");
        Route::post("user_catelogueStore",[UserCatelogueController::class,"store"])->name("admin.user_catelogue.store");
        Route::get("{id}/edit",[UserCatelogueController::class,"edit"])->name("admin.user_catelogue.edit");
        Route::put("{id}/update",[UserCatelogueController::class,"UserCatelogueUpdate"])->name("admin.user_catelogue.update");
        Route::delete("/delete",[UserCatelogueController::class,"UserCatelogueDelete"])->name("admin.user_catelogue.delete");
    });
    Route::prefix("post-catelogue")->group(function(){
        Route::get("list",[PostCatelogueController::class,"index"])->name("admin.post-catelogue");
        Route::get("create",[PostCatelogueController::class,"create"])->name("admin.post-catelogue.create");
        Route::post("post-catelogueStore",[PostCatelogueController::class,"store"])->name("admin.post-catelogue.store");
        Route::get("{id}/edit",[PostCatelogueController::class,"editPostCatelogue"])->name("admin.post-catelogue.edit");
        Route::put("{id}/update",[PostCatelogueController::class,"PostCatelogueUpdate"])->name("admin.post-catelogue.update");
        Route::delete("/delete",[PostCatelogueController::class,"PostCatelogueDelete"])->name("admin.post-catelogue.delete");
    });
    Route::prefix("post")->group(function(){
        Route::get("list",[PostController::class,"index"])->name("admin.post");
        Route::get("create",[PostController::class,"create"])->name("admin.post.create");
        Route::post("postStore",[PostController::class,"store"])->name("admin.post.store");
        Route::get("{id}/edit",[PostController::class,"editPost"])->name("admin.post.edit");
        Route::put("{id}/update",[PostController::class,"update"])->name("admin.post.update");
        Route::delete("/delete",[PostController::class,"destroy"])->name("admin.post.delete");
    });
    Route::prefix("product")->group(function(){
        Route::get("list",[ProductController::class,"index"])->name("admin.product");
        Route::get("create",[ProductController::class,"create"])->name("admin.product.create");
        Route::post("postStore",[ProductController::class,"store"])->name("admin.product.store");
        Route::get("{id}/edit",[ProductController::class,"editPost"])->name("admin.product.edit");
        Route::put("{id}/update",[ProductController::class,"update"])->name("admin.product.update");
        Route::delete("/delete",[ProductController::class,"destroy"])->name("admin.product.delete");
    });
    Route::prefix("product-catelogue")->group(function(){
        Route::get("list",[ProductCatelogueController::class,"index"])->name("admin.product_catelogue");
        Route::get("create",[ProductCatelogueController::class,"create"])->name("admin.product_catelogue.create");
        Route::post("postStore",[ProductCatelogueController::class,"store"])->name("admin.product_catelogue.store");
        Route::get("{id}/edit",[ProductCatelogueController::class,"edit"])->name("admin.product_catelogue.edit");
        Route::put("{id}/update",[ProductCatelogueController::class,"update"])->name("admin.product_catelogue.update");
        Route::delete("/delete",[ProductCatelogueController::class,"destroy"])->name("admin.product_catelogue.delete");
    });
    Route::prefix("variant-catelogue")->group(function(){
        Route::get("list",[AttributeController::class,"index"])->name("admin.variant_catelogue");
        Route::get("create",[AttributeController::class,"create"])->name("admin.variant_catelogue.create");
        Route::post("postStore",[AttributeController::class,"store"])->name("admin.variant_catelogue.store");
        Route::get("{id}/edit",[AttributeController::class,"edit"])->name("admin.variant_catelogue.edit");
        Route::put("{id}/update",[AttributeController::class,"update"])->name("admin.variant_catelogue.update");
        Route::delete("/delete",[AttributeController::class,"destroy"])->name("admin.variant_catelogue..delete");
    });
    Route::prefix("variant")->group(function(){
        Route::get("list",[AttributeValueController::class,"index"])->name("admin.variant");
        Route::get("create",[AttributeValueController::class,"create"])->name("admin.variant.create");
        Route::post("postStore",[AttributeValueController::class,"store"])->name("admin.variant.store");
        Route::get("{id}/edit",[AttributeValueController::class,"edit"])->name("admin.variant.edit");
        Route::put("{id}/update",[AttributeValueController::class,"update"])->name("admin.variant.update");
        Route::delete("/delete",[AttributeValueController::class,"destroy"])->name("admin.variant.delete");
    });
    Route::prefix("payment_methods")->group(function(){
        Route::get("list",[PaymentMethodsController::class,"index"])->name("admin.payment_methods");
        Route::get("create",[PaymentMethodsController::class,"create"])->name("admin.payment_methods.create");
        Route::post("postStore",[PaymentMethodsController::class,"store"])->name("admin.payment_methods.store");
        Route::get("{id}/edit",[PaymentMethodsController::class,"edit"])->name("admin.payment_methods.edit");
        Route::put("{id}/update",[PaymentMethodsController::class,"update"])->name("admin.payment_methods.update");
        Route::delete('payment_methods/{id}', [PaymentMethodsController::class, 'destroy'])->name('admin.payment_methods.delete');
    });
    Route::prefix('promotions')->group(function () {
        Route::get('/', [PromotionController::class, 'listPromotions'])->name('admin.promotions'); 
        Route::get('/create', [PromotionController::class, 'create'])->name('admin.promotions.create'); 
        Route::post('/store', [PromotionController::class, 'store'])->name('admin.promotions.store');
        Route::get('/{id}/edit', [PromotionController::class, 'edit'])->name('admin.promotions.edit'); 
        Route::put('/{id}/update', [PromotionController::class, 'update'])->name('admin.promotions.update');
        Route::delete('/{id}', [PromotionController::class, 'deletePromotion'])->name('admin.promotions.delete');
    });
    Route::prefix("about")->group(function() {
        Route::get("list", [AboutPageController::class, "index"])->name("admin.about");
        Route::get("create", [AboutPageController::class, "create"])->name("admin.about.create");
        Route::post('/store', [AboutPageController::class, 'store'])->name('admin.about.store');
        Route::get("{id}/edit", [AboutPageController::class, "edit"])->name("admin.about.edit");
        Route::put("{id}/update", [AboutPageController::class, "update"])->name("admin.about.update");
        Route::delete('/about/{id}', [AboutPageController::class, 'destroy'])->name('admin.about.delete');
    });
    
   
    Route::prefix("product_comment")->group(function(){
        Route::get("users", [ProductCommentController::class, "index"])->name("admin.product_comment.users");
        Route::get("user/{id}/comments", [ProductCommentController::class, "userComments"])->name("admin.product_comment.user_comments");
        Route::delete("/soft-delete", [ProductCommentController::class, "softDelete"])->name("admin.product_comment.soft_delete");//xóa mềm
        Route::post("{id}/restore", [ProductCommentController::class, "restore"])->name("admin.product_comment.restore");//khôi phục
        Route::delete("{id}/hard-delete", [ProductCommentController::class, "destroy"])->name("admin.product_comment.hard_delete");//xóa cúng
        Route::get("trash", [ProductCommentController::class, "trash"])->name("admin.product_comment.trash"); // Trang thùng rác
    });
    Route::prefix("product_reviews")->group(function(){
        Route::get('admin/product-reviews', [ProductReviewController::class, 'index'])->name('admin.product_review');
    });
    Route::prefix("brand")->group(function(){
        Route::get("list",[BrandController::class,"index"])->name("admin.brand");
        Route::get("create",[BrandController::class,"create"])->name("admin.brand.create");
        Route::post("postStore",[BrandController::class,"store"])->name("admin.brand.store");
        Route::get("{id}/edit",[BrandController::class,"edit"])->name("admin.brand.edit");
        Route::put("{id}/update",[BrandController::class,"update"])->name("admin.brand.update");
        Route::delete("/delete",[BrandController::class,"destroy"])->name("admin.brand.delete");
    });
    Route::prefix("contact")->group(function(){
        Route::get("list",[ContactController::class,"index"])->name("admin.contact");
        Route::get("create",[ContactController::class,"create"])->name("admin.contact.create");
        Route::post("postStore",[ContactController::class,"store"])->name("admin.contact.store");
        Route::get("{id}/edit",[ContactController::class,"edit"])->name("admin.contact.edit");
        Route::put("{id}/update",[ContactController::class,"update"])->name("admin.contact.update");
        Route::delete("/delete",[ContactController::class,"destroy"])->name("admin.contact.delete");
    });
    Route::prefix("information")->group(function(){
        Route::get("list",[InformationController::class,"index"])->name("admin.information");
        Route::get("create",[InformationController::class,"create"])->name("admin.information.create");
        Route::post("postStore",[InformationController::class,"store"])->name("admin.information.store");
        Route::get("{id}/edit",[InformationController::class,"edit"])->name("admin.information.edit");
        Route::put("{id}/update",[InformationController::class,"update"])->name("admin.information.update");
        Route::delete("/delete",[InformationController::class,"destroy"])->name("admin.information.delete");
    });
});
                    
Route::get("/",function(){
    return redirect()->route("admin.dashboard");
});
Route::get("ajax/getLocaion/index",[GetLocaitonAjax::class,"index"])->name("ajax.getLocation");
Route::put("ajax/change_status",[ChangeStatusAjax::class,"change_status"])->name("ajax.changeStatus");