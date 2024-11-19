window.alertleDelete = function (data,element,parentElement,url){
  console.log(url);
 
    Swal.fire({
        title: "Bạn có muốn xóa",
        text: "Bạn không thể hoàn tác thao tác này",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Đúng tôi muốn xóa"
      }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type : "POST",
                url : url,
                data : data,
                dataType : "json", 
                headers: {
                    "X-HTTP-Method-Override": "DELETE",
                },
                success : function(res){
                    Swal.fire({
                        title: "Xóa!",
                        text: "Xóa thành công.",
                        icon: "success"
                      }).then(result =>{
                        parentElement.removeChild(element);
                      });
                }
               })
      
        }
      });
}