<script>
    $(document).ready(function(){
        var switcheryInputs = document.querySelectorAll(".js-switch");
            switcheryInputs.forEach(function(switchery){
              new Switchery(switchery, { size: 'small' });
                switchery.onchange = function(){
                    let _token = switchery.parentElement.querySelector("input[name=_token]").value;
                    let table = switchery.parentElement.querySelector("input[name=table]").value;
                    let attribute = switchery.parentElement.querySelector("input[name=attribute]").value;
                    let id = this.dataset.id;
                    let data = this.checked ? 1 : 0;
                    $.ajax({
                        type: "POST",
                        url : '{{ route("ajax.changeStatus")}}',
                        data : {
                            data,
                           id,
                           table : table,
                           _token,
                           attribute
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