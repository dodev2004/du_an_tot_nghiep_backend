<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\PromotionRepositoryInterface as PromotionRepository;

class PromotionController extends Controller
{
    protected $promotions;
    protected $breadcrumbs = [];

    public function __construct(PromotionRepository $promotions)
    {
        $this->promotions = $promotions;
    }
    public function listPromotions()
{
    $title = "Quản lý mã giảm giá";
    $this->breadcrumbs[] = [
        "active" => true,
        "url" => route("admin.promotions"),
        "name" => "Quản lý mã giảm giá"
    ];
    $breadcrumbs = $this->breadcrumbs;

    $data = $this->promotions->getAllPromotions()->paginate(10);
    if (!empty($data) && isset($data[0])) {
        $table = $data[0]->getTable(); 
    } else {
        $table = 'promotions'; 
    }
    return view("backend.promotion.templates.list", compact('data', 'breadcrumbs', 'title', 'table'));
}


}
