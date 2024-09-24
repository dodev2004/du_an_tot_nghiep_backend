<?php

namespace App\Services\Interfaces;

/**
 * Interface UserServiceInterface
 * @package App\Services\Interfaces
 */
interface AttributeServiceInterface
{
    public function getAllAttribute();
    public function create($data);
    public function getAttributeId($id);
    public function update($data,$id);
    public function change_status($status,$id);
    public function delete($id);
}
