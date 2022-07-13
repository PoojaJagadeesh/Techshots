
<script src="{{ asset('assets/js/all.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/scripts.js') }}"></script>
<script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/demo/datatables-demo.js') }}"></script>
<script type="text/javascript">
   $(document).ready(function(){

     var profile = $("#profilediv");

     /* display the register page */
     $("#profileicon").on("click", function(e){
       e.preventDefault();

       $(profile).toggle("slide");


     });

    $("#profileclose").on("click", function(e){
       e.preventDefault();
       $(profile).css("display", "none");
          
     });
   });

</script>
