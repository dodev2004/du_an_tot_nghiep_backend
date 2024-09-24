<?php

namespace App\Services;

use App\Services\Interfaces\UserServiceInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;
/**
 * Class UserService
 * @package App\Services
 */
class UserService implements UserServiceInterface
{
    protected $userRespository;
    public function __construct(UserRepositoryInterface $userRespository) {
        $this->userRespository = $userRespository;
    }
    public function getAllUsers()
    {
      
        return  $this->userRespository->pagination();
    }
    public function create($data){
        try{
          DB::beginTransaction();
        $this->userRespository->create($data);
          DB::commit();
          return true;
        }
        catch(\Exception $e){ 
        
          throw $e;
          return false;
        }
    
      }
      public function getUserId($id){
        return $this->userRespository->findUserId($id);
      }
      public function update($data,$id){
        try {
          $this->userRespository->updateUser($data,$id);
          return true;
        } catch (\Exception $e) {
          //throw $th;
          DB::rollBack();
          return false;
        }
      }
      public function change_status($status,$id){
          $this->userRespository->updatestatus($status,$id);
      }
      public function delete($id){
        try{
          $this->userRespository->deleteUserById($id);
          return true;
        }
        catch(\Exception $e){
          throw $e;
        }
      }
}
