<?php

namespace App\Repositories;

use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Repositories\BaseRespository;
use Illuminate\Database\Eloquent\Builder;
/**
 * Class UserService
 * @package App\Services
 */
class UserRepository extends BaseRespository  implements UserRepositoryInterface
{
  public function __construct(User $user){
    $this->model = $user;
  }
  public function pagination()
  {
    $query  = $this->model;

    $query = $this->model::where(function(Builder $query){
              if(request()->has(["name"])){
                $query->where("full_name","like",'%'.request()->name . '%') ;
                $query->orWhere("email","like",'%'.request()->name.'%');
                $query->orWhere("phone","like",'%'.request()->name. '%');
                $query->orWhere("address","like",'%'.request()->name. '%');
              }
              if(request()->has('rule_id')){
                $query->where("rule_id",request()->rule_id ) ;
               
              }
    });
    return $query->paginate(15)->withQueryString();
  }
  public function create($data){
    if(request()->avatar){
      $image = request()->avatar;
      $extension = $image->getClientOriginalExtension();
      $filename = Str::uuid() . ".". $extension;
      $path =  request()->avatar->storeAs("public/user",$filename);
      $data["image"] = "storage/user/".$filename;
    }
    $this->model::create($data);
  }
  public function findUserId($id){
      return $this->findId($id);
  }
  public function updateUser($data, $id)
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
    $user = User::find($id);
    $user->user_status = $status;
    $user->save();
  }
  public function deleteUserById($id){
    $users = $this->model::find($id);
    $users->delete();
}
}
