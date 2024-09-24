<?php

namespace App\Repositories\Interfaces;

/**
 * Interface UserServiceInterface
 * @package App\Services\Interfaces
 */
interface ProductCatelogueRepositoryInterface
{
    public function create($data);
    public function update($request);
    public function findId($id);
    public function delete($request);
    public function getParent($id);
}
