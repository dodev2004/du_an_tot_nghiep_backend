<script>
    $(document).ready(function(){
        // Function to handle restore action
        $(".form-restore").submit(function(event){
            event.preventDefault(); // Ngăn chặn hành động mặc định của form

            let _token = $("input[name='_token']").val(); // Lấy token bảo mật
            let commentId = $(this).find("input[name='id']").val(); // Lấy id bình luận cần khôi phục
            let restoreUrl = $(this).attr("data-url") + "/restore"; // Lấy url từ data-url attribute

            $.ajax({
                url: restoreUrl,
                type: "POST",
                data: {
                    _token: _token,
                    id: commentId
                },
                success: function(res){
                    if(res.success){
                        toastMessage("success", "Khôi phục thành công!", "{{route('admin.product_comment.trash')}}");
                        location.reload(); // Reload lại trang sau khi thành công
                    } else {
                        toastMessage("error", "Khôi phục thất bại, vui lòng thử lại.");
                    }
                },
                error: function(error){
                    let errors = error.responseJSON.errors;
                    Object.keys(errors).forEach(function(field){
                        const input = document.querySelector(`input[name="${field}"]`);
                        const select = document.querySelector(`select[name="${field}"]`);
                        if(input){
                            const message = input.parentElement.querySelector("p");
                            message.innerText = errors[field];
                        }
                        if(select){
                            const message = select.parentElement.querySelector(".message-error");
                            message.innerText = errors[field];
                        }
                    });
                }
            });
        });
    });
</script>
