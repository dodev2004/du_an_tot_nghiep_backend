<?php

namespace App\Services\Interfaces;

/**
 * Interface UserCatelogueServiceInterface
 * @package App\Services\Interfaces
 */
interface UserCatelogueServiceInterface
{
    public function getAll();
    public function create($data);
    public function update($data,$id);
    public function deleteUserCatelogue($id);
}
