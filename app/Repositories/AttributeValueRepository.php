<?php

namespace App\Repositories;

use App\Repositories\Interfaces\AttributeValueRepositoryInterface;
use App\Models\AttributeValue;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Repositories\BaseRespository;
use Illuminate\Database\Eloquent\Builder;
/**
 * Class UserService
 * @package App\Services
 */
class AttributeValueRepository extends BaseRespository  implements AttributeValueRepositoryInterface
{
    protected $model;
    public function __construct(AttributeValue $attribute){
        $this->model = $attribute;
      }
      public function pagination()
      {
        $query  = $this->model;
        //  if(request()->has(["name"]) || request()->has("rule_id")){
        //   $name = request()->name ? request()->name : "";
        //   $rule = request()->rule_id ? request()->rule_id : "" ;  
        //   dd($rule);
        // if(!empty($name) && !empty($rule)){
        //    $query =  $this->model::where("Fullname","like",'%'.$name.'%')->where('rule_id',$rule)->orderBy("id","desc");
        // }
        // else if(empty($name) && !empty($rule)){
        //    $query =  $this->model::where("rule_id",$rule)->orderBy("id","desc");
        // }
        // else if(!empty($name) && empty($rule)){
    
        //  $query =  $this->model::where("Fullname","like",'%'.$name.'%')->orderBy("id","desc") ;
        // }
        //  }
        $query = $this->model::with("attributes")
        ->where(function(Builder $query){
                  if(request()->has(["keywords"])){
                    $query->where("name","like",'%'.request()->keywords . '%');
                  }
        })
        ->whereHas("attributes",function(Builder $query){
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
        if(request()->avatar){
          $image = request()->avatar;
          $extension = $image->getClientOriginalExtension();
          $filename = Str::uuid() . ".". $extension;
          $path =  request()->avatar->storeAs("public/user",$filename);
          $data["image"] = "storage/user/".$filename;
        }
        $this->model::where("id",$id)->update($data);
      }
      public function updatestatus($status,$id){
        $user = $this->model::find($id);
        $user->user_status = $status;
        $user->save();
      }
      public function delete($id){
        $users = $this->model::find($id);
        $users->delete();
    }
}
