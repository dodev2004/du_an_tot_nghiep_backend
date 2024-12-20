
    window.toastMessage = function(title,icon,href){
    Swal.fire({
        title: title,
        text: 'Bạn có muốn tiếp tục?',
        icon: icon,
        confirmButtonText: 'Tiếp tục'
        }).then(function(res){
            if(icon == "error"){
                Swal.fire({
                    title: 'Error!',
                    text: 'Có lỗi xảy ra vui lòng thử lại',
                    icon: 'error',
                    confirmButtonText: 'Quay lại'
                })   
            }
            else {
                window.location.href = href
            }
            
        })
    }