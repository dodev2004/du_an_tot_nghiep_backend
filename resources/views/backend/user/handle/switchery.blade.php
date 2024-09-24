<script>
    $(document).ready(function(){
        var switcheryInputs = document.querySelectorAll(".js-switch");
            switcheryInputs.forEach(function(switchery){
              new Switchery(switchery, { color: '#1AB394' });
                switchery.onchange = function(){
                    let _token = switchery.parentElement.querySelector("input[name=_token]").value;
                    let table  = switchery.parentElement.querySelector("input[name=table]").value;
                    let id = this.dataset.id;
                    
                    let status = this.checked ? 1 : 0;
                    $.ajax({
                        type: "POST",
                        url : '{{ route("ajax.changeStatus")}}',
                        data : {
                            status,
                           id,
                           table,
                           _token
                        },
                        dataType: "json",
                        headers :{
                            "X-HTTP-Method-Override":  "PUT"
                        },
                        success : function(res){
                                console.log(res);
                        }
                    })
                }
            })

    })
</script>
{{-- Phần switch ở trang đanh sách --}}