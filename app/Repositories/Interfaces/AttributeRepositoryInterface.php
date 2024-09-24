<?php

namespace App\Repositories\Interfaces;

/**
 * Interface UserServiceInterface
 * @package App\Services\Interfaces
 */
interface AttributeRepositoryInterface
{
 public function pagination();
 public function getAll();
 public function create($data);
 public function findId($id);
 public function update($data,$id);
 public function updatestatus($status,$id);
 public function delete($id);
}
