<?php

namespace App\Services;

use App\Models\Promotion;
use App\Services\Interfaces\PromotionServiceInterface;

class PromotionService implements PromotionServiceInterface
{
    /**
     * Lấy tất cả các khuyến mãi từ cơ sở dữ liệu.
     */
    public function getAllPromotions()
    {
        return Promotion::paginate(10); // Giả sử chúng ta phân trang 10 bản ghi một trang
    }

    /**
     * Lấy dữ liệu để hiển thị trong dropdown (nếu có).
     */
    public function getDropdownData()
    {
        // Nếu bạn có dữ liệu liên quan khác cần cho form, bạn có thể lấy tại đây
        return [];
    }

    /**
     * Lưu trữ khuyến mãi mới vào cơ sở dữ liệu.
     */
    public function storePromotion(array $data)
    {
        try {
            return Promotion::create($data); // Lưu dữ liệu vào bảng promotions
        } catch (\Exception $e) {
            return false; // Nếu có lỗi xảy ra, trả về false
        }
    }

    /**
     * Cập nhật khuyến mãi.
     */
    public function updatePromotion(array $data, $id)
    {
        try {
            $promotion = Promotion::findOrFail($id);
            return $promotion->update($data); // Cập nhật dữ liệu
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Xóa khuyến mãi.
     */
    public function deletePromotion($id)
    {
        try {
            $promotion = Promotion::findOrFail($id);
            return $promotion->delete(); // Xóa dữ liệu
        } catch (\Exception $e) {
            return false;
        }
    }
}
