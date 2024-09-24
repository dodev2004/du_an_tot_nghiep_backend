<?php

namespace App\Repositories\Interfaces;

/**
 * Interface UserServiceInterface
 * @package App\Services\Interfaces
 */
interface UserRepositoryInterface
{
 public function pagination();
 public function create($data);
 public function findUserId($id);
 public function updateUser($data,$id);
 public function updatestatus($status,$id);
 public function deleteUserById($id);
}
