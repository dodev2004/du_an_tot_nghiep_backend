<?php

namespace App\Services;

use App\Services\Interfaces\AttributeValueServiceInterface;
use App\Repositories\Interfaces\AttributeRepositoryInterface as AttributeRepository;
use App\Repositories\Interfaces\AttributeValueRepositoryInterface as AttributeValueRepository;
use Illuminate\Support\Facades\DB;
/**
 * Class UserService
 * @package App\Services
 */
class AttributeValueService implements AttributeValueServiceInterface
{
    protected $attributevalue;
    protected $attribute;
    public function __construct(AttributeValueRepository $attributevalue , AttributeRepository $attribute) {
        $this->attributevalue = $attributevalue;
        $this->attribute = $attribute;
    }
    public function getAllAttributeValue()
    {
      
        return  $this->attributevalue->pagination();
    }
    public function create($data){
        try{
          DB::beginTransaction();
        $this->attributevalue->create($data);
          DB::commit();
          return true;
        }
        catch(\Exception $e){ 
        
          throw $e;
          return false;
        }
    
      }
      public function getAttributeValueId($id){
        return $this->attributevalue->findId($id);
      }
      public function update($data,$id){
        try {
          $this->attributevalue->update($data,$id);
          return true;
        } catch (\Exception $e) {
          //throw $th;
          DB::rollBack();
          return false;
        }
      }
      public function change_status($status,$id){
          $this->attributevalue->updatestatus($status,$id);
      }
      public function delete($id){
        try{
          $this->attributevalue->delete($id);
          return true;
        }
        catch(\Exception $e){
          throw $e;
        }
      }
      public function getAttribute(){
        return $this->attribute->getAll();
      }
      public function getAttributeById($id){
       
      }
}
