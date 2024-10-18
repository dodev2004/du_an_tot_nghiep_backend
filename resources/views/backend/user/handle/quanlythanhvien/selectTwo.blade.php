<script>

    $(document).ready(function() {
    $('.province').select2();
    $('.district').select2();
    $('.ward').select2();
    $(".roles").select2();
    $(".province").change(function(){

        var idProvice = $(this).val();
        $(".district").html("<option selected value=''>Vui lòng chọn quận huyện</option>");
        $.ajax({
            url : "{{route("ajax.getLocation")}}",
            data : {
               "data" : {
                "province_id" : idProvice
               },
               "target" : "district"
            },
            type: "GET",
            success : function(res){

                $(".district").append(res.content);
            },
            eror: function(){
                console.log("Lỗi dữ liệu");
            }
        })
    })
    $(".district").change(function(){
        var idDistrict = $(this).val();
        console.log(idDistrict);
        $(".ward").html("<option selected value=''>Vui lòng chọn phường (xã)</option>");
        $.ajax({
            url : "{{route("ajax.getLocation")}}",
            data : {
               "data" : {
                "district_id" : idDistrict
               },
               "target" : "ward"
            },
            type: "GET",
            success : function(res){
                $(".ward").append(res.content);
            }
        })
    })
});
</script>
