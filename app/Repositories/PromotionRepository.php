<?php

namespace App\Repositories;

use App\Models\Promotion;
use App\Repositories\Interfaces\PromotionRepositoryInterface;

class PromotionRepository implements PromotionRepositoryInterface
{
    public function getAllPromotions()
    {
        return Promotion::query();
    }

    public function getPromotionById($id)
    {
        return Promotion::findOrFail($id);
    }

    public function create(array $data)
    {
        return Promotion::create($data);
    }

    public function update(array $data, $id)
    {
        $promotion = Promotion::findOrFail($id);
        return $promotion->update($data);
    }

    public function delete($id)
    {
        $promotion = Promotion::findOrFail($id);
        return $promotion->delete();
    }

    public function changeStatus($status, $id)
    {
        $promotion = Promotion::findOrFail($id);
        $promotion->status = $status;
        return $promotion->save();
    }
}
