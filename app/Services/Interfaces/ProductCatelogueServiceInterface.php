<?php

namespace App\Services\Interfaces;

/**
 * Interface UserCatelogueServiceInterface
 * @package App\Services\Interfaces
 */
interface ProductCatelogueServiceInterface
{
    public function getAllProductCatelogue();
    public function dropdownCatelogue();
    public function StoreProductCatelogue($data);
    public function EditProductCatelogue($request,$title,$breadcrumbs);
    public function UpdateProductCatelogue($data,$id);
}
