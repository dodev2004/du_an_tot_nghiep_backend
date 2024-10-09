<?php

namespace App\Repositories\Interfaces;

interface PromotionRepositoryInterface
{
    public function getAllPromotions();
    public function getPromotionById($id);
    public function create(array $data);
    public function update(array $data, $id);
    public function delete($id);
    public function changeStatus($status, $id);
    
}

