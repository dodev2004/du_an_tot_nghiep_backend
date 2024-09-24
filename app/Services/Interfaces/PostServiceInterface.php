<?php

namespace App\Services\Interfaces;

/**
 * Interface UserCatelogueServiceInterface
 * @package App\Services\Interfaces
 */
interface PostServiceInterface
{
    public function getAll();
    public function dropdownPostCatelogue();
    public function PostStore($request);
   public function getPostByPostId($id);
    public function PostUpdate($request);
    public function getCatelogueByPost();
    public function PostCatelogueDelete($request);
   
}
