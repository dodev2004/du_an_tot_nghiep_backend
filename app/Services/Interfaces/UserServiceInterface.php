<?php

namespace App\Services\Interfaces;

/**
 * Interface UserServiceInterface
 * @package App\Services\Interfaces
 */
interface UserServiceInterface
{
    public function getAllUsers();
    public function create($data);
    public function getUserId($id);
    public function update($data,$id);
    public function change_status($status,$id);
    public function delete($id);
}
