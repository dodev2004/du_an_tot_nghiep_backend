<?php

namespace App\Services\Interfaces;

/**
 * Interface UserCatelogueServiceInterface
 * @package App\Services\Interfaces
 */
interface PostCatelogueServiceInterface
{
    public function getAllPosCatelogue();
    public function PostCateloguecreate($request);
    public function dropdownPostCatelogue();
    public function PostCatelogueStore($request);
    public function PostCatelogueEdit($request,$title,$breadcrumbs);
    public function PostCatelogueUpdate($request);
}
