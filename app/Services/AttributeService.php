<?php

namespace App\Services;

use App\Services\Interfaces\AttributeServiceInterface;
use App\Repositories\Interfaces\AttributeRepositoryInterface as AttributeRepository;
use Illuminate\Support\Facades\DB;
/**
 * Class UserService
 * @package App\Services
 */
class AttributeService implements AttributeServiceInterface
{
    protected $attribute;
    public function __construct(AttributeRepository $attribute) {
        $this->attribute = $attribute;
    }
    public function getAllAttribute()
    {
      
        return  $this->attribute->pagination();
    }
    public function create($data){
        try{
          DB::beginTransaction();
        $this->attribute->create($data);
          DB::commit();
          return true;
        }
        catch(\Exception $e){ 
        
          throw $e;
          return false;
        }
    
      }
      public function getAttributeId($id){
        return $this->attribute->findId($id);
      }
      public function update($data,$id){
        try {
          $this->attribute->update($data,$id);
          return true;
        } catch (\Exception $e) {
          //throw $th;
          DB::rollBack();
          return false;
        }
      }
      public function change_status($status,$id){
          $this->attribute->updatestatus($status,$id);
      }
      public function delete($id){
        try{
          $this->attribute->delete($id);
          return true;
        }
        catch(\Exception $e){
          throw $e;
        }
      }
}
