<?php

namespace App\Services\Interfaces;

interface PromotionServiceInterface
{
    public function getAllPromotions();
    
    public function getDropdownData();
    
    public function storePromotion(array $data);
    
    public function updatePromotion(array $data, $id);
    
    public function deletePromotion($id);
}
?>