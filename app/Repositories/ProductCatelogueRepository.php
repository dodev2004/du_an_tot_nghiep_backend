<?php

namespace App\Repositories;

use App\Repositories\Interfaces\ProductCatelogueRepositoryInterface;
use App\Models\ProductCatelogue;
use App\Repositories\BaseRespository;
use Illuminate\Http\Request;
/**
 * Class UserService
 * @package App\Services
 */
class ProductCatelogueRepository extends BaseRespository  implements ProductCatelogueRepositoryInterface
{
    protected $model;
    public function __construct(
        ProductCatelogue $model
    ){
        $this->model = $model;
    }
    public function create($data)
    {
        return  $this->model::create($data);
    }
    public function getParent($id)
    {
        $catelogue = [];
        $items = $this->model::where("id", $id)->get();
        $parent = $this->model::find($id)->parent()->select("id")->get()->toArray();
        foreach ($parent as $item){
            array_push($catelogue,$item["id"]);
        }
        array_push($catelogue,$id);
       return $catelogue;
    }
    public function update($request)
    {
        $data = $request->except("id");
      $catelogue =  $this->model::findOrFail($request->id);
      $catelogue->update($data); 
    }
    public function findId($id)
    {
        return $this->model::findOrFail($id);       
    }
    public function delete($request)
    {
        $id = $request->id;
        try{
            $this->model::find($id)->delete();
            return true;
        }
        catch(\Exception $e){
            return false;
        }
    }
}

