<?php

namespace App\Services\Interfaces;

/**
 * Interface UserServiceInterface
 * @package App\Services\Interfaces
 */
interface AttributeValueServiceInterface
{
    public function getAllAttributeValue();
    public function create($data);
    public function getAttributeValueId($id);
    public function update($data,$id);
    public function change_status($status,$id);
    public function delete($id);
    public function getAttribute();
    public function getAttributeById($id);
}
