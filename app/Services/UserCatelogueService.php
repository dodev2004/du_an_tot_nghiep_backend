<?php

namespace App\Services;

use App\Repositories\Interfaces\UserCatelogueRespositoryInterface;;
use  App\Services\Interfaces\UserCatelogueServiceInterface;
/**
 * Class UserCatelogueService
 * @package App\Services
 */
class UserCatelogueService implements UserCatelogueServiceInterface
{
    protected $userCatelogue;
    public function __construct(UserCatelogueRespositoryInterface $userCatelogue){
        $this->userCatelogue = $userCatelogue;
    }
    public function getAll(){
        return $this->userCatelogue->all();
    }
    public function create($data)
    {
        try{
            return $this->userCatelogue->create($data);  
            return true;
        }
        catch(\Exception $e){
            return false;
        }
    }
    public function update($data,$id){
        try{
            return $this->userCatelogue->findUserCatelogueId($id)->update($data);  
            return true;
        }
        catch(\Exception $e){
            return false;
        }
    }
    public function deleteUserCatelogue($id){
        try{
            $this->userCatelogue->deleteUserCatelogueById($id);
            return true; 
        }
       catch(\Exception $e){
        return false;
       }
    }
}
