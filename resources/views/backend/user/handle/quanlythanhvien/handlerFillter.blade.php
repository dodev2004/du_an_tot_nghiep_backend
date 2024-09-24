<script>
    const seach = document.querySelector('.seach');
    seach.addEventListener("click",handleSubmit);
    function handleSubmit (){
        event.preventDefault();
        console.log(this);
       const inputName = this.parentElement.querySelector("input[name=seach_text]").value 
       const inputRule = this.parentElement.querySelector("select[name=seach_rule]").value ;
       const  url = `{{route('admin.users')}}?name=${inputName}&rule_id=${inputRule}`
       window.location.href = url;
    }
</script>