<script>
    window.onload = function (){
        const  form = document.querySelectorAll(".form-delete");
        form.forEach(form =>{
            form.addEventListener("submit",handleSubmit);
        })
       function handleSubmit(){
        event.preventDefault();
        const textUrl = this.dataset.url.trim();
        const id = this.querySelector(`input[name=id]`).value;
        const _token = document.querySelector("input[name=_token]").value;

        const url = window.location.origin + "/admin/" + textUrl  + "/delete";
        const element = this.parentElement.parentElement.parentElement;
        const tbodyElement  = element.parentElement;
        console.log(element,tbodyElement);
        
        const data = {
            id,_token
        }
        alertleDelete(data,element,tbodyElement,url);
       }
    }
</script>