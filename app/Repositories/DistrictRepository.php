<?php

namespace App\Repositories;

use App\Repositories\Interfaces\DistrictRepositoryInterface;
use App\Models\User;
use App\Repositories\BaseRespository;
use App\Models\District;
use App\Models\Province;
use Illuminate\Http\Request;
/**
 * Class UserService
 * @package App\Services
 */
class DistrictRepository extends BaseRespository  implements DistrictRepositoryInterface
{
    protected $model;
    public function __construct(
        District $model
    ){
        $this->model = $model;
    }
    public function findDistrictByIdProvince($idProvince)
    {
        $districts = $this->model->where("province_code", $idProvince)->get();
        return $this->renderHtml($districts);  
    }   
    public function renderHtml($districts){
        $html = [];
        foreach($districts as $district){
         $html[] =  "<option value='" . $district->code."'>" . $district->name . "</option>"; 
        }
        return(implode("",$html));  
    }
    public function findwardsByIdDistrict($idDistrict){
        if($idDistrict){
            $district = $this->findId($idDistrict);
            return $district->wards;
        }
        else {
            return "";
        }
    }
}

