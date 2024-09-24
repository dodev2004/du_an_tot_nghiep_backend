<?php

namespace App\Repositories\Interfaces;

/**
 * Interface UserServiceInterface
 * @package App\Services\Interfaces
 */
interface DistrictRepositoryInterface
{
    public function all();
    public function findDistrictByIdProvince($idProvince);
    public function findwardsByIdDistrict($idDistrict);
   
}
