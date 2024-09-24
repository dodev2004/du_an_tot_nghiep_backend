 <!-- Toastr -->
 <script src="{{asset("backend/js/plugins/toastr/toastr.min.js")}}"></script>
<script>
     $(document).ready(function() {
        setTimeout(function() {
                    toastr.options = {
                    "closeButton": true,
                    "debug": false,
                    "newestOnTop": true,
                    "progressBar": true,
                    "positionClass": "toast-top-right",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "100",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "500",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
         }
         @session("msg")
            toastr.success('{{$value}}', '{{$title}}');
         @endsession
        }, 1300);
    })
</script>