<?php

namespace App\Repositories;

use App\Repositories\Interfaces\ProvinceRepositoryInterface;
use App\Models\User;
use App\Repositories\BaseRespository;
use App\Models\Province;
/**
 * Class UserService
 * @package App\Services
 */
class ProvinceRepository extends BaseRespository  implements ProvinceRepositoryInterface
{
    protected $model;
    public function __construct(
        Province $model
    ){
        $this->model = $model;
    }
    public function findDistrictByIdProvince($idProvince){
        if($idProvince){
            $province = $this->findId($idProvince);
            return $province->districts;
        }
        else {
            return "";
        }
       
    }
}