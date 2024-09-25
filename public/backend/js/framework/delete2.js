window.alertleDelete = function (data,element,parentElement,url){
  console.log(url);
 
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
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
                        title: "Deleted!",
                        text: "Your file has been deleted.",
                        icon: "success"
                      }).then(result =>{
                        parentElement.removeChild(element);
                      });
                }
               })
      
        }
      });
}