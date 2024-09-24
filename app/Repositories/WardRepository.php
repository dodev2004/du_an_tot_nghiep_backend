<?php

namespace App\Repositories;

use App\Repositories\Interfaces\WardRepositoryInterface;
use App\Models\User;
use App\Repositories\BaseRespository;
use App\Models\District;
use App\Models\Ward;
use Illuminate\Http\Request;
/**
 * Class UserService
 * @package App\Services
 */
class WardRepository extends BaseRespository  implements WardRepositoryInterface
{
    protected $model;
    public function __construct(
        Ward $model
    ){
        $this->model = $model;
    }
    public function findWardByIdDistrict($idDistrict)
    {
        $wards = $this->model->where("district_code", $idDistrict)->get();
        return $this->renderHtml($wards);  
    }   
    public function renderHtml($wards){
        $html = [];
        foreach($wards as $ward){
         $html[] =  "<option value='" . $ward->code."'>" . $ward->name . "</option>"; 
        }
        return(implode("",$html));  
    }
}

