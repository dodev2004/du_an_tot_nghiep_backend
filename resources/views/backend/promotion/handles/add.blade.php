<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function(){
        $(".form-user_catelogue_create").submit(function(event){
            event.preventDefault();
            let _token = $("input[name='_token']").val();
            let data =  new FormData();
            const inputs = Array.from(this.querySelectorAll(".form-control"));
         
            inputs.forEach(function(input){
                data.append(input.name, input.value.trim());
            });
            data.append("_token", _token);
          
            $.ajax({
                url : '{{ route('admin.promotions.store') }}',
                type: "POST",
                dataType: "json",
                data : data,
                contentType: false,
                processData: false,
                success : function(res){
                    // Hiển thị thông báo thêm mới thành công bằng SweetAlert
                    Swal.fire({
                        icon: 'success',
                        title: 'Thêm mới thành công',
                        text: 'Bạn có muốn tiếp tục không?',
                        confirmButtonText: 'Tiếp tục',
                        confirmButtonColor: '#6f42c1',
                        customClass: {
                            confirmButton: 'btn btn-primary' // Thêm lớp CSS tùy chỉnh cho nút
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "http://127.0.0.1:8000/admin/promotions/list";
                        }
                    });
                },
                error : function(error){
                    let errors =  error.responseJSON.errors;
                    Object.keys(errors).forEach(function(error){
                        const input = document.querySelector(`input[name="${error}"]`);
                        const select = document.querySelector(`select[name="${error}"]`);
                        if(input){
                            const message = input.parentElement.querySelector("p");
                            message.innerText = errors[error];
                        }
                        if(select){
                            const message = select.parentElement.querySelector("p");
                            message.innerText = errors[error];
                        }
                    });
                }
            });
        });
    });
</script>
