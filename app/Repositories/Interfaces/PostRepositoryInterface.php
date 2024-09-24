<?php

namespace App\Repositories\Interfaces;

/**
 * Interface UserServiceInterface
 * @package App\Services\Interfaces
 */
interface PostRepositoryInterface
{
    public function create($data);
    public function updatePostById($id,$data);
    public function findPostById($id);
    public function delete($request);
    public function getAllPost();
    public function getParentCatelogue($catelogue_id);
    public function getCatelogueByPost();
}
