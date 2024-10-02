
<script>
    $(document).ready(function(){

        $(".form-seo").submit(function(){
            event.preventDefault();
            let catelogues = [];
            let _token = $("input[name='_token'").val()
            let data =  new FormData();
            const inputs = Array.from(this.querySelectorAll(".form-control"));
            const catelogueElem = Array.from(this.querySelectorAll('input[name="post_catelogue_id"]'));
            inputs.forEach(function(input){
                    data.append(input.name,input.value.trim());
                   
            })
            catelogueElem.forEach(function(catelogue){
                if(catelogue.checked){
                    catelogues.push(Number(catelogue.value) )
                }
                
            })
            data.append("_token",_token); 
               data.append("post_catelogue_id",catelogues)
            console.log(data);
            
            $.ajax({
            url : '{{route('admin.post.store')}}',
            type: "POST",
            dataType: "json",
            data : data,
            contentType: false,
            processData: false,
            success : function(res){
                toastMessage(res[1],res[0],'{{route('admin.post-catelogue')}}')
                
            },
            error : function(error){
            let errors =  error.responseJSON.errors;
          
                Object.keys(errors).forEach(function(error){
                    const input = document.querySelector(`input[name="${error}"]`);
                    const select = document.querySelector(`select[name="${error}"]`)
                    const textarea = document.querySelector(`textarea[name="${error}"]`)
                   
                    if(input){
                    const message = input.parentElement.querySelector("span");
                        message.innerText = errors[error]

                    }
                    if(select){
                        const message = select.parentElement.querySelector(".message-error");

                        message.innerText = errors[error]
                       
                    }
                    if(textarea){
                        const message = textarea.parentElement.querySelector(".text-danger");
                        console.log(message);
                        message.innerText = errors[error]
                    }
                })
            }
        })
        })
    })
</script>