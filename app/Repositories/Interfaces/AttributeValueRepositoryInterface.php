<?php

namespace App\Repositories\Interfaces;

/**
 * Interface UserServiceInterface
 * @package App\Services\Interfaces
 */
interface AttributeValueRepositoryInterface
{
    public function pagination();
    public function create($data);
    public function findId($id);
    public function update($data,$id);
    public function updatestatus($status,$id);
    public function delete($id);
}
