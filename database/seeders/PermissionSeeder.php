<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            ['id' => 1,'name' => 'viewUser', 'display_name' => 'Xem người dùng', 'description' => 'Quyền xem thông tin người dùng', 'group_permission_id' => 1, 'created_at' => now(), 'status' => 1],
            ['id'=>2,'name' => 'storeUser', 'display_name' => 'Lưu người dùng', 'description' => 'Quyền lưu thông tin người dùng', 'group_permission_id' => 1, 'created_at' => now(), 'status' => 1],
            ['id'=>3,'name' => 'createUser', 'display_name' => 'Tạo người dùng', 'description' => 'Quyền tạo người dùng mới', 'group_permission_id' => 1, 'created_at' => now(), 'status' => 1],
            ['id'=>4,'name' => 'editUser', 'display_name' => 'Chỉnh sửa người dùng', 'description' => 'Quyền chỉnh sửa thông tin người dùng', 'group_permission_id' => 1, 'created_at' => now(), 'status' => 1],
            ['id'=>5,'name' => 'updateUser', 'display_name' => 'Cập nhật người dùng', 'description' => 'Quyền cập nhật thông tin người dùng', 'group_permission_id' => 1, 'created_at' => now(), 'status' => 1],
            ['id'=>6,'name' => 'deleteUser', 'display_name' => 'Xóa người dùng', 'description' => 'Quyền xóa người dùng', 'group_permission_id' => 1, 'created_at' => now(), 'status' => 1],
            ['id'=>7,'name' => 'viewUserCatelogue', 'display_name' => 'Xem danh mục người dùng', 'description' => 'Quyền xem danh mục người dùng', 'group_permission_id' => 2, 'created_at' => now(), 'status' => 1],
            ['id'=>8,'name' => 'createUserCatelogue', 'display_name' => 'Tạo danh mục người dùng', 'description' => 'Quyền tạo danh mục người dùng', 'group_permission_id' => 2, 'created_at' => now(), 'status' => 1],
            ['id'=>9,'name' => 'storeUserCatelogue', 'display_name' => 'Lưu danh mục người dùng', 'description' => 'Quyền lưu danh mục người dùng', 'group_permission_id' => 2, 'created_at' => now(), 'status' => 1],
            ['id'=>10,'name' => 'editUserCatelogue', 'display_name' => 'Chỉnh sửa danh mục người dùng', 'description' => 'Quyền chỉnh sửa danh mục người dùng', 'group_permission_id' => 2, 'created_at' => now(), 'status' => 1],
            ['id'=>11,'name' => 'updateUserCatelogue', 'display_name' => 'Cập nhật danh mục người dùng', 'description' => 'Quyền cập nhật danh mục người dùng', 'group_permission_id' => 2, 'created_at' => now(), 'status' => 1],
            ['id'=>12,'name' => 'deleteUserCatelogue', 'display_name' => 'Xóa danh mục người dùng', 'description' => 'Quyền xóa danh mục người dùng', 'group_permission_id' => 2, 'created_at' => now(), 'status' => 1],
            ['id'=>13,'name' => 'viewPostCatelogue', 'display_name' => 'Xem danh mục bài viết', 'description' => 'Quyền xem danh mục bài viết', 'group_permission_id' => 3, 'created_at' => now(), 'status' => 1],
            ['id'=>14,'name' => 'createPostCatelogue', 'display_name' => 'Tạo danh mục bài viết', 'description' => 'Quyền tạo danh mục bài viết', 'group_permission_id' => 3, 'created_at' => now(), 'status' => 1],
            ['id'=>15,'name' => 'storePostCatelogue', 'display_name' => 'Lưu danh mục bài viết', 'description' => 'Quyền lưu danh mục bài viết', 'group_permission_id' => 3, 'created_at' => now(), 'status' => 1],
            ['id'=>16,'name' => 'editPostCatelogue', 'display_name' => 'Chỉnh sửa danh mục bài viết', 'description' => 'Quyền chỉnh sửa danh mục bài viết', 'group_permission_id' => 3, 'created_at' => now(), 'status' => 1],
            ['id'=>17,'name' => 'updatePostCatelogue', 'display_name' => 'Cập nhật danh mục bài viết', 'description' => 'Quyền cập nhật danh mục bài viết', 'group_permission_id' => 3, 'created_at' => now(), 'status' => 1],
            ['id'=>18,'name' => 'deletePostCatelogue', 'display_name' => 'Xóa danh mục bài viết', 'description' => 'Quyền xóa danh mục bài viết', 'group_permission_id' => 3, 'created_at' => now(), 'status' => 1],
            ['id'=>19,'name' => 'viewPost', 'display_name' => 'Xem bài viết', 'description' => 'Quyền xem bài viết', 'group_permission_id' => 4, 'created_at' => now(), 'status' => 1],
            ['id'=>20,'name' => 'createPost', 'display_name' => 'Tạo bài viết', 'description' => 'Quyền tạo bài viết', 'group_permission_id' => 4, 'created_at' => now(), 'status' => 1],
            ['id'=>21,'name' => 'storePost', 'display_name' => 'Lưu bài viết', 'description' => 'Quyền lưu bài viết', 'group_permission_id' => 4, 'created_at' => now(), 'status' => 1],
            ['id'=>22,'name' => 'editPost', 'display_name' => 'Chỉnh sửa bài viết', 'description' => 'Quyền chỉnh sửa bài viết', 'group_permission_id' => 4, 'created_at' => now(), 'status' => 1],
            ['id'=>23,'name' => 'updatePost', 'display_name' => 'Cập nhật bài viết', 'description' => 'Quyền cập nhật bài viết', 'group_permission_id' => 4, 'created_at' => now(), 'status' => 1],
            ['id'=>24,'name' => 'deletePost', 'display_name' => 'Xóa bài viết', 'description' => 'Quyền xóa bài viết', 'group_permission_id' => 4, 'created_at' => now(), 'status' => 1],
            ['id'=>25,'name' => 'viewProduct', 'display_name' => 'Xem sản phẩm', 'description' => 'Quyền xem sản phẩm', 'group_permission_id' => 5, 'created_at' => now(), 'status' => 1],
            ['id'=>26,'name' => 'createProduct', 'display_name' => 'Tạo sản phẩm', 'description' => 'Quyền tạo sản phẩm', 'group_permission_id' => 5, 'created_at' => now(), 'status' => 1],
            ['id'=>27,'name' => 'storeProduct', 'display_name' => 'Lưu sản phẩm', 'description' => 'Quyền lưu sản phẩm', 'group_permission_id' => 5, 'created_at' => now(), 'status' => 1],
            ['id'=>28,'name' => 'editProduct', 'display_name' => 'Chỉnh sửa sản phẩm', 'description' => 'Quyền chỉnh sửa sản phẩm', 'group_permission_id' => 5, 'created_at' => now(), 'status' => 1],
            ['id'=>29,'name' => 'updateUserStatus', 'display_name' => 'Cập nhật trạng thái người dùng', 'description' => 'Quyền cập nhật trạng thái người dùng', 'group_permission_id' => 1, 'created_at' => now(), 'status' => 1],
            ['id'=>30,'name' => 'updateProduct', 'display_name' => 'Cập nhật sản phẩm', 'description' => 'Quyền cập nhật sản phẩm', 'group_permission_id' => 5, 'created_at' => now(), 'status' => 1],
            ['id'=>31,'name' => 'deleteProduct', 'display_name' => 'Xóa sản phẩm', 'description' => 'Quyền xóa sản phẩm', 'group_permission_id' => 5, 'created_at' => now(), 'status' => 1],
            ['id'=>32,'name' => 'viewOrder', 'display_name' => 'Xem đơn hàng', 'description' => 'Quyền xem đơn hàng', 'group_permission_id' => 6, 'created_at' => now(), 'status' => 1],
            ['id'=>33,'name' => 'createOrder', 'display_name' => 'Tạo đơn hàng', 'description' => 'Quyền tạo đơn hàng', 'group_permission_id' => 6, 'created_at' => now(), 'status' => 1],
            ['id'=>34,'name' => 'storeOrder', 'display_name' => 'Lưu đơn hàng', 'description' => 'Quyền lưu đơn hàng', 'group_permission_id' => 6, 'created_at' => now(), 'status' => 1],
            ['id'=>35,'name' => 'editOrder', 'display_name' => 'Chỉnh sửa đơn hàng', 'description' => 'Quyền chỉnh sửa đơn hàng', 'group_permission_id' => 6, 'created_at' => now(), 'status' => 1],
            ['id'=>36,'name' => 'updateOrder', 'display_name' => 'Cập nhật đơn hàng', 'description' => 'Quyền cập nhật đơn hàng', 'group_permission_id' => 6, 'created_at' => now(), 'status' => 1],
            ['id'=>37,'name' => 'deleteOrder', 'display_name' => 'Xóa đơn hàng', 'description' => 'Quyền xóa đơn hàng', 'group_permission_id' => 6, 'created_at' => now(), 'status' => 1],
            ['id'=>38,'name' => 'viewOrderDetails', 'display_name' => 'Xem chi tiết đơn hàng', 'description' => 'Quyền xem chi tiết đơn hàng', 'group_permission_id' => 6, 'created_at' => now(), 'status' => 1],
            ['id'=>39,'name' => 'exportOrderPdf', 'display_name' => 'Xuất đơn hàng PDF', 'description' => 'Quyền xuất đơn hàng thành PDF', 'group_permission_id' => 6, 'created_at' => now(), 'status' => 1],
            ['id'=>40,'name' => 'viewProductCatelogue', 'display_name' => 'Xem danh mục sản phẩm', 'description' => 'Quyền xem danh mục sản phẩm', 'group_permission_id' => 7, 'created_at' => now(), 'status' => 1],
            ['id'=>41,'name' => 'createProductCatelogue', 'display_name' => 'Tạo danh mục sản phẩm', 'description' => 'Quyền tạo danh mục sản phẩm', 'group_permission_id' => 7, 'created_at' => now(), 'status' => 1],
            ['id'=>42,'name' => 'storeProductCatelogue', 'display_name' => 'Lưu danh mục sản phẩm', 'description' => 'Quyền lưu danh mục sản phẩm', 'group_permission_id' => 7, 'created_at' => now(), 'status' => 1],
            ['id'=>43,'name' => 'editProductCatelogue', 'display_name' => 'Chỉnh sửa danh mục sản phẩm', 'description' => 'Quyền chỉnh sửa danh mục sản phẩm', 'group_permission_id' => 7, 'created_at' => now(), 'status' => 1],
            ['id'=>44,'name' => 'updateProductCatelogue', 'display_name' => 'Cập nhật danh mục sản phẩm', 'description' => 'Quyền cập nhật danh mục sản phẩm', 'group_permission_id' => 7, 'created_at' => now(), 'status' => 1],
            ['id'=>45,'name' => 'deleteProductCatelogue', 'display_name' => 'Xóa danh mục sản phẩm', 'description' => 'Quyền xóa danh mục sản phẩm', 'group_permission_id' => 7, 'created_at' => now(), 'status' => 1],
            ['id'=>46,'name' => 'viewVariantCatelogue', 'display_name' => 'Xem danh mục thuộc tính', 'description' => 'Quyền xem danh mục thuộc tính', 'group_permission_id' => 8, 'created_at' => now(), 'status' => 1],
            ['id'=>47,'name' => 'createVariantCatelogue', 'display_name' => 'Tạo danh mục thuộc tính', 'description' => 'Quyền tạo danh mục thuộc tính', 'group_permission_id' => 8, 'created_at' => now(), 'status' => 1],
            ['id'=>48,'name' => 'storeVariantCatelogue', 'display_name' => 'Lưu danh mục thuộc tính', 'description' => 'Quyền lưu danh mục thuộc tính', 'group_permission_id' => 8, 'created_at' => now(), 'status' => 1],
            ['id'=>49,'name' => 'editVariantCatelogue', 'display_name' => 'Chỉnh sửa danh mục thuộc tính', 'description' => 'Quyền chỉnh sửa danh mục thuộc tính', 'group_permission_id' => 8, 'created_at' => now(), 'status' => 1],
            ['id'=>50,'name' => 'updateVariantCatelogue', 'display_name' => 'Cập nhật danh mục thuộc tính', 'description' => 'Quyền cập nhật danh mục thuộc tính', 'group_permission_id' => 8, 'created_at' => now(), 'status' => 1],
            ['id'=>51,'name' => 'deleteVariantCatelogue', 'display_name' => 'Xóa danh mục thuộc tính', 'description' => 'Quyền xóa danh mục thuộc tính', 'group_permission_id' => 8, 'created_at' => now(), 'status' => 1],
            ['id'=>52,'name' => 'viewAttributeValue', 'display_name' => 'Xem giá trị thuộc tính', 'description' => 'Quyền xem giá trị thuộc tính', 'group_permission_id' => 9, 'created_at' => now(), 'status' => 1],
            ['id'=>53,'name' => 'createAttributeValue', 'display_name' => 'Tạo giá trị thuộc tính', 'description' => 'Quyền tạo giá trị thuộc tính', 'group_permission_id' => 9, 'created_at' => now(), 'status' => 1],
            ['id'=>54,'name' => 'storeAttributeValue', 'display_name' => 'Lưu giá trị thuộc tính', 'description' => 'Quyền lưu giá trị thuộc tính', 'group_permission_id' => 9, 'created_at' => now(), 'status' => 1],
            ['id'=>55,'name' => 'editAttributeValue', 'display_name' => 'Chỉnh sửa giá trị thuộc tính', 'description' => 'Quyền chỉnh sửa giá trị thuộc tính', 'group_permission_id' => 9, 'created_at' => now(), 'status' => 1],
            ['id'=>56,'name' => 'updateAttributeValue', 'display_name' => 'Cập nhật giá trị thuộc tính', 'description' => 'Quyền cập nhật giá trị thuộc tính', 'group_permission_id' => 9, 'created_at' => now(), 'status' => 1],
            ['id'=>57,'name' => 'deleteAttributeValue', 'display_name' => 'Xóa giá trị thuộc tính', 'description' => 'Quyền xóa giá trị thuộc tính', 'group_permission_id' => 9, 'created_at' => now(), 'status' => 1],
            ['id'=>58,'name' => 'viewPaymentMethod', 'display_name' => 'Xem phương thức thanh toán', 'description' => 'Quyền xem phương thức thanh toán', 'group_permission_id' => 10, 'created_at' => now(), 'status' => 1],
            ['id'=>59,'name' => 'createPaymentMethod', 'display_name' => 'Tạo phương thức thanh toán', 'description' => 'Quyền tạo phương thức thanh toán', 'group_permission_id' => 10, 'created_at' => now(), 'status' => 1],
            ['id'=>60,'name' => 'storePaymentMethod', 'display_name' => 'Lưu phương thức thanh toán', 'description' => 'Quyền lưu phương thức thanh toán', 'group_permission_id' => 10, 'created_at' => now(), 'status' => 1],
            ['id'=>61,'name' => 'editPaymentMethod', 'display_name' => 'Chỉnh sửa phương thức thanh toán', 'description' => 'Quyền chỉnh sửa phương thức thanh toán', 'group_permission_id' => 10, 'created_at' => now(), 'status' => 1],
            ['id'=>62,'name' => 'updatePaymentMethod', 'display_name' => 'Cập nhật phương thức thanh toán', 'description' => 'Quyền cập nhật phương thức thanh toán', 'group_permission_id' => 10, 'created_at' => now(), 'status' => 1],
            ['id'=>63,'name' => 'deletePaymentMethod', 'display_name' => 'Xóa phương thức thanh toán', 'description' => 'Quyền xóa phương thức thanh toán', 'group_permission_id' => 10, 'created_at' => now(), 'status' => 1],
            ['id'=>64,'name' => 'viewPromotion', 'display_name' => 'Xem khuyến mãi', 'description' => 'Quyền xem khuyến mãi', 'group_permission_id' => 11, 'created_at' => now(), 'status' => 1],
            ['id'=>65,'name' => 'createPromotion', 'display_name' => 'Tạo khuyến mãi', 'description' => 'Quyền tạo khuyến mãi', 'group_permission_id' => 11, 'created_at' => now(), 'status' => 1],
            ['id'=>66,'name' => 'storePromotion', 'display_name' => 'Lưu khuyến mãi', 'description' => 'Quyền lưu khuyến mãi', 'group_permission_id' => 11, 'created_at' => now(), 'status' => 1],
            ['id'=>67,'name' => 'editPromotion', 'display_name' => 'Chỉnh sửa khuyến mãi', 'description' => 'Quyền chỉnh sửa khuyến mãi', 'group_permission_id' => 11, 'created_at' => now(), 'status' => 1],
            ['id'=>68,'name' => 'updatePromotion', 'display_name' => 'Cập nhật khuyến mãi', 'description' => 'Quyền cập nhật khuyến mãi', 'group_permission_id' => 11, 'created_at' => now(), 'status' => 1],
            ['id'=>69,'name' => 'deletePromotion', 'display_name' => 'Xóa khuyến mãi', 'description' => 'Quyền xóa khuyến mãi', 'group_permission_id' => 11, 'created_at' => now(), 'status' => 1],
            ['id'=>70,'name' => 'viewPromotionStatistics', 'display_name' => 'Xem thống kê khuyến mãi', 'description' => 'Quyền xem thống kê khuyến mãi', 'group_permission_id' => 11, 'created_at' => now(), 'status' => 1],
            ['id'=>71,'name' => 'viewAboutPage', 'display_name' => 'Xem trang giới thiệu', 'description' => 'Quyền xem trang giới thiệu', 'group_permission_id' => 12, 'created_at' => now(), 'status' => 1],
            ['id'=>72,'name' => 'createAboutPage', 'display_name' => 'Tạo trang giới thiệu', 'description' => 'Quyền tạo trang giới thiệu', 'group_permission_id' => 12, 'created_at' => now(), 'status' => 1],
            ['id'=>73,'name' => 'storeAboutPage', 'display_name' => 'Lưu trang giới thiệu', 'description' => 'Quyền lưu trang giới thiệu', 'group_permission_id' => 12, 'created_at' => now(), 'status' => 1],
            ['id'=>74,'name' => 'editAboutPage', 'display_name' => 'Chỉnh sửa trang giới thiệu', 'description' => 'Quyền chỉnh sửa trang giới thiệu', 'group_permission_id' => 12, 'created_at' => now(), 'status' => 1],
            ['id'=>75,'name' => 'updateAboutPage', 'display_name' => 'Cập nhật trang giới thiệu', 'description' => 'Quyền cập nhật trang giới thiệu', 'group_permission_id' => 12, 'created_at' => now(), 'status' => 1],
            ['id'=>76,'name' => 'deleteAboutPage', 'display_name' => 'Xóa trang giới thiệu', 'description' => 'Quyền xóa trang giới thiệu', 'group_permission_id' => 12, 'created_at' => now(), 'status' => 1],
            ['id'=>77,'name' => 'viewProductReviews', 'display_name' => 'Xem đánh giá sản phẩm', 'description' => 'Quyền xem đánh giá sản phẩm', 'group_permission_id' => 13, 'created_at' => now(), 'status' => 1],
            ['id'=>78,'name' => 'viewUserReviews', 'display_name' => 'Xem đánh giá người dùng', 'description' => 'Quyền xem đánh giá người dùng', 'group_permission_id' => 13, 'created_at' => now(), 'status' => 1],
            ['id'=>79,'name' => 'viewBrand', 'display_name' => 'Xem nhãn hiệu', 'description' => 'Quyền xem nhãn hiệu', 'group_permission_id' => 14, 'created_at' => now(), 'status' => 1],
            ['id'=>80,'name' => 'createBrand', 'display_name' => 'Tạo nhãn hiệu', 'description' => 'Quyền tạo nhãn hiệu', 'group_permission_id' => 14, 'created_at' => now(), 'status' => 1],
            ['id'=>81,'name' => 'storeBrand', 'display_name' => 'Lưu nhãn hiệu', 'description' => 'Quyền lưu nhãn hiệu', 'group_permission_id' => 14, 'created_at' => now(), 'status' => 1],
            ['id'=>82,'name' => 'editBrand', 'display_name' => 'Chỉnh sửa nhãn hiệu', 'description' => 'Quyền chỉnh sửa nhãn hiệu', 'group_permission_id' => 14, 'created_at' => now(), 'status' => 1],
            ['id'=>83,'name' => 'updateBrand', 'display_name' => 'Cập nhật nhãn hiệu', 'description' => 'Quyền cập nhật nhãn hiệu', 'group_permission_id' => 14, 'created_at' => now(), 'status' => 1],
            ['id'=>84,'name' => 'deleteBrand', 'display_name' => 'Xóa nhãn hiệu', 'description' => 'Quyền xóa nhãn hiệu', 'group_permission_id' => 14, 'created_at' => now(), 'status' => 1],
            ['id'=>85,'name' => 'forceDeleteBrand', 'display_name' => 'Xóa vĩnh viễn nhãn hiệu', 'description' => 'Quyền xóa vĩnh viễn nhãn hiệu', 'group_permission_id' => 14, 'created_at' => now(), 'status' => 1],
            ['id'=>86,'name' => 'restoreBrand', 'display_name' => 'Khôi phục nhãn hiệu', 'description' => 'Quyền khôi phục nhãn hiệu', 'group_permission_id' => 14, 'created_at' => now(), 'status' => 1],
            ['id'=>87,'name' => 'viewTrashBrand', 'display_name' => 'Xem thùng rác nhãn hiệu', 'description' => 'Quyền xem thùng rác nhãn hiệu', 'group_permission_id' => 14, 'created_at' => now(), 'status' => 1],
            ['id'=>88,'name' => 'viewContact', 'display_name' => 'Xem liên hệ', 'description' => 'Quyền xem liên hệ', 'group_permission_id' => 15, 'created_at' => now(), 'status' => 1],
            ['id'=>89,'name' => 'createContact', 'display_name' => 'Tạo liên hệ', 'description' => 'Quyền tạo liên hệ', 'group_permission_id' => 15, 'created_at' => now(), 'status' => 1],
            ['id'=>90,'name' => 'storeContact', 'display_name' => 'Lưu liên hệ', 'description' => 'Quyền lưu liên hệ', 'group_permission_id' => 15, 'created_at' => now(), 'status' => 1],
            ['id'=>91,'name' => 'editContact', 'display_name' => 'Chỉnh sửa liên hệ', 'description' => 'Quyền chỉnh sửa liên hệ', 'group_permission_id' => 15, 'created_at' => now(), 'status' => 1],
            ['id'=>92,'name' => 'updateContact', 'display_name' => 'Cập nhật liên hệ', 'description' => 'Quyền cập nhật liên hệ', 'group_permission_id' => 15, 'created_at' => now(), 'status' => 1],
            ['id'=>93,'name' => 'deleteContact', 'display_name' => 'Xóa liên hệ', 'description' => 'Quyền xóa liên hệ', 'group_permission_id' => 15, 'created_at' => now(), 'status' => 1],
            ['id'=>94,'name' => 'forceDeleteContact', 'display_name' => 'Xóa vĩnh viễn form liên hệ', 'description' => 'Quyền xóa vĩnh viễn form liên hệ', 'group_permission_id' => 15, 'created_at' => now(), 'status' => 1],
            ['id'=>95,'name' => 'restoreContact', 'display_name' => 'Khôi phục form liên hệ', 'description' => 'Quyền khôi phục form liên hệ', 'group_permission_id' => 15, 'created_at' => now(), 'status' => 1],
            ['id'=>96,'name' => 'viewTrashContact', 'display_name' => 'Xem thùng rác form liên hệ', 'description' => 'Quyền xem thùng rác form liên hệ', 'group_permission_id' => 15, 'created_at' => now(), 'status' => 1],
            ['id'=>97,'name' => 'viewInformation', 'display_name' => 'Xem thông tin', 'description' => 'Quyền xem thông tin', 'group_permission_id' => 16, 'created_at' => now(), 'status' => 1],
            ['id'=>98,'name' => 'createInformation', 'display_name' => 'Tạo thông tin', 'description' => 'Quyền tạo thông tin', 'group_permission_id' => 16, 'created_at' => now(), 'status' => 1],
            ['id'=>99,'name' => 'storeInformation', 'display_name' => 'Lưu thông tin', 'description' => 'Quyền lưu thông tin', 'group_permission_id' => 16, 'created_at' => now(), 'status' => 1],
            ['id'=>100,'name' => 'editInformation', 'display_name' => 'Chỉnh sửa thông tin', 'description' => 'Quyền chỉnh sửa thông tin', 'group_permission_id' => 16, 'created_at' => now(), 'status' => 1],
            ['id'=>101,'name' => 'updateInformation', 'display_name' => 'Cập nhật thông tin', 'description' => 'Quyền cập nhật thông tin', 'group_permission_id' => 16, 'created_at' => now(), 'status' => 1],
            ['id'=>102,'name' => 'deleteInformation', 'display_name' => 'Xóa thông tin', 'description' => 'Quyền xóa thông tin', 'group_permission_id' => 16, 'created_at' => now(), 'status' => 1],
            ['id'=>103,'name' => 'viewShippingFee', 'display_name' => 'Xem phí ship', 'description' => 'Quyền xem phí ship', 'group_permission_id' => 17, 'created_at' => now(), 'status' => 1],
            ['id'=>104,'name' => 'createShippingFee', 'display_name' => 'Tạo phí ship', 'description' => 'Quyền tạo phí ship', 'group_permission_id' => 17, 'created_at' => now(), 'status' => 1],
            ['id'=>105,'name' => 'storeShippingFee', 'display_name' => 'Lưu phí ship', 'description' => 'Quyền lưu phí ship', 'group_permission_id' => 17, 'created_at' => now(), 'status' => 1],
            ['id'=>106,'name' => 'editShippingFee', 'display_name' => 'Chỉnh sửa phí ship', 'description' => 'Quyền chỉnh sửa phí ship', 'group_permission_id' => 17, 'created_at' => now(), 'status' => 1],
            ['id'=>107,'name' => 'updateShippingFee', 'display_name' => 'Cập nhật phí ship', 'description' => 'Quyền cập nhật phí ship', 'group_permission_id' => 17, 'created_at' => now(), 'status' => 1],
            ['id'=>108,'name' => 'deleteShippingFee', 'display_name' => 'Xóa phí ship', 'description' => 'Quyền xóa phí ship', 'group_permission_id' => 17, 'created_at' => now(), 'status' => 1],
            ['id'=>109,'name' => 'forceDeleteShippingFee', 'display_name' => 'Xoá vĩnh viễn phí ship', 'description' => 'Quyền xoá vĩnh viễn phí ship', 'group_permission_id' => 17, 'created_at' => now(), 'status' => 1],
            ['id'=>110,'name' => 'restoreShippingFee', 'display_name' => 'Khôi phục phí ship', 'description' => 'Quyền khôi phục phí ship', 'group_permission_id' => 17, 'created_at' => now(), 'status' => 1],
            ['id'=>111,'name' => 'trashShippingFee', 'display_name' => 'Thùng rác phí ship', 'description' => 'Quyền xem thùng rác phí ship', 'group_permission_id' => 17, 'created_at' => now(), 'status' => 1],
            ['id'=>112,'name' => 'viewCustomer', 'display_name' => 'Xem khách hàng', 'description' => 'Quản lý khách hàng', 'group_permission_id' => 18, 'created_at' => now(), 'status' => 1],
            ['id'=>113,'name' => 'createCustomer', 'display_name' => 'Tạo khách hàng', 'description' => 'Quản lý khách hàng', 'group_permission_id' => 18, 'created_at' => now(), 'status' => 1],
            ['id'=>114,'name' => 'storeCustomer', 'display_name' => 'Lưu khách hàng', 'description' => 'Quản lý khách hàng', 'group_permission_id' => 18, 'created_at' => now(), 'status' => 1],
            ['id'=>115,'name' => 'viewCustomerDetail', 'display_name' => 'Xem chi tiết khách hàng', 'description' => 'Quản lý khách hàng', 'group_permission_id' => 18, 'created_at' => now(), 'status' => 1],
            ['id'=>116,'name' => 'editCustomer', 'display_name' => 'Chỉnh sửa khách hàng', 'description' => 'Quản lý khách hàng', 'group_permission_id' => 18, 'created_at' => now(), 'status' => 1],
            ['id'=>117,'name' => 'updateCustomer', 'display_name' => 'Cập nhật khách hàng', 'description' => 'Quản lý khách hàng', 'group_permission_id' => 18, 'created_at' => now(), 'status' => 1],
            ['id'=>118,'name' => 'deleteCustomer', 'display_name' => 'Xóa khách hàng', 'description' => 'Quản lý khách hàng', 'group_permission_id' => 18, 'created_at' => now(), 'status' => 1],
            ['id'=>119,'name' => 'viewGroupPermission', 'display_name' => 'Xem nhóm quyền', 'description' => 'Xem nhóm quyền', 'group_permission_id' => 19, 'created_at' => now(), 'status' => 1],
            ['id'=>120,'name' => 'createGroupPermission', 'display_name' => 'Tạo nhóm quyền', 'description' => 'Tạo nhóm quyền', 'group_permission_id' => 19, 'created_at' => now(), 'status' => 1],
            ['id'=>121,'name' => 'storeGroupPermission', 'display_name' => 'Lưu nhóm quyền', 'description' => 'Lưu nhóm quyền', 'group_permission_id' => 19, 'created_at' => now(), 'status' => 1],
            ['id'=>122,'name' => 'editGroupPermission', 'display_name' => 'Chỉnh sửa nhóm quyền', 'description' => 'Chỉnh sửa nhóm quyền', 'group_permission_id' => 19, 'created_at' => now(), 'status' => 1],
            ['id'=>123,'name' => 'updateGroupPermission', 'display_name' => 'Cập nhật nhóm quyền', 'description' => 'Cập nhật nhóm quyền', 'group_permission_id' => 19, 'created_at' => now(), 'status' => 1],
            ['id'=>124,'name' => 'deleteGroupPermission', 'display_name' => 'Xóa nhóm quyền', 'description' => 'Xóa nhóm quyền', 'group_permission_id' => 19, 'created_at' => now(), 'status' => 1],
            ['id'=>125,'name' => 'forceDeleteGroupPermission', 'display_name' => 'Xóa vĩnh viễn nhóm quyền', 'description' => 'Xóa vĩnh viễn nhóm quyền', 'group_permission_id' => 19, 'created_at' => now(), 'status' => 1],
            ['id'=>126,'name' => 'restoreGroupPermission', 'display_name' => 'Khôi phục nhóm quyền', 'description' => 'Khôi phục nhóm quyền', 'group_permission_id' => 19, 'created_at' => now(), 'status' => 1],
            ['id'=>127,'name' => 'viewGroupPermissionTrash', 'display_name' => 'Xem thùng rác nhóm quyền', 'description' => 'Xem thùng rác nhóm quyền', 'group_permission_id' => 19, 'created_at' => now(), 'status' => 1],
            ['id'=>128,'name' => 'viewPermission', 'display_name' => 'Xem quyền', 'description' => 'Quản lý quyền', 'group_permission_id' => 20, 'created_at' => now(), 'status' => 1],
            ['id'=>129,'name' => 'createPermission', 'display_name' => 'Tạo quyền', 'description' => 'Quản lý quyền', 'group_permission_id' => 20, 'created_at' => now(), 'status' => 1],
            ['id'=>130,'name' => 'storePermission', 'display_name' => 'Lưu quyền', 'description' => 'Quản lý quyền', 'group_permission_id' => 20, 'created_at' => now(), 'status' => 1],
            ['id'=>131,'name' => 'editPermission', 'display_name' => 'Chỉnh sửa quyền', 'description' => 'Quản lý quyền', 'group_permission_id' => 20, 'created_at' => now(), 'status' => 1],
            ['id'=>132,'name' => 'updatePermission', 'display_name' => 'Cập nhật quyền', 'description' => 'Quản lý quyền', 'group_permission_id' => 20, 'created_at' => now(), 'status' => 1],
            ['id'=>133,'name' => 'deletePermission', 'display_name' => 'Xóa quyền', 'description' => 'Quản lý quyền', 'group_permission_id' => 20, 'created_at' => now(), 'status' => 1],
            ['id'=>134,'name' => 'forceDeletePermission', 'display_name' => 'Xóa vĩnh viễn quyền', 'description' => 'Quản lý quyền', 'group_permission_id' => 20, 'created_at' => now(), 'status' => 1],
            ['id'=>135,'name' => 'restorePermission', 'display_name' => 'Khôi phục quyền', 'description' => 'Quản lý quyền', 'group_permission_id' => 20, 'created_at' => now(), 'status' => 1],
            ['id'=>136,'name' => 'viewPermissionTrash', 'display_name' => 'Xem thùng rác quyền', 'description' => 'Quản lý quyền', 'group_permission_id' => 20, 'created_at' => now(), 'status' => 1],
            ['id'=>137,'name' => 'viewRole', 'display_name' => 'Xem vai trò', 'description' => 'Quản lý vai trò', 'group_permission_id' => 21, 'created_at' => now(), 'status' => 1],
            ['id'=>138,'name' => 'createRole', 'display_name' => 'Tạo vai trò', 'description' => 'Quản lý vai trò', 'group_permission_id' => 21, 'created_at' => now(), 'status' => 1],
            ['id'=>139,'name' => 'storeRole', 'display_name' => 'Lưu vai trò', 'description' => 'Quản lý vai trò', 'group_permission_id' => 21, 'created_at' => now(), 'status' => 1],
            ['id'=>140,'name' => 'showRole', 'display_name' => 'Xem vai trò', 'description' => 'Quản lý vai trò', 'group_permission_id' => 21, 'created_at' => now(), 'status' => 1],
            ['id'=>141,'name' => 'editRole', 'display_name' => 'Chỉnh sửa vai trò', 'description' => 'Quản lý vai trò', 'group_permission_id' => 21, 'created_at' => now(), 'status' => 1],
            ['id'=>142,'name' => 'updateRole', 'display_name' => 'Cập nhật vai trò', 'description' => 'Quản lý vai trò', 'group_permission_id' => 21, 'created_at' => now(), 'status' => 1],
            ['id'=>143,'name' => 'deleteRole', 'display_name' => 'Xóa vai trò', 'description' => 'Quản lý vai trò', 'group_permission_id' => 21, 'created_at' => now(), 'status' => 1],
            ['id'=>144,'name' => 'forceDeleteRole', 'display_name' => 'Xóa vĩnh viễn vai trò', 'description' => 'Quản lý vai trò', 'group_permission_id' => 21, 'created_at' => now(), 'status' => 1],
            ['id'=>145,'name' => 'restoreRole', 'display_name' => 'Khôi phục vai trò', 'description' => 'Quản lý vai trò', 'group_permission_id' => 21, 'created_at' => now(), 'status' => 1],
            ['id'=>146,'name' => 'viewRoleTrash', 'display_name' => 'Xem thùng rác vai trò', 'description' => 'Quản lý vai trò', 'group_permission_id' => 21, 'created_at' => now(), 'status' => 1],
            ['id'=>147,'name' => 'viewDashboardOrder', 'display_name' => 'Xem bảng điều khiển đơn hàng', 'description' => 'Quản lý đơn hàng', 'group_permission_id' => 22, 'created_at' => now(), 'status' => 1],
            ['id'=>148,'name' => 'filterSalesData', 'display_name' => 'Lọc dữ liệu doanh thu', 'description' => 'Quản lý doanh thu', 'group_permission_id' => 22, 'created_at' => now(), 'status' => 1],
            ['id'=>149,'name' => 'selectSalesData', 'display_name' => 'Chọn dữ liệu doanh thu', 'description' => 'Quản lý doanh thu', 'group_permission_id' => 22, 'created_at' => now(), 'status' => 1],
            ['id'=>150,'name' => 'selectOrderStatusData', 'display_name' => 'Chọn trạng thái đơn hàng', 'description' => 'Quản lý đơn hàng', 'group_permission_id' => 22, 'created_at' => now(), 'status' => 1],
        ];
        DB::table('permissions')->insert($permissions);

    }
}
