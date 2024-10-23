
<script>
    $(document).ready(function(){
        $("form").submit(function(){
            event.preventDefault();
            const uploadfile = document.querySelector('#upload-file');
            let _token = $("input[name='_token'").val()
            let data =  new FormData();
           const inputs = Array.from(this.querySelectorAll(".form-control"));
           inputs.shift();
           inputs.forEach(function(input){
                if(input.name  == "role_id"){
                   const selectedValues = Array.from(input.selectedOptions).map(option => option.value);
                   data.append(input.name,selectedValues.join(","));
                }
                else {
                     data.append(input.name,input.value);
                }

           })
          data.append("_token",_token);
          if(uploadfile){
            data.append("avatar",uploadfile.files[0] || "");
          }
           $.ajax({
            url : '{{route('admin.users.update',$id)}}',
            type: "POST",
            dataType: "json",
            data : data,
            contentType: false,
            processData: false,
            headers :{
                'X-HTTP-Method-Override':'PUT'
            },
            success : function(res){

                toastMessage(res[1],res[0],"http://127.0.0.1:8000/admin/users/list")

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
