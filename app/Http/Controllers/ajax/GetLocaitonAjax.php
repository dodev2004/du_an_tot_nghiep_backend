<?php 
    namespace App\Http\Controllers\ajax;
    use App\Repositories\Interfaces\DistrictRepositoryInterface;
    use App\Repositories\Interfaces\WardRepositoryInterface;
    class GetLocaitonAjax {
        protected $districs ,$wards;
        public function __construct(
            DistrictRepositoryInterface $districs,
            WardRepositoryInterface $wards  
        )
        {
            $this->districs = $districs;
            $this->wards = $wards;
        }
        public function index(){
         $target = request()->target;
         $data = request()->data;
        if($target == "district"){
            return response()->json(["content" => $this->districs->findDistrictByIdProvince($data["province_id"])]);
        }
        else if($target == "ward"){
            return response()->json(["content" => $this->wards->findWardByIdDistrict($data["district_id"])]);
        }
        }
    }

?>