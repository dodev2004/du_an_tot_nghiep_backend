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

    $query = $this->model::where(function(Builder $query) {
        // Mặc định tìm kiếm với rule_id = 1
        $query->where('rule_id', 1);

        // Kiểm tra nếu có dữ liệu tìm kiếm
        if (request()->has(["name"]) && !empty(request()->name)) {
            $query->where(function(Builder $query) {
                $query->where("full_name", "like", '%' . request()->name . '%')
                      ->orWhere("email", "like", '%' . request()->name . '%')
                      ->orWhere("phone", "like", '%' . request()->name . '%')
                      ->orWhere("address", "like", '%' . request()->name . '%');
            });
        }

        // Kiểm tra nếu có rule_id trong request
        if (request()->has('rule_id') && !empty(request()->rule_id)) {
            $query->whereHas('roles', function($query) {
                $query->where('role_id', request()->rule_id);
            });
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
   $user =  $this->model::create($data);
    $user->roles()->attach(explode(",",request()->role_id));
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
    $user = $this->model::findOrFail($id);
    $user->update($data);
    $user->roles()->sync(explode(",", request()->role_id));
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
