<script>
$(document).ready(function(){
    $(".form-update").submit(function(event){
        event.preventDefault();
        let _token = $("input[name='_token']").val();
        let data = new FormData();
        const inputs = Array.from(this.querySelectorAll(".form-control"));
        inputs.forEach(function(input){
            data.append(input.name,input.value);
        });
        data.append("_token",_token);
        $.ajax({
            url : $(this).attr('action'),
            type: "POST",
            dataType: "json",
            data : data,
            contentType: false,
            processData: false,
            headers :{
                'X-HTTP-Method-Override':'PUT'
            },
            success : function(res){
                Swal.fire({
                    icon: 'success',
                    title: 'Cập nhật thành công',
                    text: 'Do you want to continue?',
                    confirmButtonText: 'Tiếp tục',
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Chuyển hướng đến trang danh sách phương thức thanh toán
                        window.location.href = '{{ route('admin.payment_methods') }}'; 
                    }
                });
            },
            error : function(error){
                // Xóa các thông báo lỗi cũ trước khi hiển thị lỗi mới
                $('.text-danger').text(''); 

                if (error.responseJSON && error.responseJSON.errors) {
                    let errors = error.responseJSON.errors;
                    Object.keys(errors).forEach(function(error){
                        const input = document.querySelector(`input[name="${error}"]`);
                        const select = document.querySelector(`select[name="${error}"]`);
                        const textarea = document.querySelector(`textarea[name="${error}"]`);
                        if(input){
                            const message = input.parentElement.querySelector(".text-danger");
                            message.innerText = errors[error][0]; // Lấy thông báo lỗi đầu tiên
                        }
                        if(select){
                            const message = select.parentElement.querySelector(".text-danger");
                            message.innerText = errors[error][0];
                        }
                        if(textarea){
                            const message = textarea.parentElement.querySelector(".text-danger");
                            message.innerText = errors[error][0];
                        }
                    });
                } else {
                    // Xử lý trường hợp không có errors, ví dụ:
                    console.error("Lỗi không xác định:", error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Đã xảy ra lỗi. Vui lòng thử lại sau!'
                    });
                }
            }
        });
    });
});
</script>