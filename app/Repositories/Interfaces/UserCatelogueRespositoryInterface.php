<?php

namespace App\Repositories\Interfaces;

/**
 * Interface UserServiceInterface
 * @package App\Services\Interfaces
 */
interface UserCatelogueRespositoryInterface
{
 public function all();
 public function create($data);
 public function findUserCatelogueId($id);
 public function updateUserCatelogue($data,$id);
 public function deleteUserCatelogueById($id);
}
