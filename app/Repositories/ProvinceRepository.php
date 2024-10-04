<?php

namespace App\Repositories;

use App\Repositories\Interfaces\ProvinceRepositoryInterface;
use App\Models\User;
use App\Repositories\BaseRespository;
use App\Models\Province;
use Illuminate\Database\Eloquent\Builder;
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
        $query = $this->model::with("promotions")
        ->where(function(Builder $query){
                  if(request()->has(["keywords"])){
                    $query->where("name","like",'%'.request()->keywords . '%');
                  }
        })
        ->whereHas("promotions",function(Builder $query){
            if(request()->has(["keywords"])){
                $query->where("name","like",'%'.request()->keywords . '%');
              }
        })
        ->paginate(15)->appends(request()->query());
        return $query;
      
    }
    public function create($data){
        $this->model::create($data);
      }
      public function findId($id){
          return $this->model::find($id);
      }
      public function update($data, $id)
      {
        $this->model::where("id",$id)->update($data);
      }
      public function updatestatus($status,$id){
        $user = $this->model::find($id);
      }
      public function delete($id){
        $users = $this->model::find($id);
        $users->delete();
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
    public function all(){
        return Province::all();
    }
}

