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
use App\Http\Controllers\backend\CustomerController;
use App\Http\Controllers\backend\DashBoardController;
use App\Http\Controllers\backend\GroupPermissionController;
use App\Http\Controllers\backend\InformationController;
use App\Http\Controllers\backend\PostController;
use App\Http\Controllers\backend\ProductCatelogueController;

use App\Http\Controllers\backend\ProductController;
use App\Http\Controllers\backend\ProductReviewController;
use App\Http\Controllers\Backend\UserCatelogueController;
use App\Http\Controllers\Backend\UserController;



use App\Http\Controllers\backend\ShippingFeeController;

use App\Http\Controllers\PaymentMethodsController;


use App\Http\Controllers\PostCatelogueController;
use App\Http\Controllers\Backend\PromotionController;
use App\Http\Controllers\backend\PermissionController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\OrderController;

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

Route::middleware("guest")->prefix("/")->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('auth/google', 'redirectToGoogle')->name('auth.google');
        Route::get('auth/google/callback', 'handleGoogleCallback');
        Route::get("/login", "showLogin")->name("showLogin");
        Route::get("/register", "showRegister")->name("showRegister");
        Route::post("/login/store", "login")->name("login");
        Route::post("/login/register", "register")->name("register");
        Route::get("/confirm_email", "showConfirmEmail")->name("showConfirmEmail");
        Route::post("/confirm_email", "sendResetLinkEmail")->name("confirmEmail");
        Route::post("/create-password", "createPassword")->name("createPassword");
    });
});

Route::get('/password/reset/{token}', function (string $token) {
    return view('auths.reset_password', ['token' => $token]);
})->middleware('guest')->name('password.reset');

Route::middleware("auth")->prefix("/admin")->group(function () {
    Route::get("/dashboard", [DashBoardController::class, "index"])->name("admin.dashboard");
    Route::get("/logout", [AuthController::class, "logout"])->name("logout");
    Route::get("/showMessage", function () {
        return view("auths.showMessage");
    })->name("showMessage");
    Route::prefix('users')->middleware('checkRole:admin')->group(function () {
        Route::get("list", [UserController::class, "listGroupMember"])->name("admin.users")->middleware('checkPermission:viewUser');
        Route::put("list/change_status", [UserController::class, "updateUserStatus"])->name("admin.users.user_status")->middleware('checkPermission:updateUserStatus');
        Route::get("create", [UserController::class, "create"])->name("admin.users.create")->middleware('checkPermission:createUser');
        Route::post("store", [UserController::class, "store"])->name("admin.users.store")->middleware('checkPermission:storeUser');
        Route::get("edit/{id}", [UserController::class, "editUser"])->name("admin.users.edit")->middleware('checkPermission:editUser');
        Route::put("update/{id}", [UserController::class, 'updateUser'])->name("admin.users.update")->middleware('checkPermission:updateUser');
        Route::delete("delete", [UserController::class, 'deleteUser'])->name("admin.users.delete")->middleware('checkPermission:deleteUser');
    });
    Route::prefix("user_catelogue")->middleware('checkRole:admin')->group(function () {
        Route::get("list", [UserCatelogueController::class, "listGroupMember"])->name("admin.user_catelogue")->middleware('checkPermission:viewUserCatelogue');
        Route::get("create", [UserCatelogueController::class, "create"])->name("admin.user_catelogue.create")->middleware('checkPermission:createUserCatelogue');
        Route::post("user_catelogueStore", [UserCatelogueController::class, "store"])->name("admin.user_catelogue.store")->middleware('checkPermission:storeUserCatelogue');
        Route::get("{id}/edit", [UserCatelogueController::class, "edit"])->name("admin.user_catelogue.edit")->middleware('checkPermission:editUserCatelogue');
        Route::put("{id}/update", [UserCatelogueController::class, "UserCatelogueUpdate"])->name("admin.user_catelogue.update")->middleware('checkPermission:updateUserCatelogue');
        Route::delete("/delete", [UserCatelogueController::class, "UserCatelogueDelete"])->name("admin.user_catelogue.delete")->middleware('checkPermission:deleteUserCatelogue');
    });
    Route::prefix("post_catelogue")->middleware('checkRole:admin')->group(function () {
        Route::get("list", [PostCatelogueController::class, "index"])->name("admin.post-catelogue")->middleware('checkPermission:viewPostCatelogue');
        Route::get("create", [PostCatelogueController::class, "create"])->name("admin.post-catelogue.create")->middleware('checkPermission:createPostCatelogue');
        Route::post("post-catelogueStore", [PostCatelogueController::class, "store"])->name("admin.post-catelogue.store")->middleware('checkPermission:storePostCatelogue');
        Route::get("{id}/edit", [PostCatelogueController::class, "editPostCatelogue"])->name("admin.post-catelogue.edit")->middleware('checkPermission:editPostCatelogue');
        Route::put("{id}/update", [PostCatelogueController::class, "PostCatelogueUpdate"])->name("admin.post-catelogue.update")->middleware('checkPermission:updatePostCatelogue');
        Route::delete("/delete", [PostCatelogueController::class, "PostCatelogueDelete"])->name("admin.post-catelogue.delete")->middleware('checkPermission:deletePostCatelogue');
    });
    Route::prefix("post")->middleware('checkRole:admin')->group(function () {
        Route::get("list", [PostController::class, "index"])->name("admin.post")->middleware('checkPermission:viewPost');
        Route::get("create", [PostController::class, "create"])->name("admin.post.create")->middleware('checkPermission:createPost');
        Route::post("postStore", [PostController::class, "store"])->name("admin.post.store")->middleware('checkPermission:storePost');
        Route::get("{id}/edit", [PostController::class, "editPost"])->name("admin.post.edit")->middleware('checkPermission:editPost');
        Route::put("{id}/update", [PostController::class, "update"])->name("admin.post.update")->middleware('checkPermission:updatePost');
        Route::delete("/delete", [PostController::class, "destroy"])->name("admin.post.delete")->middleware('checkPermission:deletePost');
    });
    Route::prefix("product")->middleware('checkRole:admin')->group(function () {
        Route::get("list", [ProductController::class, "index"])->name("admin.product")->middleware('checkPermission:viewProduct');
        Route::get("create", [ProductController::class, "create"])->name("admin.product.create")->middleware('checkPermission:createProduct');
        Route::post("postStore", [ProductController::class, "store"])->name("admin.product.store")->middleware('checkPermission:storeProduct');
        Route::get("{id}/edit", [ProductController::class, "editPost"])->name("admin.product.edit")->middleware('checkPermission:editProduct');
        Route::put("{id}/update", [ProductController::class, "update"])->name("admin.product.update")->middleware('checkPermission:updateProduct');
        Route::delete("/delete", [ProductController::class, "destroy"])->name("admin.product.delete")->middleware('checkPermission:deleteProduct');
    });
    //
    Route::prefix("order")->middleware('checkRole:admin')->group(function () {
        Route::get("list", [OrderController::class, "index"])->name("admin.orders")->middleware('checkPermission:viewOrder');
        Route::get("create", [OrderController::class, "create"])->name("admin.orders.create")->middleware('checkPermission:createOrder');
        Route::post("store", [OrderController::class, "store"])->name("admin.orders.store")->middleware('checkPermission:storeOrder');
        Route::get("{id}/edit", [OrderController::class, "editPost"])->name("admin.orders.edit")->middleware('checkPermission:editOrder');
        Route::put("update-order-status", [OrderController::class, "update"])->name("admin.orders.update")->middleware('checkPermission:updateOrder');
        Route::delete("/delete", [OrderController::class, "destroy"])->name("admin.orders.delete")->middleware('checkPermission:deleteOrder');
        Route::get("details/{id}", [OrderController::class, "show"])->name("admin.orders.details")->middleware('checkPermission:viewOrderDetails');
        Route::get('{id}/export-pdf', [OrderController::class, 'exportPdf'])->name("admin.orders.exportPdf")->middleware('checkPermission:exportOrderPdf');
    });
    Route::prefix("product_catelogue")->middleware('checkRole:admin')->group(function () {
        Route::get("list", [ProductCatelogueController::class, "index"])->name("admin.product_catelogue")->middleware('checkPermission:viewProductCatelogue');
        Route::get("create", [ProductCatelogueController::class, "create"])->name("admin.product_catelogue.create")->middleware('checkPermission:createProductCatelogue');
        Route::post("postStore", [ProductCatelogueController::class, "store"])->name("admin.product_catelogue.store")->middleware('checkPermission:storeProductCatelogue');
        Route::get("{id}/edit", [ProductCatelogueController::class, "edit"])->name("admin.product_catelogue.edit")->middleware('checkPermission:editProductCatelogue');
        Route::put("{id}/update", [ProductCatelogueController::class, "update"])->name("admin.product_catelogue.update")->middleware('checkPermission:updateProductCatelogue');
        Route::delete("/delete", [ProductCatelogueController::class, "destroy"])->name("admin.product_catelogue.delete")->middleware('checkPermission:deleteProductCatelogue');
    });
    Route::prefix("variant_catelogue")->middleware('checkRole:admin')->group(function () {
        Route::get("list", [AttributeController::class, "index"])->name("admin.variant_catelogue")->middleware('checkPermission:viewVariantCatelogue');
        Route::get("create", [AttributeController::class, "create"])->name("admin.variant_catelogue.create")->middleware('checkPermission:createVariantCatelogue');
        Route::post("postStore", [AttributeController::class, "store"])->name("admin.variant_catelogue.store")->middleware('checkPermission:storeVariantCatelogue');
        Route::get("{id}/edit", [AttributeController::class, "edit"])->name("admin.variant_catelogue.edit")->middleware('checkPermission:editVariantCatelogue');
        Route::put("{id}/update", [AttributeController::class, "update"])->name("admin.variant_catelogue.update")->middleware('checkPermission:updateVariantCatelogue');
        Route::delete("/delete", [AttributeController::class, "destroy"])->name("admin.variant_catelogue.delete")->middleware('checkPermission:deleteVariantCatelogue');
    });
    Route::prefix("variant")->middleware('checkRole:admin')->group(function () {
        Route::get("list", [AttributeValueController::class, "index"])->name("admin.variant")->middleware('checkPermission:viewAttributeValue');
        Route::get("create", [AttributeValueController::class, "create"])->name("admin.variant.create")->middleware('checkPermission:createAttributeValue');
        Route::post("postStore", [AttributeValueController::class, "store"])->name("admin.variant.store")->middleware('checkPermission:storeAttributeValue');
        Route::get("{id}/edit", [AttributeValueController::class, "edit"])->name("admin.variant.edit")->middleware('checkPermission:editAttributeValue');
        Route::put("{id}/update", [AttributeValueController::class, "update"])->name("admin.variant.update")->middleware('checkPermission:updateAttributeValue');
        Route::delete("/delete", [AttributeValueController::class, "destroy"])->name("admin.variant.delete")->middleware('checkPermission:deleteAttributeValue');
    });
    Route::prefix("payment_method")->middleware('checkRole:admin')->group(function () {
        Route::get("list", [PaymentMethodsController::class, "index"])->name("admin.payment_methods")->middleware('checkPermission:viewPaymentMethod');
        Route::get("create", [PaymentMethodsController::class, "create"])->name("admin.payment_methods.create")->middleware('checkPermission:createPaymentMethod');
        Route::post("postStore", [PaymentMethodsController::class, "store"])->name("admin.payment_methods.store")->middleware('checkPermission:storePaymentMethod');
        Route::get("{id}/edit", [PaymentMethodsController::class, "edit"])->name("admin.payment_methods.edit")->middleware('checkPermission:editPaymentMethod');
        Route::put("{id}/update", [PaymentMethodsController::class, "update"])->name("admin.payment_methods.update")->middleware('checkPermission:updatePaymentMethod');
        Route::delete('{id}', [PaymentMethodsController::class, 'destroy'])->name('admin.payment_methods.delete')->middleware('checkPermission:deletePaymentMethod');
    });
    Route::prefix('promotion')->middleware('checkRole:admin')->group(function () {
        Route::get('/', [PromotionController::class, 'listPromotions'])->name('admin.promotions')->middleware('checkPermission:viewPromotion');
        Route::get('/create', [PromotionController::class, 'create'])->name('admin.promotions.create')->middleware('checkPermission:createPromotion');
        Route::post('/store', [PromotionController::class, 'store'])->name('admin.promotions.store')->middleware('checkPermission:storePromotion');
        Route::get('/{id}/edit', [PromotionController::class, 'edit'])->name('admin.promotions.edit')->middleware('checkPermission:editPromotion');
        Route::put('/{id}/update', [PromotionController::class, 'update'])->name('admin.promotions.update')->middleware('checkPermission:updatePromotion');
        Route::delete('/{id}', [PromotionController::class, 'deletePromotion'])->name('admin.promotions.delete')->middleware('checkPermission:deletePromotion');
        Route::get('/promotion-statistics', [PromotionController::class, 'getPromotionStatistics'])->name('admin.promotion.statistics')->middleware('checkPermission:viewPromotionStatistics');
    });
    Route::prefix("about")->middleware('checkRole:admin')->group(function () {
        Route::get("list", [AboutPageController::class, "index"])->name("admin.about")->middleware('checkPermission:viewAboutPage');
        Route::get("create", [AboutPageController::class, "create"])->name("admin.about.create")->middleware('checkPermission:createAboutPage');
        Route::post('/store', [AboutPageController::class, 'store'])->name('admin.about.store')->middleware('checkPermission:storeAboutPage');
        Route::get("{id}/edit", [AboutPageController::class, "edit"])->name("admin.about.edit")->middleware('checkPermission:editAboutPage');
        Route::put("{id}/update", [AboutPageController::class, "update"])->name("admin.about.update")->middleware('checkPermission:updateAboutPage');
        Route::delete('/about/{id}', [AboutPageController::class, 'destroy'])->name('admin.about.delete')->middleware('checkPermission:deleteAboutPage');
    });

    Route::prefix("product_review")->middleware('checkRole:admin')->group(function () {
        Route::get('admin/product-reviews', [ProductReviewController::class, 'index'])->name('admin.product_review')->middleware('checkPermission:viewProductReviews');
        Route::get("user/{id}/reviews", [ProductReviewController::class, "userReviews"])->name("admin.product_review.user_reviews")->middleware('checkPermission:viewUserReviews');
    });
    Route::prefix("brand")->middleware('checkRole:admin')->group(function () {
        Route::get("list", [BrandController::class, "index"])->name("admin.brand")->middleware('checkPermission:viewBrand');
        Route::get("create", [BrandController::class, "create"])->name("admin.brand.create")->middleware('checkPermission:createBrand');
        Route::post("postStore", [BrandController::class, "store"])->name("admin.brand.store")->middleware('checkPermission:storeBrand');
        Route::get("{id}/edit", [BrandController::class, "edit"])->name("admin.brand.edit")->middleware('checkPermission:editBrand');
        Route::put("{id}/update", [BrandController::class, "update"])->name("admin.brand.update")->middleware('checkPermission:updateBrand');
        Route::delete("/delete", [BrandController::class, "destroy"])->name("admin.brand.delete")->middleware('checkPermission:deleteBrand');
        Route::delete("/force-delete", [BrandController::class, "force_destroy"])->name("admin.brand.force_delete")->middleware('checkPermission:forceDeleteBrand');
        Route::post("{id}/restore", [BrandController::class, "restore"])->name("admin.brand.restore")->middleware('checkPermission:restoreBrand');
        Route::get("/trash", [BrandController::class, "trash"])->name("admin.brand.trash")->middleware('checkPermission:viewTrashBrand');
    });
    Route::prefix("contact")->middleware('checkRole:admin')->group(function () {
        Route::get("list", [ContactController::class, "index"])->name("admin.contact")->middleware('checkPermission:viewContact');
        // Route::get("create",[ContactController::class,"create"])->name("admin.contact.create")->middleware('checkPermission:createContact');
        // Route::post("postStore",[ContactController::class,"store"])->name("admin.contact.store")->middleware('checkPermission:storeContact');
        Route::get("{id}/edit", [ContactController::class, "edit"])->name("admin.contact.edit")->middleware('checkPermission:editContact');
        Route::put("{id}/update", [ContactController::class, "update"])->name("admin.contact.update")->middleware('checkPermission:updateContact');
        // Route::delete("/delete",[ContactController::class,"destroy"])->name("admin.contact.delete")->middleware('checkPermission:deleteContact');
    });
    Route::prefix("information")->middleware('checkRole:admin')->group(function () {
        Route::get("list", [InformationController::class, "index"])->name("admin.information")->middleware('checkPermission:viewInformation');
        Route::get("create", [InformationController::class, "create"])->name("admin.information.create")->middleware('checkPermission:createInformation');
        Route::post("postStore", [InformationController::class, "store"])->name("admin.information.store")->middleware('checkPermission:storeInformation');
        Route::get("{id}/edit", [InformationController::class, "edit"])->name("admin.information.edit")->middleware('checkPermission:editInformation');
        Route::put("{id}/update", [InformationController::class, "update"])->name("admin.information.update")->middleware('checkPermission:updateInformation');
        Route::delete("/delete", [InformationController::class, "destroy"])->name("admin.information.delete")->middleware('checkPermission:deleteInformation');
    });
    Route::prefix("shipping_fee")->middleware('checkRole:admin')->group(function () {
        Route::get("list", [ShippingFeeController::class, "index"])->name("admin.shipping_fee")->middleware('checkPermission:viewShippingFee');
        Route::get("create", [ShippingFeeController::class, "create"])->name("admin.shipping_fee.create")->middleware('checkPermission:createShippingFee');
        Route::post("postStore", [ShippingFeeController::class, "store"])->name("admin.shipping_fee.store")->middleware('checkPermission:storeShippingFee');
        Route::get("{id}/edit", [ShippingFeeController::class, "edit"])->name("admin.shipping_fee.edit")->middleware('checkPermission:editShippingFee');
        Route::put("{id}/update", [ShippingFeeController::class, "update"])->name("admin.shipping_fee.update")->middleware('checkPermission:updateShippingFee');
        Route::delete("/delete", [ShippingFeeController::class, "destroy"])->name("admin.shipping_fee.delete")->middleware('checkPermission:deleteShippingFee');
        Route::delete("/force-delete", [ShippingFeeController::class, "force_destroy"])->name("admin.shipping_fee.force_delete")->middleware('checkPermission:forceDeleteShippingFee');
        Route::post("{id}/restore", [ShippingFeeController::class, "restore"])->name("admin.shipping_fee.restore")->middleware('checkPermission:restoreShippingFee'); //khôi phục
        Route::get("/trash", [ShippingFeeController::class, "trash"])->name("admin.shipping_fee.trash")->middleware('checkPermission:trashShippingFee'); // Trang thùng rác
    });
    Route::prefix("customer")->middleware('checkRole:admin')->group(function () {
        Route::get("list", [CustomerController::class, "index"])->name("admin.customer")->middleware('checkPermission:viewCustomer');
        Route::get("create", [CustomerController::class, "create"])->name("admin.customer.create")->middleware('checkPermission:createCustomer');
        Route::post("postStore", [CustomerController::class, "store"])->name("admin.customer.store")->middleware('checkPermission:storeCustomer');
        Route::get("{id}/show", [CustomerController::class, "show"])->name("admin.customer.show")->middleware('checkPermission:viewCustomerDetail');
        Route::get("{id}/edit", [CustomerController::class, "edit"])->name("admin.customer.edit")->middleware('checkPermission:editCustomer');
        Route::put("{id}/update", [CustomerController::class, "update"])->name("admin.customer.update")->middleware('checkPermission:updateCustomer');
        Route::delete("/delete", [CustomerController::class, "destroy"])->name("admin.customer.delete")->middleware('checkPermission:deleteCustomer');
    });
    Route::prefix("group_permission")->middleware('checkRole:admin')->group(function () {
        Route::get("list", [GroupPermissionController::class, "index"])->name("admin.group_permission")->middleware('checkPermission:viewGroupPermission');
        Route::get("create", [GroupPermissionController::class, "create"])->name("admin.group_permission.create")->middleware('checkPermission:createGroupPermission');
        Route::post("postStore", [GroupPermissionController::class, "store"])->name("admin.group_permission.store")->middleware('checkPermission:storeGroupPermission');
        Route::get("{id}/edit", [GroupPermissionController::class, "edit"])->name("admin.group_permission.edit")->middleware('checkPermission:editGroupPermission');
        Route::put("{id}/update", [GroupPermissionController::class, "update"])->name("admin.group_permission.update")->middleware('checkPermission:updateGroupPermission');
        Route::delete("/delete", [GroupPermissionController::class, "destroy"])->name("admin.group_permission.delete")->middleware('checkPermission:deleteGroupPermission');
        Route::delete("/force-delete", [GroupPermissionController::class, "force_destroy"])->name("admin.group_permission.force_delete")->middleware('checkPermission:forceDeleteGroupPermission');
        Route::post("{id}/restore", [GroupPermissionController::class, "restore"])->name("admin.group_permission.restore")->middleware('checkPermission:restoreGroupPermission'); //khôi phục
        Route::get("/trash", [GroupPermissionController::class, "trash"])->name("admin.group_permission.trash")->middleware('checkPermission:viewGroupPermissionTrash'); // Trang thùng rác
    });
    Route::prefix("permission")->middleware('checkRole:admin')->group(function () {
        Route::get("list", [PermissionController::class, "index"])->name("admin.permission")->middleware('checkPermission:viewPermission');
        Route::get("create", [PermissionController::class, "create"])->name("admin.permission.create")->middleware('checkPermission:createPermission');
        Route::post("postStore", [PermissionController::class, "store"])->name("admin.permission.store")->middleware('checkPermission:storePermission');
        Route::get("{id}/edit", [PermissionController::class, "edit"])->name("admin.permission.edit")->middleware('checkPermission:editPermission');
        Route::put("{id}/update", [PermissionController::class, "update"])->name("admin.permission.update")->middleware('checkPermission:updatePermission');
        Route::delete("/delete", [PermissionController::class, "destroy"])->name("admin.permission.delete")->middleware('checkPermission:deletePermission');
        Route::delete("/force-delete", [PermissionController::class, "force_destroy"])->name("admin.permission.force_delete")->middleware('checkPermission:forceDeletePermission');
        Route::post("{id}/restore", [PermissionController::class, "restore"])->name("admin.permission.restore")->middleware('checkPermission:restorePermission'); //khôi phục
        Route::get("/trash", [PermissionController::class, "trash"])->name("admin.permission.trash")->middleware('checkPermission:viewPermissionTrash'); // Trang thùng rác
    });
    Route::prefix("role")->middleware('checkRole:admin')->group(function () {
        Route::get("list", [RoleController::class, "index"])->name("admin.role")->middleware('checkPermission:viewRole');
        Route::get("create", [RoleController::class, "create"])->name("admin.role.create")->middleware('checkPermission:createRole');
        Route::post("postStore", [RoleController::class, "store"])->name("admin.role.store")->middleware('checkPermission:storeRole');
        Route::get("{id}/show", [RoleController::class, "show"])->name("admin.role.show")->middleware('checkPermission:showRole');
        Route::get("{id}/edit", [RoleController::class, "edit"])->name("admin.role.edit")->middleware('checkPermission:editRole');
        Route::put("{id}/update", [RoleController::class, "update"])->name("admin.role.update")->middleware('checkPermission:updateRole');
        Route::delete("/delete", [RoleController::class, "destroy"])->name("admin.role.delete")->middleware('checkPermission:deleteRole');
        Route::delete("/force-delete", [RoleController::class, "force_destroy"])->name("admin.role.force_delete")->middleware('checkPermission:forceDeleteRole');
        Route::post("{id}/restore", [RoleController::class, "restore"])->name("admin.role.restore")->middleware('checkPermission:restoreRole'); //khôi phục
        Route::get("/trash", [RoleController::class, "trash"])->name("admin.role.trash")->middleware('checkPermission:viewRoleTrash'); // Trang thùng rác
    });

    Route::prefix("/dashboard")->middleware('checkRole:admin')->group(function () {
        Route::get("list", [DashBoardController::class, "Orderindex"])->name("admin.dashboard_order")->middleware('checkPermission:viewDashboardOrder');
        Route::get('/orders/filter', [DashBoardController::class, 'filterSalesData'])->name('orders.filter')->middleware('checkPermission:filterSalesData');
        Route::get('/orders/select', [DashBoardController::class, 'selectSalesData'])->name('orders.select')->middleware('checkPermission:selectSalesData');
        Route::get('/orders/status/select', [DashBoardController::class, 'selectOrderStatusData'])->name('orders_status.select')->middleware('checkPermission:selectOrderStatusData');
    });
});

Route::get("/", function () {
    return redirect()->route("admin.dashboard");
});
Route::get("ajax/getLocaion/index", [GetLocaitonAjax::class, "index"])->name("ajax.getLocation");
Route::put("ajax/change_status", [ChangeStatusAjax::class, "change_status"])->name("ajax.changeStatus");
Route::get('/invoice', function () {
    return view('pdf.order_invoice.invoice'); // 'invoice' là tên file view của bạn
});
