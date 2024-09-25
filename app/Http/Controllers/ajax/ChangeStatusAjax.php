<?php 
    namespace App\Http\Controllers\ajax;
    use App\Repositories\Interfaces\DistrictRepositoryInterface;
    use App\Repositories\Interfaces\WardRepositoryInterface;
    use Illuminate\Support\Facades\DB;
    class ChangeStatusAjax {
        public function change_status(){
            $data  = request()->except("_token");
          
            try{
                DB::table($data["table"])->where("id",$data["id"])->update(["status"=>$data["status"]]);
                return response()->json(["success"=>"thành công"]);
            }
            catch(\Exception $e){
                dd($e);
                return response()->json(["error"=>"Không thành công"]);
            }
          
            
        }
    }

?>