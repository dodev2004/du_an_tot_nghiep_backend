
<script>
    $(document).ready(function(){
        $(".form-user_catelogue_create").submit(function(){
            event.preventDefault();
            let _token = $("input[name='_token'").val()
            let data =  new FormData();
            const inputs = Array.from(this.querySelectorAll(".form-control"));
         
            inputs.forEach(function(input){
                    data.append(input.name,input.value.trim());
                   
            })
            data.append("_token",_token);
          
            $.ajax({
            url : '{{route('admin.promotions.store')}}',
            type: "POST",
            dataType: "json",
            data : data,
            contentType: false,
            processData: false,
            success : function(res){
                
                toastMessage(res[1],res[0],"http://127.0.0.1:8000/admin/promotions/list")
                
            },
            error : function(error){
            let errors =  error.responseJSON.errors;
                Object.keys(errors).forEach(function(error){
                    const input = document.querySelector(`input[name="${error}"]`);
                    const select = document.querySelector(`select[name="${error}"]`)
                    if(input){
                    const message = input.parentElement.querySelector("p");
                        message.innerText = errors[error]

                    }
                    if(select){
                        const message = select.parentElement.querySelector("p");
                        message.innerText = errors[error]
                    }
                })
            }
        })
        })
    })
</script>