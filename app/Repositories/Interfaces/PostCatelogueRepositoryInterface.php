<?php

namespace App\Repositories\Interfaces;

/**
 * Interface UserServiceInterface
 * @package App\Services\Interfaces
 */
interface PostCatelogueRepositoryInterface
{
    public function create($data);
    public function updatePostCatlogue($request);
    public function findCatelogueById($id);
    public function delete($request);
    public function getParent($id);
}
